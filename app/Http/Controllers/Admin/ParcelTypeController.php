<?php

// Controller 5: ParcelTypeController.php
// File: app/Http/Controllers/Admin/ParcelTypeController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParcelType;
use Illuminate\Http\Request;

class ParcelTypeController extends Controller
{
    public function index()
    {
        $parcelTypes = ParcelType::orderBy('max_weight_kg')->paginate(10);

        return view('admin.transportation.parcel-types.index', compact('parcelTypes'));
    }

    public function create()
    {
        return view('admin.transportation.parcel-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'max_weight_kg' => ['required', 'numeric', 'min:0'],
            'max_dimensions' => ['nullable', 'string', 'max:255'],
            'base_rate' => ['required', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        ParcelType::create($validated);

        return redirect()->route('admin.transportation.parcel-types.index')
            ->with('success', 'Parcel type created successfully.');
    }

    public function show(ParcelType $parcelType)
    {
        return view('admin.transportation.parcel-types.show', compact('parcelType'));
    }

    public function edit(ParcelType $parcelType)
    {
        return view('admin.transportation.parcel-types.edit', compact('parcelType'));
    }

    public function update(Request $request, ParcelType $parcelType)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'max_weight_kg' => ['required', 'numeric', 'min:0'],
            'max_dimensions' => ['nullable', 'string', 'max:255'],
            'base_rate' => ['required', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $parcelType->update($validated);

        return redirect()->route('admin.transportation.parcel-types.index')
            ->with('success', 'Parcel type updated successfully.');
    }

    public function destroy(ParcelType $parcelType)
    {
        $parcelType->delete();

        return redirect()->route('admin.transportation.parcel-types.index')
            ->with('success', 'Parcel type deleted successfully.');
    }

    public function toggle(ParcelType $parcelType)
    {
        $parcelType->update(['is_active' => !$parcelType->is_active]);

        $status = $parcelType->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', "Parcel type {$status} successfully.");
    }
}