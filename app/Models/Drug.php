<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Drug extends Model
{
    protected $fillable = [
        'name', 'slug', 'generic_name', 'category', 'form', 'manufacturer',
        'content', 'indication', 'dosage', 'how_to_use', 'side_effects',
        'contraindication', 'warning', 'price_range', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    protected static function booted(): void
    {
        static::creating(function (Drug $drug) {
            if (!$drug->slug) {
                $drug->slug = Str::slug($drug->name);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
