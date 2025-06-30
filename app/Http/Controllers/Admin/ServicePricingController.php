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
use Illuminate\Http\Request;

class ServicePricingController extends Controller
{
    public function index(Request $request)
    {
        $query = ServicePricing::with(['transportationService', 'pickupCity', 'dropoffCity', 'vehicleType']);

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
        $vehicleTypes = VehicleType::active()->get();
        $parcelTypes = ParcelType::active()->get();

        return view('admin.transportation.pricing.create', compact('services', 'cities', 'vehicleTypes', 'parcelTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transportation_service_id' => ['required', 'exists:transportation_services,id'],
            'pickup_city_id' => ['nullable', 'exists:cities,id'],
            'dropoff_city_id' => ['nullable', 'exists:cities,id'],
            'vehicle_type_id' => ['nullable', 'exists:vehicle_types,id'],
            'base_price' => ['required', 'numeric', 'min:0'],
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

        ServicePricing::create($validated);

        return redirect()->route('admin.transportation.pricing.index')
            ->with('success', 'Service pricing created successfully.');
    }

    public function show(ServicePricing $pricing)
    {
        $pricing->load(['transportationService', 'pickupCity', 'dropoffCity', 'vehicleType']);
        
        return view('admin.transportation.pricing.show', compact('pricing'));
    }

    public function edit(ServicePricing $pricing)
    {
        $services = TransportationService::active()->get();
        $cities = City::active()->get();
        $vehicleTypes = VehicleType::active()->get();
        $parcelTypes = ParcelType::active()->get();

        return view('admin.transportation.pricing.edit', compact('pricing', 'services', 'cities', 'vehicleTypes', 'parcelTypes'));
    }

    public function update(Request $request, ServicePricing $pricing)
    {
        $validated = $request->validate([
            'transportation_service_id' => ['required', 'exists:transportation_services,id'],
            'pickup_city_id' => ['nullable', 'exists:cities,id'],
            'dropoff_city_id' => ['nullable', 'exists:cities,id'],
            'vehicle_type_id' => ['nullable', 'exists:vehicle_types,id'],
            'base_price' => ['required', 'numeric', 'min:0'],
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
}