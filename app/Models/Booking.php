<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_reference',
        'transportation_service_id',
        'service_pricing_id',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'pickup_city_id',
        'dropoff_city_id',
        'pickup_airport_id',
        'dropoff_airport_id',
        'vehicle_type_id',
        'driver_id',
        'travel_date',
        'travel_time',
        'passengers',
        'transfer_type',
        'price_per_unit',
        'total_price',
        'surcharge_amount',
        'status',
        'payment_status',
        'payment_method',
        'transaction_id',
        'special_requirements',
        'admin_notes',
        'confirmed_at',
        'driver_assigned_at',
        'cancelled_at',
        'cancellation_reason',
    ];

    protected $casts = [
        'travel_date' => 'date',
        'passengers' => 'integer',
        'price_per_unit' => 'decimal:2',
        'total_price' => 'decimal:2',
        'surcharge_amount' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'driver_assigned_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    const PAYMENT_STATUS_PENDING = 'pending';
    const PAYMENT_STATUS_PAID = 'paid';
    const PAYMENT_STATUS_REFUNDED = 'refunded';

    // Relationships
    public function transportationService(): BelongsTo
    {
        return $this->belongsTo(TransportationService::class);
    }

    public function servicePricing(): BelongsTo
    {
        return $this->belongsTo(ServicePricing::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pickupCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'pickup_city_id');
    }

    public function dropoffCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'dropoff_city_id');
    }

    public function pickupAirport(): BelongsTo
    {
        return $this->belongsTo(Airport::class, 'pickup_airport_id');
    }

    public function dropoffAirport(): BelongsTo
    {
        return $this->belongsTo(Airport::class, 'dropoff_airport_id');
    }

    public function vehicleType(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('travel_date', '>=', now()->toDateString())
                     ->whereIn('status', [self::STATUS_PENDING, self::STATUS_CONFIRMED]);
    }

    public function scopeForCustomer($query, $email)
    {
        return $query->where('customer_email', $email);
    }

    // Helper methods
    public function getRouteDescriptionAttribute()
    {
        if ($this->transportationService && $this->transportationService->service_type === 'airport_transfer') {
            if ($this->transfer_type === 'pickup' && $this->pickupAirport && $this->dropoffCity) {
                return $this->pickupAirport->name . ' → ' . $this->dropoffCity->name;
            } elseif ($this->transfer_type === 'dropoff' && $this->pickupCity && $this->dropoffAirport) {
                return $this->pickupCity->name . ' → ' . $this->dropoffAirport->name;
            }
        }

        if ($this->pickupCity && $this->dropoffCity) {
            return $this->pickupCity->name . ' → ' . $this->dropoffCity->name;
        }

        return 'Route not specified';
    }

    public function getTravelDateTimeAttribute()
    {
        return $this->travel_date->format('Y-m-d') . ' ' . $this->travel_time;
    }

    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::STATUS_CONFIRMED => 'bg-blue-100 text-blue-800',
            self::STATUS_IN_PROGRESS => 'bg-purple-100 text-purple-800',
            self::STATUS_COMPLETED => 'bg-green-100 text-green-800',
            self::STATUS_CANCELLED => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getPaymentStatusBadgeClassAttribute()
    {
        return match($this->payment_status) {
            self::PAYMENT_STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            self::PAYMENT_STATUS_PAID => 'bg-green-100 text-green-800',
            self::PAYMENT_STATUS_REFUNDED => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    // Methods
    public function confirm()
    {
        $this->update([
            'status' => self::STATUS_CONFIRMED,
            'confirmed_at' => now(),
        ]);
    }

    public function cancel($reason = null)
    {
        $this->update([
            'status' => self::STATUS_CANCELLED,
            'cancelled_at' => now(),
            'cancellation_reason' => $reason,
        ]);
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
        ]);
    }

    public function markAsPaid($paymentMethod = null, $transactionId = null)
    {
        $this->update([
            'payment_status' => self::PAYMENT_STATUS_PAID,
            'payment_method' => $paymentMethod,
            'transaction_id' => $transactionId,
        ]);
    }

    public function assignDriver(Driver $driver)
    {
        $this->update([
            'driver_id' => $driver->id,
            'driver_assigned_at' => now(),
        ]);
        
        $driver->setBusy();
    }

    public function generateBookingReference()
    {
        $prefix = match($this->transportationService->service_type) {
            'shared_ride' => 'SR',
            'solo_ride' => 'SL',
            'airport_transfer' => 'AT',
            'car_hire' => 'CH',
            'parcel_delivery' => 'PD',
            default => 'BK',
        };

        return $prefix . date('Ymd') . strtoupper(substr(md5(uniqid()), 0, 6));
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_reference)) {
                $booking->booking_reference = $booking->generateBookingReference();
            }
        });
    }
}
