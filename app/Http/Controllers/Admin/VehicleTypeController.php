<?php

// Controller 4: VehicleTypeController.php
// File: app/Http/Controllers/Admin/VehicleTypeController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleType;
use Illuminate\Http\Request;

class VehicleTypeController extends Controller
{
    public function index()
    {
        $vehicleTypes = VehicleType::orderBy('capacity')->orderBy('name')->paginate(10);

        return view('admin.transportation.vehicle-types.index', compact('vehicleTypes'));
    }

    public function create()
    {
        return view('admin.transportation.vehicle-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
            'base_rate' => ['required', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        VehicleType::create($validated);

        return redirect()->route('admin.transportation.vehicle-types.index')
            ->with('success', 'Vehicle type created successfully.');
    }

    public function show(VehicleType $vehicleType)
    {
        $vehicleType->load(['servicePricing.transportationService', 'servicePricing.pickupCity', 'servicePricing.dropoffCity']);
        
        return view('admin.transportation.vehicle-types.show', compact('vehicleType'));
    }

    public function edit(VehicleType $vehicleType)
    {
        return view('admin.transportation.vehicle-types.edit', compact('vehicleType'));
    }

    public function update(Request $request, VehicleType $vehicleType)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
            'base_rate' => ['required', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $vehicleType->update($validated);

        return redirect()->route('admin.transportation.vehicle-types.index')
            ->with('success', 'Vehicle type updated successfully.');
    }

    public function destroy(VehicleType $vehicleType)
    {
        // Check if vehicle type is used in any pricing
        if ($vehicleType->servicePricing()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete vehicle type that is used in service pricing.');
        }

        $vehicleType->delete();

        return redirect()->route('admin.transportation.vehicle-types.index')
            ->with('success', 'Vehicle type deleted successfully.');
    }

    public function toggle(VehicleType $vehicleType)
    {
        $vehicleType->update(['is_active' => !$vehicleType->is_active]);

        $status = $vehicleType->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', "Vehicle type {$status} successfully.");
    }
}