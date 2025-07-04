<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TransportationService;

class TransportationServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Shared Ride',
                'service_type' => 'shared_ride',
                'description' => 'Affordable shared transportation between cities. Share the ride with other passengers and save money.',
                'pricing_model' => 'city_based',
                'features' => ['Affordable pricing', 'Meet new people', 'Eco-friendly', 'Scheduled departures'],
                'is_active' => true,
            ],
            [
                'name' => 'Solo Ride',
                'service_type' => 'solo_ride',
                'description' => 'Private transportation service. Get your own vehicle and driver for a comfortable, personalized journey.',
                'pricing_model' => 'vehicle_city_based',
                'features' => ['Private vehicle', 'Personal driver', 'Flexible timing', 'Privacy', 'Comfortable journey'],
                'is_active' => true,
            ],
            [
                'name' => 'Airport Transfer',
                'service_type' => 'airport_transfer',
                'description' => 'Reliable airport pickup and drop-off services. Professional drivers and timely service.',
                'pricing_model' => 'vehicle_transfer_based',
                'features' => ['Professional drivers', 'Flight tracking', 'Meet & greet', 'Luggage assistance'],
                'is_active' => true,
            ],
            [
                'name' => 'Car Hire',
                'service_type' => 'car_hire',
                'description' => 'Rent a vehicle for your trip. Choose from economy to luxury vehicles.',
                'pricing_model' => 'time_based',
                'features' => ['Self-drive', 'Flexible duration', 'Various vehicle types', 'Insurance included'],
                'is_active' => true,
            ],
            [
                'name' => 'Parcel Delivery',
                'service_type' => 'parcel_delivery',
                'description' => 'Fast and secure parcel delivery between cities. Track your package in real-time.',
                'pricing_model' => 'weight_location_based',
                'features' => ['Real-time tracking', 'Secure handling', 'Insurance coverage', 'Express delivery'],
                'is_active' => true,
            ],
        ];

        foreach ($services as $serviceData) {
            TransportationService::updateOrCreate(
                ['service_type' => $serviceData['service_type']],
                $serviceData
            );
        }
    }
}
