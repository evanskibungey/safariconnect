<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerBookingController extends Controller
{
    /**
     * Show booking details for authenticated customer
     */
    public function show(Booking $booking)
    {
        // Ensure the booking belongs to the authenticated user
        if ($booking->user_id !== Auth::id()) {
            abort(404);
        }

        // Load relationships
        $booking->load([
            'transportationService',
            'servicePricing',
            'pickupCity',
            'dropoffCity',
            'pickupAirport',
            'dropoffAirport',
            'vehicleType',
            'driver'
        ]);

        return view('customer.booking-details', compact('booking'));
    }

    /**
     * Show booking history for authenticated customer
     */
    public function history(Request $request)
    {
        $query = Auth::user()->bookings()
            ->with([
                'transportationService',
                'pickupCity',
                'dropoffCity',
                'pickupAirport',
                'dropoffAirport',
                'vehicleType',
                'driver'
            ]);

        // Filter by status if provided
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Filter by service type if provided
        if ($request->has('service') && $request->service !== '') {
            $query->whereHas('transportationService', function($q) use ($request) {
                $q->where('service_type', $request->service);
            });
        }

        // Search by booking reference
        if ($request->has('search') && $request->search !== '') {
            $query->where('booking_reference', 'LIKE', '%' . $request->search . '%');
        }

        // Sort by latest first
        $bookings = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get available filters
        $statuses = [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled'
        ];

        $serviceTypes = [
            'shared_ride' => 'Shared Ride',
            'solo_ride' => 'Solo Ride',
            'airport_transfer' => 'Airport Transfer',
            'car_hire' => 'Car Hire',
            'parcel_delivery' => 'Parcel Delivery'
        ];

        return view('customer.booking-history', compact('bookings', 'statuses', 'serviceTypes'));
    }

    /**
     * Cancel a booking (only if pending)
     */
    public function cancel(Request $request, Booking $booking)
    {
        // Ensure the booking belongs to the authenticated user
        if ($booking->user_id !== Auth::id()) {
            abort(404);
        }

        // Only allow cancellation of pending bookings
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be cancelled.');
        }

        // Cancel the booking
        $booking->cancel($request->input('reason', 'Cancelled by customer'));

        return back()->with('success', 'Booking cancelled successfully.');
    }
}
