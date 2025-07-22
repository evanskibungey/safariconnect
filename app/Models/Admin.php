<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Boot the model and add event listeners to enforce single admin restriction
     */
    protected static function boot()
    {
        parent::boot();

        // Prevent creating more than one admin
        static::creating(function ($admin) {
            if (self::count() >= 1) {
                throw new Exception('Only one admin account is allowed in the system.');
            }
        });
    }

    /**
     * Check if an admin account already exists
     */
    public static function adminExists(): bool
    {
        return self::count() > 0;
    }

    /**
     * Get the single admin account
     */
    public static function getSingleAdmin(): ?Admin
    {
        return self::first();
    }

    /**
     * Safely create admin only if none exists
     */
    public static function createSingleAdmin(array $attributes): Admin
    {
        if (self::adminExists()) {
            throw new Exception('Admin account already exists. Only one admin is allowed.');
        }

        return self::create($attributes);
    }
}