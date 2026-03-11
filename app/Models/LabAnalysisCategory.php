<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;

class LabAnalysisCategory extends Model
{
    use HasFactory, HasTranslations;

    protected array $translatable = ['name'];

    protected $fillable = [
        'name',
        'slug',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function analyses()
    {
        return $this->hasMany(LabAnalysis::class, 'category_id')->orderBy('order');
    }

    public function activeAnalyses()
    {
        return $this->hasMany(LabAnalysis::class, 'category_id')->where('is_active', true)->orderBy('order');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
