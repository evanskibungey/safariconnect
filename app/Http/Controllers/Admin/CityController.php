<?php

// Controller 3: CityController.php
// File: app/Http/Controllers/Admin/CityController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::orderBy('name')->paginate(15);

        return view('admin.transportation.cities.index', compact('cities'));
    }

    public function create()
    {
        return view('admin.transportation.cities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ]);

        City::create($validated);

        return redirect()->route('admin.transportation.cities.index')
            ->with('success', 'City created successfully.');
    }

    public function show(City $city)
    {
        $city->load(['pickupPricing.transportationService', 'dropoffPricing.transportationService']);
        
        return view('admin.transportation.cities.show', compact('city'));
    }

    public function edit(City $city)
    {
        return view('admin.transportation.cities.edit', compact('city'));
    }

    public function update(Request $request, City $city)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ]);

        $city->update($validated);

        return redirect()->route('admin.transportation.cities.index')
            ->with('success', 'City updated successfully.');
    }

    public function destroy(City $city)
    {
        // Check if city is used in any pricing
        if ($city->pickupPricing()->count() > 0 || $city->dropoffPricing()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete city that is used in service pricing.');
        }

        $city->delete();

        return redirect()->route('admin.transportation.cities.index')
            ->with('success', 'City deleted successfully.');
    }

    public function toggle(City $city)
    {
        $city->update(['is_active' => !$city->is_active]);

        $status = $city->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', "City {$status} successfully.");
    }
}