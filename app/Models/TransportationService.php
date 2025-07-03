<?php

// Model 3: TransportationService.php
// File: app/Models/TransportationService.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransportationService extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'service_type',
        'description',
        'pricing_model',
        'features',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
    ];

    // Service type constants
    const SERVICE_TYPES = [
        'shared_ride' => 'Shared Ride',
        'solo_ride' => 'Solo Ride',
        'airport_transfer' => 'Airport Transfer',
        'car_hire' => 'Car Hire',
        'parcel_delivery' => 'Parcel Delivery',
    ];

    const PRICING_MODELS = [
        'city_based' => 'City Based',
        'vehicle_city_based' => 'Vehicle & City Based',
        'vehicle_transfer_based' => 'Vehicle & Transfer Based',
        'time_based' => 'Time Based',
        'weight_location_based' => 'Weight & Location Based',
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

    public function scopeByType($query, $type)
    {
        return $query->where('service_type', $type);
    }

    // Helper methods
    public function getServiceTypeNameAttribute()
    {
        return self::SERVICE_TYPES[$this->service_type] ?? $this->service_type;
    }

    public function getPricingModelNameAttribute()
    {
        return self::PRICING_MODELS[$this->pricing_model] ?? $this->pricing_model;
    }

    public function getFeaturesListAttribute()
    {
        return $this->features ? implode(', ', $this->features) : '';
    }

    // Pricing calculation methods
    public function calculatePrice($params = [])
    {
        switch ($this->service_type) {
            case 'shared_ride':
                return $this->calculateSharedRidePrice($params);
            case 'solo_ride':
                return $this->calculateSoloRidePrice($params);
            case 'airport_transfer':
                return $this->calculateAirportTransferPrice($params);
            case 'car_hire':
                return $this->calculateCarHirePrice($params);
            case 'parcel_delivery':
                return $this->calculateParcelDeliveryPrice($params);
            default:
                return 0;
        }
    }

    private function calculateSharedRidePrice($params)
    {
        $pricing = $this->servicePricing()
            ->where('pickup_city_id', $params['pickup_city_id'])
            ->where('dropoff_city_id', $params['dropoff_city_id'])
            ->where('is_active', true)
            ->first();

        return $pricing ? $pricing->base_price : 0;
    }

    private function calculateSoloRidePrice($params)
    {
        $pricing = $this->servicePricing()
            ->where('pickup_city_id', $params['pickup_city_id'])
            ->where('dropoff_city_id', $params['dropoff_city_id'])
            ->where('vehicle_type_id', $params['vehicle_type_id'])
            ->where('is_active', true)
            ->first();

        return $pricing ? $pricing->base_price : 0;
    }

    private function calculateAirportTransferPrice($params)
    {
        $query = $this->servicePricing()
            ->where('vehicle_type_id', $params['vehicle_type_id'])
            ->where('transfer_type', $params['transfer_type'])
            ->where('is_active', true);

        // For airport transfers, match based on the transfer type
        if ($params['transfer_type'] === 'pickup') {
            $query->where('pickup_airport_id', $params['pickup_airport_id'] ?? null)
                  ->where('dropoff_city_id', $params['dropoff_city_id'] ?? null);
        } else {
            $query->where('pickup_city_id', $params['pickup_city_id'] ?? null)
                  ->where('dropoff_airport_id', $params['dropoff_airport_id'] ?? null);
        }

        $pricing = $query->first();

        if (!$pricing) return 0;

        $price = $pricing->base_price;
        
        if ($params['transfer_type'] === 'pickup') {
            $price += $pricing->airport_pickup_surcharge;
        } else {
            $price += $pricing->airport_dropoff_surcharge;
        }

        return $price;
    }

    private function calculateCarHirePrice($params)
    {
        $pricing = $this->servicePricing()
            ->where('vehicle_type_id', $params['vehicle_type_id'])
            ->where('is_active', true)
            ->first();

        if (!$pricing) return 0;

        $days = $params['hire_days'] ?? 1;
        return $pricing->price_per_day * $days;
    }

    private function calculateParcelDeliveryPrice($params)
    {
        $pricing = $this->servicePricing()
            ->where('pickup_city_id', $params['pickup_city_id'])
            ->where('dropoff_city_id', $params['dropoff_city_id'])
            ->where('parcel_type', $params['parcel_type'])
            ->where('is_active', true)
            ->first();

        return $pricing ? $pricing->base_price : 0;
    }
}