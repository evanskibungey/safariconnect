<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransportationService;
use App\Models\City;
use App\Models\Airport;
use App\Models\VehicleType;

class DebugController extends Controller
{
    public function debugPricingForm(Request $request)
    {
        $data = [
            'request_method' => $request->method(),
            'all_input' => $request->all(),
            'has_dropoff_city_id' => $request->has('dropoff_city_id'),
            'dropoff_city_id_value' => $request->get('dropoff_city_id'),
            'transfer_type' => $request->get('transfer_type'),
            'service_id' => $request->get('transportation_service_id'),
            'headers' => $request->headers->all(),
            'content_type' => $request->header('Content-Type'),
            'php_input' => file_get_contents('php://input'),
        ];

        // Detailed form field analysis
        $data['form_field_analysis'] = [
            'pickup_airport_id' => [
                'exists' => $request->has('pickup_airport_id'),
                'value' => $request->get('pickup_airport_id'),
                'empty' => empty($request->get('pickup_airport_id'))
            ],
            'dropoff_city_id' => [
                'exists' => $request->has('dropoff_city_id'),
                'value' => $request->get('dropoff_city_id'),
                'empty' => empty($request->get('dropoff_city_id'))
            ],
            'pickup_city_id' => [
                'exists' => $request->has('pickup_city_id'),
                'value' => $request->get('pickup_city_id'),
                'empty' => empty($request->get('pickup_city_id'))
            ],
            'dropoff_airport_id' => [
                'exists' => $request->has('dropoff_airport_id'),
                'value' => $request->get('dropoff_airport_id'),
                'empty' => empty($request->get('dropoff_airport_id'))
            ]
        ];

        if ($request->get('transportation_service_id')) {
            $service = TransportationService::find($request->get('transportation_service_id'));
            $data['service_info'] = $service ? [
                'id' => $service->id,
                'name' => $service->name,
                'service_type' => $service->service_type
            ] : 'Service not found';
            
            // Simulate validation that would occur in ServicePricingController
            if ($service && $service->service_type === 'airport_transfer') {
                $data['validation_simulation'] = $this->simulateValidation($request, $service);
            }
        }

        if ($request->get('dropoff_city_id')) {
            $city = City::find($request->get('dropoff_city_id'));
            $data['city_info'] = $city ? [
                'id' => $city->id,
                'name' => $city->name,
                'exists' => true
            ] : 'City not found in database';
        }

        $data['available_cities'] = City::select('id', 'name')->get()->toArray();
        $data['available_airports'] = Airport::with('city:id,name')->select('id', 'name', 'city_id')->get()->toArray();

        return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }
    
    private function simulateValidation($request, $service)
    {
        $validation_result = [
            'service_type' => $service->service_type,
            'transfer_type' => $request->get('transfer_type'),
            'validation_rules_applied' => [],
            'validation_errors' => [],
            'would_pass' => true
        ];
        
        if ($service->service_type === 'airport_transfer') {
            if ($request->get('transfer_type') === 'pickup') {
                $validation_result['validation_rules_applied'][] = 'pickup_airport_id: required|exists:airports,id';
                $validation_result['validation_rules_applied'][] = 'dropoff_city_id: required|exists:cities,id';
                
                if (empty($request->get('pickup_airport_id'))) {
                    $validation_result['validation_errors'][] = 'Pickup airport is required for airport pickup service.';
                    $validation_result['would_pass'] = false;
                }
                
                if (empty($request->get('dropoff_city_id'))) {
                    $validation_result['validation_errors'][] = 'Destination city is required for airport pickup service.';
                    $validation_result['would_pass'] = false;
                }
            } elseif ($request->get('transfer_type') === 'dropoff') {
                $validation_result['validation_rules_applied'][] = 'pickup_city_id: required|exists:cities,id';
                $validation_result['validation_rules_applied'][] = 'dropoff_airport_id: required|exists:airports,id';
                
                if (empty($request->get('pickup_city_id'))) {
                    $validation_result['validation_errors'][] = 'Origin city is required for airport drop-off service.';
                    $validation_result['would_pass'] = false;
                }
                
                if (empty($request->get('dropoff_airport_id'))) {
                    $validation_result['validation_errors'][] = 'Drop-off airport is required for airport drop-off service.';
                    $validation_result['would_pass'] = false;
                }
            }
            
            $validation_result['validation_rules_applied'][] = 'vehicle_type_id: required|exists:vehicle_types,id';
            if (empty($request->get('vehicle_type_id'))) {
                $validation_result['validation_errors'][] = 'Vehicle type is required for airport transfers.';
                $validation_result['would_pass'] = false;
            }
        }
        
        return $validation_result;
    }
}
