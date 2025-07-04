<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;
use App\Models\VehicleType;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicleTypes = VehicleType::all();
        
        if ($vehicleTypes->isEmpty()) {
            $this->command->warn('No vehicle types found. Please run VehicleTypeSeeder first.');
            return;
        }

        $drivers = [
            [
                'name' => 'John Kamau',
                'email' => 'john.kamau@example.com',
                'phone' => '+254722111111',
                'license_number' => 'DL001234',
                'license_expiry' => now()->addYear(),
                'vehicle_registration' => 'KAA 123A',
                'vehicle_type_id' => $vehicleTypes->where('name', 'Sedan')->first()->id ?? $vehicleTypes->first()->id,
                'status' => Driver::STATUS_AVAILABLE,
                'is_active' => true,
                'rating' => 4.5,
                'total_trips' => 120,
            ],
            [
                'name' => 'Mary Wanjiku',
                'email' => 'mary.wanjiku@example.com',
                'phone' => '+254722222222',
                'license_number' => 'DL001235',
                'license_expiry' => now()->addMonths(18),
                'vehicle_registration' => 'KBB 456B',
                'vehicle_type_id' => $vehicleTypes->where('name', 'SUV')->first()->id ?? $vehicleTypes->first()->id,
                'status' => Driver::STATUS_AVAILABLE,
                'is_active' => true,
                'rating' => 4.8,
                'total_trips' => 89,
            ],
            [
                'name' => 'Peter Ochieng',
                'email' => 'peter.ochieng@example.com',
                'phone' => '+254722333333',
                'license_number' => 'DL001236',
                'license_expiry' => now()->addMonths(6),
                'vehicle_registration' => 'KCC 789C',
                'vehicle_type_id' => $vehicleTypes->where('name', 'Van')->first()->id ?? $vehicleTypes->first()->id,
                'status' => Driver::STATUS_BUSY,
                'is_active' => true,
                'rating' => 4.2,
                'total_trips' => 56,
            ],
            [
                'name' => 'Grace Muthoni',
                'email' => 'grace.muthoni@example.com',
                'phone' => '+254722444444',
                'license_number' => 'DL001237',
                'license_expiry' => now()->addYear()->addMonths(3),
                'vehicle_registration' => 'KDD 012D',
                'vehicle_type_id' => $vehicleTypes->where('name', 'Sedan')->first()->id ?? $vehicleTypes->first()->id,
                'status' => Driver::STATUS_OFFLINE,
                'is_active' => true,
                'rating' => 4.6,
                'total_trips' => 200,
            ],
            [
                'name' => 'James Otieno',
                'email' => 'james.otieno@example.com',
                'phone' => '+254722555555',
                'license_number' => 'DL001238',
                'license_expiry' => now()->addMonths(9),
                'vehicle_registration' => 'KEE 345E',
                'vehicle_type_id' => $vehicleTypes->where('name', 'SUV')->first()->id ?? $vehicleTypes->first()->id,
                'status' => Driver::STATUS_AVAILABLE,
                'is_active' => true,
                'rating' => 4.9,
                'total_trips' => 150,
            ],
        ];

        foreach ($drivers as $driver) {
            Driver::create($driver);
        }

        $this->command->info('Drivers seeded successfully!');
    }
}
