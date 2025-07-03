<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('airports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 10)->nullable(); // IATA/ICAO code
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['city_id', 'is_active']);
            $table->unique(['code'], 'airports_code_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('airports');
    }
};
