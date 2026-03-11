<?php

namespace Database\Seeders;

use App\Models\Section;
use App\Models\Translation;
use Illuminate\Database\Seeder;

class LabDisclaimerSeeder extends Seeder
{
    public function run(): void
    {
        $section = Section::firstOrCreate(
            ['key' => 'lab_disclaimer'],
            [
                'title' => 'Лабораторија - Напомена',
                'content' => '<p>ПЗУ Медика работи и со Фондот за здравствено осигурување на Македонија.</p><p>Сите цени на анализите се изразени како анализи на приватно.</p>',
                'data' => [],
                'is_active' => true,
            ]
        );

        // English translations
        $enTranslations = [
            'title' => 'Laboratory - Notice',
            'content' => '<p>PZU Medica also works with the Health Insurance Fund of Macedonia.</p><p>All analysis prices are expressed as private analysis prices.</p>',
        ];

        foreach ($enTranslations as $field => $value) {
            Translation::firstOrCreate(
                [
                    'translatable_type' => 'App\\Models\\Section',
                    'translatable_id' => $section->id,
                    'locale' => 'en',
                    'field' => $field,
                ],
                ['value' => $value]
            );
        }

        $this->command->info('Lab disclaimer section seeded successfully.');
    }
}
