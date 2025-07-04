<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'license_number',
        'license_expiry',
        'vehicle_registration',
        'vehicle_type_id',
        'status',
        'is_active',
        'rating',
        'total_trips',
    ];

    protected $casts = [
        'license_expiry' => 'date',
        'is_active' => 'boolean',
        'rating' => 'decimal:2',
        'total_trips' => 'integer',
    ];

    // Status constants
    const STATUS_AVAILABLE = 'available';
    const STATUS_BUSY = 'busy';
    const STATUS_OFFLINE = 'offline';

    // Relationships
    public function vehicleType(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', self::STATUS_AVAILABLE)
                     ->where('is_active', true);
    }

    public function scopeForVehicleType($query, $vehicleTypeId)
    {
        return $query->where('vehicle_type_id', $vehicleTypeId);
    }

    // Helper methods
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            self::STATUS_AVAILABLE => 'bg-green-100 text-green-800',
            self::STATUS_BUSY => 'bg-yellow-100 text-yellow-800',
            self::STATUS_OFFLINE => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getRatingDisplayAttribute()
    {
        if ($this->total_trips == 0) {
            return 'New Driver';
        }
        return number_format($this->rating, 1) . '/5.0';
    }

    // Methods
    public function setAvailable()
    {
        $this->update(['status' => self::STATUS_AVAILABLE]);
    }

    public function setBusy()
    {
        $this->update(['status' => self::STATUS_BUSY]);
    }

    public function setOffline()
    {
        $this->update(['status' => self::STATUS_OFFLINE]);
    }

    public function canBeAssigned()
    {
        return $this->is_active && 
               $this->status === self::STATUS_AVAILABLE &&
               $this->license_expiry->isFuture();
    }

    public function updateRating($newRating)
    {
        if ($this->total_trips == 0) {
            $this->rating = $newRating;
        } else {
            // Calculate weighted average
            $totalRating = ($this->rating * $this->total_trips) + $newRating;
            $this->rating = $totalRating / ($this->total_trips + 1);
        }
        
        $this->total_trips++;
        $this->save();
    }
}
