<?php

namespace App\Traits;

use App\Models\Translation;

trait HasTranslations
{
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function getTranslation(string $field, string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        
        $translation = $this->translations
            ->where('field', $field)
            ->where('locale', $locale)
            ->first();

        return $translation?->value;
    }

    public function translate(string $field, string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();
        $defaultLocale = config('app.fallback_locale', 'mk');

        // Try requested locale first
        $value = $this->getTranslation($field, $locale);
        
        // Fall back to default locale
        if ($value === null && $locale !== $defaultLocale) {
            $value = $this->getTranslation($field, $defaultLocale);
        }

        // Fall back to original field value
        if ($value === null && isset($this->{$field})) {
            $value = $this->{$field};
        }

        return $value;
    }

    public function setTranslation(string $field, string $locale, ?string $value): void
    {
        $this->translations()->updateOrCreate(
            [
                'field' => $field,
                'locale' => $locale,
            ],
            [
                'value' => $value,
            ]
        );
    }

    public function setTranslations(array $translations): void
    {
        foreach ($translations as $locale => $fields) {
            foreach ($fields as $field => $value) {
                $this->setTranslation($field, $locale, $value);
            }
        }
    }

    public function getTranslationsArray(): array
    {
        $result = [];
        
        foreach ($this->translations as $translation) {
            $result[$translation->locale][$translation->field] = $translation->value;
        }

        return $result;
    }
}
