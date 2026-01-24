<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;

class Slider extends Model
{
    use HasFactory, HasTranslations;

    protected array $translatable = ['title', 'subtitle', 'description', 'button_text', 'button2_text'];

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'image',
        'button_text',
        'button_link',
        'button2_text',
        'button2_link',
        'order',
        'is_active',
    ];

    protected $casts = [
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
