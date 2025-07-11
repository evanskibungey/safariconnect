<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed admin users
        $this->call(AdminSeeder::class);
        
        // Seed transportation data in order
        $seeders = [
            'CitySeeder',
            'AirportSeeder',
            'VehicleTypeSeeder',
            'ParcelTypeSeeder',
            'TransportationServiceSeeder',
            'SoloRidePricingSeeder',
            'ParcelDeliveryPricingSeeder',
            'DriverSeeder',
        ];
        
        foreach ($seeders as $seeder) {
            $seederClass = "Database\\Seeders\\{$seeder}";
            if (class_exists($seederClass)) {
                $this->call($seederClass);
            }
        }
    }
}
