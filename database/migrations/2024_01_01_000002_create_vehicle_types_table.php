<?php

// Migration 2: Create vehicle_types table
// File: database/migrations/2024_01_01_000002_create_vehicle_types_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 4-seater, 7-seater, etc.
            $table->integer('capacity');
            $table->text('description')->nullable();
            $table->decimal('base_rate', 8, 2)->default(0); // Base rate per km or per day
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_types');
    }
};