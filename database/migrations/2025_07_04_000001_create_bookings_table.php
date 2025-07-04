<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference')->unique();
            $table->foreignId('transportation_service_id')->constrained();
            $table->foreignId('service_pricing_id')->nullable()->constrained('service_pricing');
            $table->foreignId('user_id')->nullable()->constrained();
            
            // Customer information
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            
            // Booking details
            $table->foreignId('pickup_city_id')->constrained('cities');
            $table->foreignId('dropoff_city_id')->constrained('cities');
            $table->foreignId('pickup_airport_id')->nullable()->constrained('airports');
            $table->foreignId('dropoff_airport_id')->nullable()->constrained('airports');
            $table->foreignId('vehicle_type_id')->nullable()->constrained('vehicle_types');
            
            // Travel details
            $table->date('travel_date');
            $table->time('travel_time');
            $table->integer('passengers')->default(1);
            $table->string('transfer_type')->nullable(); // For airport transfers
            
            // Pricing
            $table->decimal('price_per_unit', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->decimal('surcharge_amount', 10, 2)->default(0);
            
            // Status
            $table->enum('status', ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'refunded'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            
            // Additional info
            $table->text('special_requirements')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->string('cancellation_reason')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['booking_reference', 'customer_email']);
            $table->index(['travel_date', 'status']);
            $table->index('customer_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
