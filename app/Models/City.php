<?php

// Model 1: City.php
// File: app/Models/City.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'state',
        'country',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function pickupPricing(): HasMany
    {
        return $this->hasMany(ServicePricing::class, 'pickup_city_id');
    }

    public function dropoffPricing(): HasMany
    {
        return $this->hasMany(ServicePricing::class, 'dropoff_city_id');
    }

    public function airports(): HasMany
    {
        return $this->hasMany(Airport::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper methods
    public function getFullNameAttribute()
    {
        return $this->name . ($this->state ? ', ' . $this->state : '');
    }
}