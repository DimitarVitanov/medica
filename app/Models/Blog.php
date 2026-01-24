<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;

class Blog extends Model
{
    use HasFactory, HasTranslations;

    protected array $translatable = ['title', 'excerpt', 'content'];

    protected $fillable = [
        'title',
        'slug',
        'author',
        'category',
        'excerpt',
        'content',
        'image',
        'published_at',
        'is_published',
        'views',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'date',
    ];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function incrementViews()
    {
        $this->increment('views');
    }
}
