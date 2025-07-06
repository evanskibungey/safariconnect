<?php

// Controller 2: ServicePricingController.php
// File: app/Http/Controllers/Admin/ServicePricingController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServicePricing;
use App\Models\TransportationService;
use App\Models\City;
use App\Models\VehicleType;
use App\Models\ParcelType;
use App\Models\Airport;
use Illuminate\Http\Request;

class ServicePricingController extends Controller
{
    public function index(Request $request)
    {
        $query = ServicePricing::with(['transportationService', 'pickupCity', 'dropoffCity', 'pickupAirport', 'dropoffAirport', 'vehicleType']);

        // Filter by service
        if ($request->filled('service_id')) {
            $query->where('transportation_service_id', $request->service_id);
        }

        // Filter by route
        if ($request->filled('pickup_city_id')) {
            $query->where('pickup_city_id', $request->pickup_city_id);
        }

        if ($request->filled('dropoff_city_id')) {
            $query->where('dropoff_city_id', $request->dropoff_city_id);
        }

        $pricing = $query->orderBy('transportation_service_id')
                        ->orderBy('pickup_city_id')
                        ->orderBy('dropoff_city_id')
                        ->paginate(15);

        $services = TransportationService::active()->get();
        $cities = City::active()->get();

        return view('admin.transportation.pricing.index', compact('pricing', 'services', 'cities'));
    }

    public function create()
    {
        $services = TransportationService::active()->get();
        $cities = City::active()->get();
        $airports = Airport::active()->with('city')->get();
        $vehicleTypes = VehicleType::active()->get();
        $parcelTypes = ParcelType::active()->get();

        return view('admin.transportation.pricing.create', compact('services', 'cities', 'airports', 'vehicleTypes', 'parcelTypes'));
    }

