<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Section extends Model
{
    use HasTranslations;

    protected array $translatable = ['title', 'content', 'data.address', 'data.description', 'data.lead_text', 'data.additional_text'];
    protected $fillable = [
        'key',
        'title',
        'content',
        'data',
        'is_active',
    ];

    protected $casts = [
        'data' => 'array',
        'is_active' => 'boolean',
    ];

    public static function getByKey(string $key)
    {
        return static::where('key', $key)->first();
    }

    public static function getData(string $key, $default = null)
    {
        $section = static::getByKey($key);
        return $section ? $section->data : $default;
    }
}
