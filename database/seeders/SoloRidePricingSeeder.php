<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServicePricing;
use App\Models\TransportationService;
use App\Models\City;
use App\Models\VehicleType;

class SoloRidePricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the solo ride service
        $soloRideService = TransportationService::where('service_type', 'solo_ride')->first();
        
        if (!$soloRideService) {
            $this->command->warn('Solo ride service not found. Please run TransportationServiceSeeder first.');
            return;
        }

        // Get cities and vehicle types
        $cities = City::active()->get();
        $vehicleTypes = VehicleType::active()->get();

        if ($cities->isEmpty() || $vehicleTypes->isEmpty()) {
            $this->command->warn('Cities or vehicle types not found. Please run CitySeeder and VehicleTypeSeeder first.');
            return;
        }

        // Define route pricing multipliers based on distance/popularity
        $routeMultipliers = [
            'Nairobi' => [
                'Mombasa' => 1.8,
                'Kisumu' => 1.4,
                'Nakuru' => 1.0,
                'Eldoret' => 1.5,
                'Meru' => 1.1,
                'Nyeri' => 0.8,
                'Thika' => 0.6,
            ],
            'Mombasa' => [
                'Nairobi' => 1.8,
                'Kisumu' => 2.0,
                'Nakuru' => 1.9,
                'Eldoret' => 2.2,
            ],
            'Kisumu' => [
                'Nairobi' => 1.4,
                'Mombasa' => 2.0,
                'Nakuru' => 1.2,
                'Eldoret' => 1.1,
                'Kakamega' => 0.8,
            ],
            'Nakuru' => [
                'Nairobi' => 1.0,
                'Mombasa' => 1.9,
                'Kisumu' => 1.2,
                'Eldoret' => 1.3,
                'Nyeri' => 0.9,
            ],
            'Eldoret' => [
                'Nairobi' => 1.5,
                'Mombasa' => 2.2,
                'Kisumu' => 1.1,
                'Nakuru' => 1.3,
                'Kakamega' => 0.7,
            ],
        ];

        $cityMap = $cities->keyBy('name');
        $vehicleTypeMap = $vehicleTypes->keyBy('name');

        foreach ($routeMultipliers as $fromCityName => $destinations) {
            $fromCity = $cityMap->get($fromCityName);
            if (!$fromCity) continue;

            foreach ($destinations as $toCityName => $multiplier) {
                $toCity = $cityMap->get($toCityName);
                if (!$toCity) continue;

                foreach ($vehicleTypes as $vehicleType) {
                    $basePrice = $vehicleType->base_rate * $multiplier;

                    // Add some variation for weekend and night surcharges
                    $pricingData = [
                        'transportation_service_id' => $soloRideService->id,
                        'pickup_city_id' => $fromCity->id,
                        'dropoff_city_id' => $toCity->id,
                        'vehicle_type_id' => $vehicleType->id,
                        'base_price' => $basePrice,
                        'distance_km' => (int)(100 * $multiplier), // Approximate distance
                        'weekend_surcharge_percentage' => 15.00,
                        'night_surcharge_percentage' => 25.00,
                        'night_start_time' => '22:00',
                        'night_end_time' => '06:00',
                        'is_active' => true,
                    ];

                    ServicePricing::updateOrCreate(
                        [
                            'transportation_service_id' => $soloRideService->id,
                            'pickup_city_id' => $fromCity->id,
                            'dropoff_city_id' => $toCity->id,
                            'vehicle_type_id' => $vehicleType->id,
                        ],
                        $pricingData
                    );
                }
            }
        }

        $this->command->info('Solo ride pricing data seeded successfully!');
    }
}
