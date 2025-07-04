<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $query = Driver::with(['vehicleType', 'bookings']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by vehicle type
        if ($request->filled('vehicle_type_id')) {
            $query->where('vehicle_type_id', $request->vehicle_type_id);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('license_number', 'like', "%{$search}%");
            });
        }

        $drivers = $query->orderBy('name')->paginate(20);

        $stats = [
            'total' => Driver::count(),
            'available' => Driver::where('status', Driver::STATUS_AVAILABLE)->count(),
            'busy' => Driver::where('status', Driver::STATUS_BUSY)->count(),
            'offline' => Driver::where('status', Driver::STATUS_OFFLINE)->count(),
            'active' => Driver::where('is_active', true)->count(),
        ];

        $vehicleTypes = VehicleType::active()->pluck('name', 'id');

        return view('admin.drivers.index', compact('drivers', 'stats', 'vehicleTypes'));
    }

    public function create()
    {
        $vehicleTypes = VehicleType::active()->pluck('name', 'id');
        return view('admin.drivers.create', compact('vehicleTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:drivers',
            'phone' => 'required|string|max:20|unique:drivers',
            'license_number' => 'required|string|max:50|unique:drivers',
            'license_expiry' => 'required|date|after:today',
            'vehicle_registration' => 'nullable|string|max:50',
            'vehicle_type_id' => 'nullable|exists:vehicle_types,id',
            'status' => ['required', Rule::in(array_keys([
                Driver::STATUS_AVAILABLE => 'Available',
                Driver::STATUS_BUSY => 'Busy',
                Driver::STATUS_OFFLINE => 'Offline',
            ]))],
            'is_active' => 'boolean',
        ]);

        Driver::create($validated);

        return redirect()->route('admin.drivers.index')
            ->with('success', 'Driver created successfully.');
    }

    public function show(Driver $driver)
    {
        $driver->load(['vehicleType', 'bookings' => function ($query) {
            $query->latest()->take(10);
        }]);

        $stats = [
            'total_bookings' => $driver->bookings()->count(),
            'completed_bookings' => $driver->bookings()->where('status', 'completed')->count(),
            'cancelled_bookings' => $driver->bookings()->where('status', 'cancelled')->count(),
            'current_booking' => $driver->bookings()
                ->whereIn('status', ['confirmed', 'in_progress'])
                ->with(['pickupCity', 'dropoffCity'])
                ->first(),
        ];

        return view('admin.drivers.show', compact('driver', 'stats'));
    }

    public function edit(Driver $driver)
    {
        $vehicleTypes = VehicleType::active()->pluck('name', 'id');
        return view('admin.drivers.edit', compact('driver', 'vehicleTypes'));
    }

    public function update(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('drivers')->ignore($driver->id)],
            'phone' => ['required', 'string', 'max:20', Rule::unique('drivers')->ignore($driver->id)],
            'license_number' => ['required', 'string', 'max:50', Rule::unique('drivers')->ignore($driver->id)],
            'license_expiry' => 'required|date|after:today',
            'vehicle_registration' => 'nullable|string|max:50',
            'vehicle_type_id' => 'nullable|exists:vehicle_types,id',
            'status' => ['required', Rule::in(array_keys([
                Driver::STATUS_AVAILABLE => 'Available',
                Driver::STATUS_BUSY => 'Busy',
                Driver::STATUS_OFFLINE => 'Offline',
            ]))],
            'is_active' => 'boolean',
        ]);

        $driver->update($validated);

        return redirect()->route('admin.drivers.index')
            ->with('success', 'Driver updated successfully.');
    }

    public function destroy(Driver $driver)
    {
        // Check if driver has active bookings
        if ($driver->bookings()->whereIn('status', ['pending', 'confirmed', 'in_progress'])->exists()) {
            return back()->with('error', 'Cannot delete driver with active bookings.');
        }

        $driver->delete();

        return redirect()->route('admin.drivers.index')
            ->with('success', 'Driver deleted successfully.');
    }

    public function toggle(Driver $driver)
    {
        $driver->update(['is_active' => !$driver->is_active]);

        // Set offline if deactivated
        if (!$driver->is_active) {
            $driver->setOffline();
        }

        $status = $driver->is_active ? 'activated' : 'deactivated';
        
        return redirect()->back()
            ->with('success', "Driver {$status} successfully.");
    }

    public function updateStatus(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in([
                Driver::STATUS_AVAILABLE,
                Driver::STATUS_BUSY,
                Driver::STATUS_OFFLINE,
            ])],
        ]);

        // Check if driver can be set to available
        if ($validated['status'] === Driver::STATUS_AVAILABLE) {
            if (!$driver->is_active || $driver->license_expiry->isPast()) {
                return back()->with('error', 'Driver cannot be set to available due to inactive status or expired license.');
            }
            
            // Check if driver has active bookings
            if ($driver->bookings()->whereIn('status', ['confirmed', 'in_progress'])->exists()) {
                return back()->with('error', 'Driver has active bookings and cannot be set to available.');
            }
        }

        $driver->update(['status' => $validated['status']]);

        return back()->with('success', 'Driver status updated successfully.');
    }
}
