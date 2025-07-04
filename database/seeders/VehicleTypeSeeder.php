<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VehicleType;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicleTypes = [
            [
                'name' => 'Economy Car',
                'capacity' => 4,
                'description' => 'Affordable and fuel-efficient vehicles perfect for budget-conscious travelers',
                'base_rate' => 2500.00,
                'is_active' => true,
            ],
            [
                'name' => 'Sedan',
                'capacity' => 4,
                'description' => 'Comfortable mid-size vehicles with ample space for passengers and luggage',
                'base_rate' => 3500.00,
                'is_active' => true,
            ],
            [
                'name' => 'SUV',
                'capacity' => 6,
                'description' => 'Spacious and versatile vehicles ideal for families and group travel',
                'base_rate' => 4500.00,
                'is_active' => true,
            ],
            [
                'name' => 'Premium Car',
                'capacity' => 4,
                'description' => 'Luxury vehicles with premium features for an executive travel experience',
                'base_rate' => 6000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Van',
                'capacity' => 8,
                'description' => 'Large capacity vehicles perfect for group travel and events',
                'base_rate' => 7000.00,
                'is_active' => true,
            ],
            [
                'name' => 'Minibus',
                'capacity' => 14,
                'description' => 'Commercial vehicles for larger groups and corporate travel',
                'base_rate' => 10000.00,
                'is_active' => true,
            ],
        ];

        foreach ($vehicleTypes as $vehicleTypeData) {
            VehicleType::updateOrCreate(
                ['name' => $vehicleTypeData['name']],
                $vehicleTypeData
            );
        }
    }
}
