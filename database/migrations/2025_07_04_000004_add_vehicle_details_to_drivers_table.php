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
        Schema::table('drivers', function (Blueprint $table) {
            $table->string('vehicle_make')->nullable()->after('vehicle_registration');
            $table->string('vehicle_model')->nullable()->after('vehicle_make');
            $table->string('vehicle_year')->nullable()->after('vehicle_model');
            $table->string('vehicle_color')->nullable()->after('vehicle_year');
            $table->string('agreement_document')->nullable()->after('vehicle_color');
            $table->date('agreement_date')->nullable()->after('agreement_document');
            $table->text('notes')->nullable()->after('agreement_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropColumn([
                'vehicle_make',
                'vehicle_model',
                'vehicle_year',
                'vehicle_color',
                'agreement_document',
                'agreement_date',
                'notes'
            ]);
        });
    }
};
