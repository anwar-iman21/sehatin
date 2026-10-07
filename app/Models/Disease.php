<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Disease extends Model
{
    protected $fillable = [
        'name', 'slug', 'category', 'overview', 'symptoms', 'causes',
        'risk_factors', 'diagnosis', 'treatment', 'prevention',
        'when_to_see_doctor', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    protected static function booted(): void
    {
        static::creating(function (Disease $disease) {
            if (!$disease->slug) {
                $disease->slug = Str::slug($disease->name);
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
