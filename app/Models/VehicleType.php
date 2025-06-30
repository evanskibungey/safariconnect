<?php

// Model 2: VehicleType.php
// File: app/Models/VehicleType.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VehicleType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'capacity',
        'description',
        'base_rate',
        'is_active',
    ];

    protected $casts = [
        'capacity' => 'integer',
        'base_rate' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function servicePricing(): HasMany
    {
        return $this->hasMany(ServicePricing::class);
    }

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
}