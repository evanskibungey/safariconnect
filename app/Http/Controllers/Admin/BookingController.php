<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Driver;
use App\Models\TransportationService;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with([
            'transportationService',
            'pickupCity',
            'dropoffCity',
            'driver',
            'vehicleType'
        ]);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->where('travel_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('travel_date', '<=', $request->date_to);
        }

        // Filter by service type
        if ($request->filled('service_type')) {
            $query->whereHas('transportationService', function ($q) use ($request) {
                $q->where('service_type', $request->service_type);
            });
        }

        // Search by customer
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_reference', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
            });
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate(20);

        $stats = [
            'total' => Booking::count(),
            'pending' => Booking::pending()->count(),
            'confirmed' => Booking::confirmed()->count(),
            'completed' => Booking::completed()->count(),
            'today' => Booking::whereDate('travel_date', today())->count(),
        ];

        $services = TransportationService::active()->pluck('name', 'service_type');

        return view('admin.bookings.index', compact('bookings', 'stats', 'services'));
    }

    public function show(Booking $booking)
    {
        $booking->load([
            'transportationService',
            'servicePricing',
            'pickupCity',
            'dropoffCity',
            'pickupAirport',
            'dropoffAirport',
            'vehicleType',
            'driver',
            'user'
        ]);

        // Get available drivers for assignment
        $availableDrivers = null;
        if (!$booking->driver_id && in_array($booking->status, [Booking::STATUS_PENDING, Booking::STATUS_CONFIRMED])) {
            $query = Driver::available();
            
            // Filter by vehicle type if applicable
            if ($booking->vehicleType) {
                $query->forVehicleType($booking->vehicle_type_id);
            }
            
            $availableDrivers = $query->get();
        }

        return view('admin.bookings.show', compact('booking', 'availableDrivers'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', [
                Booking::STATUS_PENDING,
                Booking::STATUS_CONFIRMED,
                Booking::STATUS_IN_PROGRESS,
                Booking::STATUS_COMPLETED,
                Booking::STATUS_CANCELLED
            ]),
            'admin_notes' => 'nullable|string',
            'cancellation_reason' => 'required_if:status,' . Booking::STATUS_CANCELLED . '|nullable|string',
        ]);

        // Handle status changes
        $oldStatus = $booking->status;
        $booking->fill($validated);

        if ($oldStatus !== $booking->status) {
            switch ($booking->status) {
                case Booking::STATUS_CONFIRMED:
                    $booking->confirmed_at = now();
                    break;
                case Booking::STATUS_CANCELLED:
                    $booking->cancelled_at = now();
                    // Release driver if assigned
                    if ($booking->driver) {
                        $booking->driver->setAvailable();
                    }
                    break;
                case Booking::STATUS_COMPLETED:
                    // Release driver
                    if ($booking->driver) {
                        $booking->driver->setAvailable();
                    }
                    break;
            }
        }

        $booking->save();

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Booking updated successfully.');
    }

    public function assignDriver(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'driver_id' => 'required|exists:drivers,id',
        ]);

        $driver = Driver::findOrFail($validated['driver_id']);

        // Check if driver is available
        if (!$driver->canBeAssigned()) {
            return back()->with('error', 'Selected driver is not available for assignment.');
        }

        // Assign driver
        $booking->assignDriver($driver);

        // Auto-confirm booking if pending
        if ($booking->status === Booking::STATUS_PENDING) {
            $booking->confirm();
        }

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Driver assigned successfully.');
    }

    public function removeDriver(Booking $booking)
    {
        if ($booking->driver) {
            $booking->driver->setAvailable();
            $booking->update([
                'driver_id' => null,
                'driver_assigned_at' => null,
            ]);
        }

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Driver removed from booking.');
    }

    public function destroy(Booking $booking)
    {
        // Only allow deletion of cancelled bookings
        if ($booking->status !== Booking::STATUS_CANCELLED) {
            return back()->with('error', 'Only cancelled bookings can be deleted.');
        }

        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }

    // Quick actions
    public function confirm(Booking $booking)
    {
        if ($booking->status !== Booking::STATUS_PENDING) {
            return back()->with('error', 'Only pending bookings can be confirmed.');
        }

        $booking->confirm();

        return back()->with('success', 'Booking confirmed successfully.');
    }

    public function cancel(Request $request, Booking $booking)
    {
        if (in_array($booking->status, [Booking::STATUS_COMPLETED, Booking::STATUS_CANCELLED])) {
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        $booking->cancel($request->reason);

        // Release driver if assigned
        if ($booking->driver) {
            $booking->driver->setAvailable();
        }

        return back()->with('success', 'Booking cancelled successfully.');
    }
}
