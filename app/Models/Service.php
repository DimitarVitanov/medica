<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;

class Service extends Model
{
    use HasFactory, HasTranslations;

    protected array $translatable = ['title', 'short_description', 'description'];

    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'features',
        'icon',
        'color',
        'image',
        'order',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
