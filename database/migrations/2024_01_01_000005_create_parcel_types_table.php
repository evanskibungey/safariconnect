<?php

// Migration 5: Create parcel_types table
// File: database/migrations/2024_01_01_000005_create_parcel_types_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parcel_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Documents, Small Package, Medium Package, Large Package
            $table->text('description')->nullable();
            $table->decimal('max_weight_kg', 8, 2); // Maximum weight in kg
            $table->string('max_dimensions')->nullable(); // e.g., "30x30x30 cm"
            $table->decimal('base_rate', 8, 2); // Base delivery rate
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parcel_types');
    }
};