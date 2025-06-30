<?php

// Controller 1: TransportationServiceController.php
// File: app/Http/Controllers/Admin/TransportationServiceController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransportationService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransportationServiceController extends Controller
{
    public function index()
    {
        $services = TransportationService::with('servicePricing')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.transportation.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.transportation.services.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'service_type' => ['required', 'string', Rule::in(array_keys(TransportationService::SERVICE_TYPES))],
            'description' => ['nullable', 'string'],
            'pricing_model' => ['required', 'string', Rule::in(array_keys(TransportationService::PRICING_MODELS))],
            'features' => ['nullable', 'array'],
            'is_active' => ['boolean'],
        ]);

        TransportationService::create($validated);

        return redirect()->route('admin.transportation.services.index')
            ->with('success', 'Transportation service created successfully.');
    }

    public function show(TransportationService $service)
    {
        $service->load(['servicePricing.pickupCity', 'servicePricing.dropoffCity', 'servicePricing.vehicleType']);
        
        return view('admin.transportation.services.show', compact('service'));
    }

    public function edit(TransportationService $service)
    {
        return view('admin.transportation.services.edit', compact('service'));
    }

    public function update(Request $request, TransportationService $service)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'service_type' => ['required', 'string', Rule::in(array_keys(TransportationService::SERVICE_TYPES))],
            'description' => ['nullable', 'string'],
            'pricing_model' => ['required', 'string', Rule::in(array_keys(TransportationService::PRICING_MODELS))],
            'features' => ['nullable', 'array'],
            'is_active' => ['boolean'],
        ]);

        $service->update($validated);

        return redirect()->route('admin.transportation.services.index')
            ->with('success', 'Transportation service updated successfully.');
    }

    public function destroy(TransportationService $service)
    {
        $service->delete();

        return redirect()->route('admin.transportation.services.index')
            ->with('success', 'Transportation service deleted successfully.');
    }

    public function toggle(TransportationService $service)
    {
        $service->update(['is_active' => !$service->is_active]);

        $status = $service->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', "Transportation service {$status} successfully.");
    }
}