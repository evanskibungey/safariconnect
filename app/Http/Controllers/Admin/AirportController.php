<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AirportController extends Controller
{
    public function index(Request $request)
    {
        $query = Airport::with('city');

        // Filter by city
        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        // Search by name or code
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('code', 'LIKE', "%{$search}%");
            });
        }

        $airports = $query->orderBy('name')->paginate(15);
        $cities = City::active()->orderBy('name')->get();

        return view('admin.transportation.airports.index', compact('airports', 'cities'));
    }

    public function create()
    {
        $cities = City::active()->orderBy('name')->get();
        return view('admin.transportation.airports.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:10', 'unique:airports,code'],
            'city_id' => ['required', 'exists:cities,id'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        Airport::create($validated);

        return redirect()->route('admin.transportation.airports.index')
            ->with('success', 'Airport created successfully.');
    }

    public function show(Airport $airport)
    {
        $airport->load(['city', 'pickupPricing', 'dropoffPricing']);
        return view('admin.transportation.airports.show', compact('airport'));
    }

    public function edit(Airport $airport)
    {
        $cities = City::active()->orderBy('name')->get();
        return view('admin.transportation.airports.edit', compact('airport', 'cities'));
    }

    public function update(Request $request, Airport $airport)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:10', Rule::unique('airports', 'code')->ignore($airport->id)],
            'city_id' => ['required', 'exists:cities,id'],
            'description' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        $airport->update($validated);

        return redirect()->route('admin.transportation.airports.index')
            ->with('success', 'Airport updated successfully.');
    }

    public function destroy(Airport $airport)
    {
        $airport->delete();

        return redirect()->route('admin.transportation.airports.index')
            ->with('success', 'Airport deleted successfully.');
    }

    public function toggle(Airport $airport)
    {
        $airport->update(['is_active' => !$airport->is_active]);

        $status = $airport->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', "Airport {$status} successfully.");
    }

    // API endpoint to get airports by city
    public function getByCity(Request $request)
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
