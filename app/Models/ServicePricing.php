<?php

// Model 4: ServicePricing.php
// File: app/Models/ServicePricing.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServicePricing extends Model
{
    use HasFactory;

    protected $table = 'service_pricing';

    protected $fillable = [
        'transportation_service_id',
        'pickup_city_id',
        'dropoff_city_id',
        'pickup_airport_id',
        'dropoff_airport_id',
        'vehicle_type_id',
        'base_price',
        'price_per_km',
        'price_per_day',
        'airport_pickup_surcharge',
        'airport_dropoff_surcharge',
        'transfer_type',
        'parcel_type',
        'weight_limit',
        'distance_km',
        'weekend_surcharge_percentage',
        'night_surcharge_percentage',
        'night_start_time',
        'night_end_time',
        'is_active',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'price_per_km' => 'decimal:2',
        'price_per_day' => 'decimal:2',
        'airport_pickup_surcharge' => 'decimal:2',
        'airport_dropoff_surcharge' => 'decimal:2',
        'weight_limit' => 'decimal:2',
        'distance_km' => 'integer',
        'weekend_surcharge_percentage' => 'decimal:2',
        'night_surcharge_percentage' => 'decimal:2',
        'night_start_time' => 'datetime:H:i',
        'night_end_time' => 'datetime:H:i',
        'is_active' => 'boolean',
    ];

    // Transfer type constants
    const TRANSFER_TYPES = [
        'pickup' => 'Airport Pickup',
        'dropoff' => 'Airport Drop-off',
    ];

    const PARCEL_TYPES = [
        'documents' => 'Documents',
        'small' => 'Small Package',
        'medium' => 'Medium Package',
        'large' => 'Large Package',
    ];

    // Relationships
    public function transportationService(): BelongsTo
    {
        return $this->belongsTo(TransportationService::class);
    }

    public function pickupCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'pickup_city_id');
    }

    public function dropoffCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'dropoff_city_id');
    }

    public function vehicleType(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function pickupAirport(): BelongsTo
    {
        return $this->belongsTo(Airport::class, 'pickup_airport_id');
    }

    public function dropoffAirport(): BelongsTo
    {
        return $this->belongsTo(Airport::class, 'dropoff_airport_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForRoute($query, $pickupCityId, $dropoffCityId)
    {
        return $query->where('pickup_city_id', $pickupCityId)
                    ->where('dropoff_city_id', $dropoffCityId);
    }

    // Helper methods
    public function getFormattedBasePriceAttribute()
    {
        return 'KSh ' . number_format($this->base_price, 2);
    }

    public function getRouteDescriptionAttribute()
    {
        // For airport transfers, show airport and city information
        if ($this->transportationService && $this->transportationService->service_type === 'airport_transfer') {
            if ($this->transfer_type === 'pickup') {
                $airport = $this->pickupAirport ? $this->pickupAirport->full_name : 'Airport';
                $city = $this->dropoffCity ? $this->dropoffCity->name : 'City';
                return $airport . ' → ' . $city;
            } elseif ($this->transfer_type === 'dropoff') {
                $city = $this->pickupCity ? $this->pickupCity->name : 'City';
                $airport = $this->dropoffAirport ? $this->dropoffAirport->full_name : 'Airport';
                return $city . ' → ' . $airport;
            }
        }
        
        // For regular city-to-city routes
        if ($this->pickupCity && $this->dropoffCity) {
            return $this->pickupCity->name . ' → ' . $this->dropoffCity->name;
        }
        
        if ($this->pickupCity) {
            return 'From ' . $this->pickupCity->name;
        }
        
        if ($this->dropoffCity) {
            return 'To ' . $this->dropoffCity->name;
        }
        
        return 'No route specified';
    }

    public function getTransferTypeNameAttribute()
    {
        return self::TRANSFER_TYPES[$this->transfer_type] ?? $this->transfer_type;
    }

    public function getParcelTypeNameAttribute()
    {
        return self::PARCEL_TYPES[$this->parcel_type] ?? $this->parcel_type;
    }

    // Calculate total price with surcharges
    public function calculateTotalPrice($datetime = null, $isWeekend = false)
    {
        $price = $this->base_price;
        
        // Add weekend surcharge
        if ($isWeekend && $this->weekend_surcharge_percentage > 0) {
            $price += ($price * $this->weekend_surcharge_percentage / 100);
        }
        
        // Add night surcharge
        if ($datetime && $this->isNightTime($datetime)) {
            $price += ($price * $this->night_surcharge_percentage / 100);
        }
        
        return $price;
    }

    private function isNightTime($datetime)
    {
        $time = date('H:i', strtotime($datetime));
        $nightStart = $this->night_start_time->format('H:i');
        $nightEnd = $this->night_end_time->format('H:i');
        
        if ($nightStart > $nightEnd) {
            // Night time spans midnight
            return $time >= $nightStart || $time <= $nightEnd;
        }
        
        return $time >= $nightStart && $time <= $nightEnd;
    }
}