    public function store(Request $request)
    {
        // Basic validation first
        $validated = $request->validate([
            'transportation_service_id' => ['required', 'exists:transportation_services,id'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'vehicle_type_id' => ['nullable', 'exists:vehicle_types,id'],
            'price_per_km' => ['nullable', 'numeric', 'min:0'],
            'price_per_day' => ['nullable', 'numeric', 'min:0'],
            'airport_pickup_surcharge' => ['nullable', 'numeric', 'min:0'],
            'airport_dropoff_surcharge' => ['nullable', 'numeric', 'min:0'],
            'transfer_type' => ['nullable', 'string', 'in:pickup,dropoff'],
            'parcel_type' => ['nullable', 'string', 'in:documents,small,medium,large'],
            'weight_limit' => ['nullable', 'numeric', 'min:0'],
            'distance_km' => ['nullable', 'integer', 'min:0'],
            'weekend_surcharge_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'night_surcharge_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'night_start_time' => ['nullable', 'date_format:H:i'],
            'night_end_time' => ['nullable', 'date_format:H:i'],
            'is_active' => ['boolean'],
        ]);

        // Get the service to check its type
        $service = TransportationService::find($request->transportation_service_id);
        
        if ($service && $service->service_type === 'airport_transfer') {
            // Validate airport transfer specific fields
            $airportRules = [];
            $airportMessages = [];
            
            if ($request->transfer_type === 'pickup') {
                $airportRules['pickup_airport_id'] = 'required|exists:airports,id';
                $airportRules['dropoff_city_id'] = 'required|exists:cities,id';
                $airportMessages['pickup_airport_id.required'] = 'Pickup airport is required for airport pickup service.';
                $airportMessages['dropoff_city_id.required'] = 'Destination city is required for airport pickup service.';
            } elseif ($request->transfer_type === 'dropoff') {
                $airportRules['pickup_city_id'] = 'required|exists:cities,id';
                $airportRules['dropoff_airport_id'] = 'required|exists:airports,id';
                $airportMessages['pickup_city_id.required'] = 'Origin city is required for airport drop-off service.';
                $airportMessages['dropoff_airport_id.required'] = 'Drop-off airport is required for airport drop-off service.';
            }
            
            // Add vehicle type requirement for airport transfers
            $airportRules['vehicle_type_id'] = 'required|exists:vehicle_types,id';
            $airportMessages['vehicle_type_id.required'] = 'Vehicle type is required for airport transfers.';
            
            // Validate airport-specific rules
            $airportValidated = $request->validate($airportRules, $airportMessages);
            $validated = array_merge($validated, $airportValidated);
        } elseif ($service && $service->service_type === 'car_hire') {
            // Validate car hire specific fields
            $carHireRules = [
                'vehicle_type_id' => 'required|exists:vehicle_types,id',
            ];
            $carHireMessages = [
                'vehicle_type_id.required' => 'Vehicle type is required for car hire service.',
            ];
            
            // Ensure either price_per_day or base_price has a meaningful value
            $customValidator = \Validator::make($request->all(), $carHireRules, $carHireMessages);
            
            $customValidator->after(function ($validator) use ($request) {
                $pricePerDay = $request->input('price_per_day', 0);
                $basePrice = $request->input('base_price', 0);
                
                if ((!$pricePerDay || $pricePerDay <= 0) && (!$basePrice || $basePrice <= 0)) {
                    $validator->errors()->add('price_per_day', 'Either price per day or base price must be greater than zero for car hire.');
                    $validator->errors()->add('base_price', 'Either price per day or base price must be greater than zero for car hire.');
                }
            });
            
            if ($customValidator->fails()) {
                return redirect()->back()->withErrors($customValidator)->withInput();
            }
            
            $carHireValidated = $request->validate($carHireRules, $carHireMessages);
            $validated = array_merge($validated, $carHireValidated);
        } elseif ($service && $service->service_type === 'car_hire') {
            // Validate car hire specific fields
            $carHireRules = [
                'vehicle_type_id' => 'required|exists:vehicle_types,id',
            ];
            $carHireMessages = [
                'vehicle_type_id.required' => 'Vehicle type is required for car hire service.',
            ];
            
            // Ensure either price_per_day or base_price has a meaningful value
            $customValidator = \Validator::make($request->all(), $carHireRules, $carHireMessages);
            
            $customValidator->after(function ($validator) use ($request) {
                $pricePerDay = $request->input('price_per_day', 0);
                $basePrice = $request->input('base_price', 0);
                
                if ((!$pricePerDay || $pricePerDay <= 0) && (!$basePrice || $basePrice <= 0)) {
                    $validator->errors()->add('price_per_day', 'Either price per day or base price must be greater than zero for car hire.');
                    $validator->errors()->add('base_price', 'Either price per day or base price must be greater than zero for car hire.');
                }
            });
            
            if ($customValidator->fails()) {
                return redirect()->back()->withErrors($customValidator)->withInput();
            }
            
            $carHireValidated = $request->validate($carHireRules, $carHireMessages);
            $validated = array_merge($validated, $carHireValidated);
        } else {
            // For non-airport services, validate regular route fields if needed
            $routeRules = [];
            if (in_array($service->service_type, ['shared_ride', 'solo_ride', 'parcel_delivery'])) {
                $routeRules['pickup_city_id'] = 'nullable|exists:cities,id';
                $routeRules['dropoff_city_id'] = 'nullable|exists:cities,id';
            }
            if (!empty($routeRules)) {
                $routeValidated = $request->validate($routeRules);
                $validated = array_merge($validated, $routeValidated);
            }
        }

        ServicePricing::create($validated);

        return redirect()->route('admin.transportation.pricing.index')
            ->with('success', 'Service pricing created successfully.');
    }

    public function show(ServicePricing $pricing)
    {
        $pricing->load(['transportationService', 'pickupCity', 'dropoffCity', 'pickupAirport', 'dropoffAirport', 'vehicleType']);
        
        return view('admin.transportation.pricing.show', compact('pricing'));
    }

    public function edit(ServicePricing $pricing)
    {
        $services = TransportationService::active()->get();
        $cities = City::active()->get();
        $airports = Airport::active()->with('city')->get();
        $vehicleTypes = VehicleType::active()->get();
        $parcelTypes = ParcelType::active()->get();

        return view('admin.transportation.pricing.edit', compact('pricing', 'services', 'cities', 'airports', 'vehicleTypes', 'parcelTypes'));
    }

    public function update(Request $request, ServicePricing $pricing)
    {
        // Basic validation first
        $validated = $request->validate([
            'transportation_service_id' => ['required', 'exists:transportation_services,id'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'vehicle_type_id' => ['nullable', 'exists:vehicle_types,id'],
            'price_per_km' => ['nullable', 'numeric', 'min:0'],
            'price_per_day' => ['nullable', 'numeric', 'min:0'],
            'airport_pickup_surcharge' => ['nullable', 'numeric', 'min:0'],
            'airport_dropoff_surcharge' => ['nullable', 'numeric', 'min:0'],
            'transfer_type' => ['nullable', 'string', 'in:pickup,dropoff'],
            'parcel_type' => ['nullable', 'string', 'in:documents,small,medium,large'],
            'weight_limit' => ['nullable', 'numeric', 'min:0'],
            'distance_km' => ['nullable', 'integer', 'min:0'],
            'weekend_surcharge_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'night_surcharge_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'night_start_time' => ['nullable', 'date_format:H:i'],
            'night_end_time' => ['nullable', 'date_format:H:i'],
            'is_active' => ['boolean'],
        ]);

        // Get the service to check its type
        $service = TransportationService::find($request->transportation_service_id);
        
        if ($service && $service->service_type === 'airport_transfer') {
            // Validate airport transfer specific fields
            $airportRules = [];
            $airportMessages = [];
            
            if ($request->transfer_type === 'pickup') {
                $airportRules['pickup_airport_id'] = 'required|exists:airports,id';
                $airportRules['dropoff_city_id'] = 'required|exists:cities,id';
                $airportMessages['pickup_airport_id.required'] = 'Pickup airport is required for airport pickup service.';
                $airportMessages['dropoff_city_id.required'] = 'Destination city is required for airport pickup service.';
            } elseif ($request->transfer_type === 'dropoff') {
                $airportRules['pickup_city_id'] = 'required|exists:cities,id';
                $airportRules['dropoff_airport_id'] = 'required|exists:airports,id';
                $airportMessages['pickup_city_id.required'] = 'Origin city is required for airport drop-off service.';
                $airportMessages['dropoff_airport_id.required'] = 'Drop-off airport is required for airport drop-off service.';
            }
            
            // Add vehicle type requirement for airport transfers
            $airportRules['vehicle_type_id'] = 'required|exists:vehicle_types,id';
            $airportMessages['vehicle_type_id.required'] = 'Vehicle type is required for airport transfers.';
            
            // Validate airport-specific rules
            $airportValidated = $request->validate($airportRules, $airportMessages);
            $validated = array_merge($validated, $airportValidated);
        } else {
            // For non-airport services, validate regular route fields if needed
            $routeRules = [];
            if (in_array($service->service_type, ['shared_ride', 'solo_ride', 'parcel_delivery'])) {
                $routeRules['pickup_city_id'] = 'nullable|exists:cities,id';
                $routeRules['dropoff_city_id'] = 'nullable|exists:cities,id';
            }
            if (!empty($routeRules)) {
                $routeValidated = $request->validate($routeRules);
                $validated = array_merge($validated, $routeValidated);
            }
        }

        $pricing->update($validated);

        return redirect()->route('admin.transportation.pricing.index')
            ->with('success', 'Service pricing updated successfully.');
    }

    public function destroy(ServicePricing $pricing)
    {
        $pricing->delete();

        return redirect()->route('admin.transportation.pricing.index')
            ->with('success', 'Service pricing deleted successfully.');
    }

    public function toggle(ServicePricing $pricing)
    {
        $pricing->update(['is_active' => !$pricing->is_active]);

        $status = $pricing->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', "Service pricing {$status} successfully.");
    }

    public function duplicate(ServicePricing $pricing)
    {
        $newPricing = $pricing->replicate();
        $newPricing->save();

        return redirect()->route('admin.transportation.pricing.edit', $newPricing)
            ->with('success', 'Service pricing duplicated successfully. Please review and update as needed.');
    }



    /**
     * AJAX endpoint to get airports by city
     */
    public function getAirportsByCity(Request $request)
    {
        $cityId = $request->get('city_id');
        
        if (!$cityId) {
            return response()->json([]);
        }

        $airports = Airport::active()
            ->where('city_id', $cityId)
            ->orderBy('name')
            ->get(['id', 'name', 'code']);

        return response()->json($airports);
    }
}
