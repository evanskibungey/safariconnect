<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransportationService;
use App\Models\ServicePricing;
use App\Models\City;
use App\Models\VehicleType;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function testSoloRideData()
    {
        try {
            $results = [];
            
            // 1. Check if Solo Ride service exists
            $soloRideService = TransportationService::where('service_type', 'solo_ride')->first();
            $results['solo_ride_service'] = $soloRideService ? 'EXISTS' : 'MISSING';
            
            // 2. Check if cities exist
            $citiesCount = City::active()->count();
            $results['cities_count'] = $citiesCount;
            
            // 3. Check if vehicle types exist
            $vehicleTypesCount = VehicleType::active()->count();
            $results['vehicle_types_count'] = $vehicleTypesCount;
            
            // 4. Check if solo ride pricing exists
            $soloRidePricingCount = 0;
            if ($soloRideService) {
                $soloRidePricingCount = ServicePricing::where('transportation_service_id', $soloRideService->id)->count();
            }
            $results['solo_ride_pricing_count'] = $soloRidePricingCount;
            
            // 5. Get sample data
            $results['sample_cities'] = City::active()->limit(5)->pluck('name', 'id');
            $results['sample_vehicle_types'] = VehicleType::active()->limit(5)->select('id', 'name', 'description')->get();
            
            // 6. Get sample pricing
            if ($soloRideService) {
                $results['sample_pricing'] = ServicePricing::with(['pickupCity', 'dropoffCity', 'vehicleType'])
                    ->where('transportation_service_id', $soloRideService->id)
                    ->limit(5)
                    ->get()
                    ->map(function ($pricing) {
                        return [
                            'id' => $pricing->id,
                            'route' => $pricing->route_description,
                            'vehicle_type' => $pricing->vehicleType ? $pricing->vehicleType->name : 'N/A',
                            'base_price' => $pricing->base_price,
                        ];
                    });
            }
            
            return response()->json([
                'status' => 'success',
                'message' => 'Solo Ride system test completed',
                'results' => $results,
                'timestamp' => now(),
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error testing Solo Ride system: ' . $e->getMessage(),
                'timestamp' => now(),
            ], 500);
        }
    }
    
    public function testSoloRidePricing(Request $request)
    {
        try {
            $pickupCityId = $request->get('pickup_city_id', 1);
            $dropoffCityId = $request->get('dropoff_city_id', 2);
            $vehicleTypeId = $request->get('vehicle_type_id', 1);
            
            // Test the actual pricing API
            $testRequest = new Request([
                'pickup_city_id' => $pickupCityId,
                'dropoff_city_id' => $dropoffCityId,
                'vehicle_type_id' => $vehicleTypeId,
                'travel_date' => now()->addDays(1)->format('Y-m-d'),
                'travel_time' => '10:00',
            ]);
            
            $bookingController = new BookingController();
            $pricingResponse = $bookingController->getSoloRidePricing($testRequest);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Solo Ride pricing test completed',
                'test_params' => [
                    'pickup_city_id' => $pickupCityId,
                    'dropoff_city_id' => $dropoffCityId,
                    'vehicle_type_id' => $vehicleTypeId,
                ],
                'pricing_response' => $pricingResponse->getData(),
                'timestamp' => now(),
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error testing Solo Ride pricing: ' . $e->getMessage(),
                'timestamp' => now(),
            ], 500);
        }
    }
}
