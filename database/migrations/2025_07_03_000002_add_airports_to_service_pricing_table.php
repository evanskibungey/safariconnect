<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_pricing', function (Blueprint $table) {
            // Add airport references for airport transfers
            $table->foreignId('pickup_airport_id')->nullable()->constrained('airports')->onDelete('cascade')->after('dropoff_city_id');
            $table->foreignId('dropoff_airport_id')->nullable()->constrained('airports')->onDelete('cascade')->after('pickup_airport_id');
            
            // Add indexes for better performance
            $table->index(['pickup_airport_id', 'is_active'], 'sp_pickup_airport_active_idx');
            $table->index(['dropoff_airport_id', 'is_active'], 'sp_dropoff_airport_active_idx');
            $table->index(['transfer_type', 'vehicle_type_id'], 'sp_transfer_vehicle_idx');
        });
    }

    public function down(): void
    {
        Schema::table('service_pricing', function (Blueprint $table) {
            $table->dropIndex('sp_pickup_airport_active_idx');
            $table->dropIndex('sp_dropoff_airport_active_idx');
            $table->dropIndex('sp_transfer_vehicle_idx');
            $table->dropForeign(['pickup_airport_id']);
            $table->dropForeign(['dropoff_airport_id']);
            $table->dropColumn(['pickup_airport_id', 'dropoff_airport_id']);
        });
    }
};
