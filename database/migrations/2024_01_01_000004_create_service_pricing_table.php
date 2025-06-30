<?php

// Migration 4: Create service_pricing table
// File: database/migrations/2024_01_01_000004_create_service_pricing_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_pricing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transportation_service_id')->constrained()->onDelete('cascade');
            $table->foreignId('pickup_city_id')->nullable()->constrained('cities')->onDelete('cascade');
            $table->foreignId('dropoff_city_id')->nullable()->constrained('cities')->onDelete('cascade');
            $table->foreignId('vehicle_type_id')->nullable()->constrained()->onDelete('cascade');
            
            // Pricing fields
            $table->decimal('base_price', 10, 2);
            $table->decimal('price_per_km', 8, 2)->nullable();
            $table->decimal('price_per_day', 8, 2)->nullable();
            $table->decimal('airport_pickup_surcharge', 8, 2)->default(0);
            $table->decimal('airport_dropoff_surcharge', 8, 2)->default(0);
            
            // Service-specific fields
            $table->string('transfer_type')->nullable(); // pickup, dropoff
            $table->string('parcel_type')->nullable(); // small, medium, large, documents
            $table->decimal('weight_limit', 8, 2)->nullable(); // For parcel delivery
            $table->integer('distance_km')->nullable(); // Distance between cities
            
            // Additional pricing factors
            $table->decimal('weekend_surcharge_percentage', 5, 2)->default(0);
            $table->decimal('night_surcharge_percentage', 5, 2)->default(0);
            $table->time('night_start_time')->default('22:00');
            $table->time('night_end_time')->default('06:00');
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Indexes for better performance (with custom names to avoid MySQL length limit)
            $table->index(['transportation_service_id', 'pickup_city_id', 'dropoff_city_id'], 'sp_service_route_idx');
            $table->index(['vehicle_type_id', 'is_active'], 'sp_vehicle_active_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_pricing');
    }
};