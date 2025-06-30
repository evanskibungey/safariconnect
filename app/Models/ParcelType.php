<?php

// Model 5: ParcelType.php
// File: app/Models/ParcelType.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParcelType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'max_weight_kg',
        'max_dimensions',
        'base_rate',
        'is_active',
    ];

    protected $casts = [
        'max_weight_kg' => 'decimal:2',
        'base_rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper methods
    public function getFormattedBaseRateAttribute()
    {
        return 'KSh ' . number_format($this->base_rate, 2);
    }

    public function getWeightLimitAttribute()
    {
        return $this->max_weight_kg . ' kg';
    }
}