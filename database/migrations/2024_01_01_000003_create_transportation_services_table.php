    <?php

// Migration 3: Create transportation_services table
// File: database/migrations/2024_01_01_000003_create_transportation_services_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transportation_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('service_type'); // shared_ride, solo_ride, airport_transfer, car_hire, parcel_delivery
            $table->text('description')->nullable();
            $table->string('pricing_model'); // city_based, vehicle_based, time_based, weight_based
            $table->json('features')->nullable(); // Additional features as JSON
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transportation_services');
    }
};