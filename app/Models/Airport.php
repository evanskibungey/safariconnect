<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Airport extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'city_id',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function pickupPricing(): HasMany
    {
        return $this->hasMany(ServicePricing::class, 'pickup_airport_id');
    }

    public function dropoffPricing(): HasMany
    {
        return $this->hasMany(ServicePricing::class, 'dropoff_airport_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCity($query, $cityId)
    {
        return $query->where('city_id', $cityId);
    }

    // Helper methods
    public function getFullNameAttribute()
    {
        return $this->name . ($this->code ? ' (' . $this->code . ')' : '');
    }

    public function getLocationAttribute()
    {
        return $this->city ? $this->name . ', ' . $this->city->name : $this->name;
    }
}
