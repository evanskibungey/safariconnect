<?php

// Seeder for initial data
// File: database/seeders/TransportationServiceSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\VehicleType;
use App\Models\TransportationService;
use App\Models\ParcelType;

class TransportationServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Create cities
        $cities = [
            ['name' => 'Nairobi', 'state' => 'Nairobi County'],
            ['name' => 'Mombasa', 'state' => 'Mombasa County'],
            ['name' => 'Kisumu', 'state' => 'Kisumu County'],
            ['name' => 'Nakuru', 'state' => 'Nakuru County'],
            ['name' => 'Eldoret', 'state' => 'Uasin Gishu County'],
            ['name' => 'Thika', 'state' => 'Kiambu County'],
            ['name' => 'Malindi', 'state' => 'Kilifi County'],
            ['name' => 'Kitale', 'state' => 'Trans Nzoia County'],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }

        // Create vehicle types
        $vehicleTypes = [
            [
                'name' => '4-Seater Car',
                'capacity' => 4,
                'description' => 'Comfortable sedan for small groups',
                'base_rate' => 50.00
            ],
            [
                'name' => '7-Seater Van',
                'capacity' => 7,
                'description' => 'Spacious van for larger groups',
                'base_rate' => 80.00
            ],
            [
                'name' => 'Luxury Car',
                'capacity' => 4,
                'description' => 'Premium vehicle with luxury amenities',
                'base_rate' => 120.00
            ],
        ];

        foreach ($vehicleTypes as $vehicleType) {
            VehicleType::create($vehicleType);
        }

        // Create transportation services
        $services = [
            [
                'name' => 'Shared Ride',
                'service_type' => 'shared_ride',
                'description' => 'Share a ride with other passengers to reduce costs',
                'pricing_model' => 'city_based',
                'features' => json_encode(['shared_cost', 'eco_friendly', 'scheduled_departure'])
            ],
            [
                'name' => 'Solo Ride',
                'service_type' => 'solo_ride',
                'description' => 'Private ride for you and your group',
                'pricing_model' => 'vehicle_city_based',
                'features' => json_encode(['private_vehicle', 'flexible_timing', 'door_to_door'])
            ],
            [
                'name' => 'Airport Transfer',
                'service_type' => 'airport_transfer',
                'description' => 'Reliable airport pickup and drop-off service',
                'pricing_model' => 'vehicle_transfer_based',
                'features' => json_encode(['flight_tracking', 'meet_and_greet', 'luggage_assistance'])
            ],
            [
                'name' => 'Car Hire',
                'service_type' => 'car_hire',
                'description' => 'Rent a vehicle for multiple days',
                'pricing_model' => 'time_based',
                'features' => json_encode(['self_drive', 'flexible_duration', 'unlimited_mileage'])
            ],
            [
                'name' => 'Parcel Delivery',
                'service_type' => 'parcel_delivery',
                'description' => 'Fast and secure parcel delivery service',
                'pricing_model' => 'weight_location_based',
                'features' => json_encode(['same_day_delivery', 'tracking', 'insurance'])
            ],
        ];

        foreach ($services as $service) {
            TransportationService::create($service);
        }

        // Create parcel types
        $parcelTypes = [
            [
                'name' => 'Documents',
                'description' => 'Important documents and papers',
                'max_weight_kg' => 0.5,
                'max_dimensions' => '30x25x5 cm',
                'base_rate' => 10.00
            ],
            [
                'name' => 'Small Package',
                'description' => 'Small items and gifts',
                'max_weight_kg' => 5.0,
                'max_dimensions' => '40x30x20 cm',
                'base_rate' => 25.00
            ],
            [
                'name' => 'Medium Package',
                'description' => 'Medium-sized parcels',
                'max_weight_kg' => 15.0,
                'max_dimensions' => '60x40x30 cm',
                'base_rate' => 50.00
            ],
            [
                'name' => 'Large Package',
                'description' => 'Large items and bulk deliveries',
                'max_weight_kg' => 30.0,
                'max_dimensions' => '80x60x40 cm',
                'base_rate' => 100.00
            ],
        ];

        foreach ($parcelTypes as $parcelType) {
            ParcelType::create($parcelType);
        }
    }
}