<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServicePricing;
use App\Models\TransportationService;
use App\Models\City;
use App\Models\ParcelType;

class ParcelDeliveryPricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parcelDeliveryService = TransportationService::where('service_type', 'parcel_delivery')->first();
        
        if (!$parcelDeliveryService) {
            $this->command->error('Parcel delivery service not found. Please run TransportationServiceSeeder first.');
            return;
        }

        // Get cities
        $cities = City::active()->get();
        $parcelTypes = ParcelType::active()->get();
        
        if ($cities->count() < 2) {
            $this->command->error('Not enough cities found. Please run CitySeeder first.');
            return;
        }

        if ($parcelTypes->count() == 0) {
            $this->command->error('No parcel types found. Please run ParcelTypeSeeder first.');
            return;
        }

        // Define base pricing matrix for different routes and parcel types
        $routePricing = [
            // Nairobi to other cities
            ['from' => 'Nairobi', 'to' => 'Mombasa', 'distance' => 485, 'base_multiplier' => 1.8],
            ['from' => 'Nairobi', 'to' => 'Kisumu', 'distance' => 342, 'base_multiplier' => 1.5],
            ['from' => 'Nairobi', 'to' => 'Nakuru', 'distance' => 160, 'base_multiplier' => 1.2],
            ['from' => 'Nairobi', 'to' => 'Eldoret', 'distance' => 312, 'base_multiplier' => 1.4],
            
            // Mombasa to other cities
            ['from' => 'Mombasa', 'to' => 'Nairobi', 'distance' => 485, 'base_multiplier' => 1.8],
            ['from' => 'Mombasa', 'to' => 'Kisumu', 'distance' => 590, 'base_multiplier' => 2.0],
            ['from' => 'Mombasa', 'to' => 'Nakuru', 'distance' => 520, 'base_multiplier' => 1.9],
            
            // Kisumu to other cities
            ['from' => 'Kisumu', 'to' => 'Nairobi', 'distance' => 342, 'base_multiplier' => 1.5],
            ['from' => 'Kisumu', 'to' => 'Mombasa', 'distance' => 590, 'base_multiplier' => 2.0],
            ['from' => 'Kisumu', 'to' => 'Nakuru', 'distance' => 190, 'base_multiplier' => 1.3],
            
            // Nakuru to other cities
            ['from' => 'Nakuru', 'to' => 'Nairobi', 'distance' => 160, 'base_multiplier' => 1.2],
            ['from' => 'Nakuru', 'to' => 'Eldoret', 'distance' => 150, 'base_multiplier' => 1.2],
            ['from' => 'Nakuru', 'to' => 'Kisumu', 'distance' => 190, 'base_multiplier' => 1.3],
        ];

        // Map parcel type names to pricing strings
        $parcelTypeMapping = [
            'Documents' => 'documents',
            'Small Package' => 'small',
            'Medium Package' => 'medium',
            'Large Package' => 'large',
            'Extra Large' => 'extra_large',
        ];

        foreach ($routePricing as $route) {
            $pickupCity = $cities->where('name', $route['from'])->first();
            $dropoffCity = $cities->where('name', $route['to'])->first();
            
            if (!$pickupCity || !$dropoffCity) {
                continue;
            }

            foreach ($parcelTypes as $parcelType) {
                $parcelTypeString = $parcelTypeMapping[$parcelType->name] ?? strtolower(str_replace(' ', '_', $parcelType->name));
                
                // Calculate base price using parcel type base rate and route multiplier
                $basePrice = $parcelType->base_rate * $route['base_multiplier'];
                
                $pricingData = [
                    'transportation_service_id' => $parcelDeliveryService->id,
                    'pickup_city_id' => $pickupCity->id,
                    'dropoff_city_id' => $dropoffCity->id,
                    'parcel_type' => $parcelTypeString,
                    'base_price' => round($basePrice, 2),
                    'price_per_kg' => round($basePrice * 0.1, 2), // 10% of base price per kg
                    'urgent_delivery_surcharge' => round($basePrice * 0.5, 2), // 50% surcharge
                    'insurance_rate_percentage' => 2.0, // 2% of parcel value
                    'weekend_surcharge' => round($basePrice * 0.15, 2), // 15% weekend surcharge
                    'holiday_surcharge' => round($basePrice * 0.25, 2), // 25% holiday surcharge
                    'route_description' => "{$route['from']} to {$route['to']} ({$parcelType->name})",
                    'distance_km' => $route['distance'],
                    'estimated_delivery_hours' => $this->calculateDeliveryTime($route['distance']),
                    'is_active' => true,
                ];

                ServicePricing::updateOrCreate([
                    'transportation_service_id' => $parcelDeliveryService->id,
                    'pickup_city_id' => $pickupCity->id,
                    'dropoff_city_id' => $dropoffCity->id,
                    'parcel_type' => $parcelTypeString,
                ], $pricingData);
            }
        }
    }

    private function calculateDeliveryTime($distance)
    {
        // Estimate delivery time based on distance
        if ($distance <= 200) {
            return 6; // Same day delivery
        } elseif ($distance <= 400) {
            return 12; // Next day delivery
        } else {
            return 24; // 1-2 day delivery
        }
    }
}
