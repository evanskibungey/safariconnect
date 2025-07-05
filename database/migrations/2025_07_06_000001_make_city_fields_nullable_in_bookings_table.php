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
        Schema::table('bookings', function (Blueprint $table) {
            // Drop the existing foreign key constraints first
            $table->dropForeign(['pickup_city_id']);
            $table->dropForeign(['dropoff_city_id']);
            
            // Drop the columns
            $table->dropColumn(['pickup_city_id', 'dropoff_city_id']);
        });
        
        Schema::table('bookings', function (Blueprint $table) {
            // Add the columns back as nullable with foreign keys
            $table->foreignId('pickup_city_id')->nullable()->constrained('cities')->onDelete('cascade')->after('customer_phone');
            $table->foreignId('dropoff_city_id')->nullable()->constrained('cities')->onDelete('cascade')->after('pickup_city_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Drop the nullable foreign key constraints
            $table->dropForeign(['pickup_city_id']);
            $table->dropForeign(['dropoff_city_id']);
            
            // Drop the columns
            $table->dropColumn(['pickup_city_id', 'dropoff_city_id']);
        });
        
        Schema::table('bookings', function (Blueprint $table) {
            // Add them back as NOT NULL (original state)
            $table->foreignId('pickup_city_id')->constrained('cities')->after('customer_phone');
            $table->foreignId('dropoff_city_id')->constrained('cities')->after('pickup_city_id');
        });
    }
};
