<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\TransportationService;
use App\Models\ServicePricing;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    /**
     * Get all active cities for dropdown
     */
    public function getCities()
    {
        try {
            $cities = City::active()
                ->orderBy('name')
                ->select('id', 'name')
                ->get();

            return response()->json($cities);
        } catch (\Exception $e) {
            Log::error('Error fetching cities: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch cities'], 500);
        }
    }

    /**
     * Get pricing for shared ride between two cities
     */
    public function getSharedRidePricing(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'pickup_city_id' => 'required|exists:cities,id',
                'dropoff_city_id' => 'required|exists:cities,id|different:pickup_city_id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Get shared ride service
            $sharedRideService = TransportationService::where('service_type', 'shared_ride')
                ->where('is_active', true)
                ->first();

            if (!$sharedRideService) {
                return response()->json(['error' => 'Shared ride service not available'], 404);
            }

            // Get pricing for the route
            $pricing = ServicePricing::where('transportation_service_id', $sharedRideService->id)
                ->where('pickup_city_id', $request->pickup_city_id)
                ->where('dropoff_city_id', $request->dropoff_city_id)
                ->where('is_active', true)
                ->first();

            if (!$pricing) {
                // Try reverse route
                $pricing = ServicePricing::where('transportation_service_id', $sharedRideService->id)
                    ->where('pickup_city_id', $request->dropoff_city_id)
                    ->where('dropoff_city_id', $request->pickup_city_id)
                    ->where('is_active', true)
                    ->first();
            }

            if (!$pricing) {
                return response()->json(['error' => 'No pricing available for this route'], 404);
            }

            // Calculate price with any applicable surcharges
            $travelDateTime = $request->travel_date . ' ' . $request->travel_time;
            $isWeekend = in_array(date('w', strtotime($request->travel_date)), [0, 6]);
            $totalPrice = $pricing->calculateTotalPrice($travelDateTime, $isWeekend);

            return response()->json([
                'price' => $totalPrice,
                'base_price' => $pricing->base_price,
                'route' => $pricing->route_description,
                'distance_km' => $pricing->distance_km,
                'service_id' => $sharedRideService->id,
                'pricing_id' => $pricing->id,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching shared ride pricing: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch pricing'], 500);
        }
    }

    /**
     * Book a shared ride
     */
    public function bookSharedRide(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'pickup_city_id' => 'required|exists:cities,id',
                'dropoff_city_id' => 'required|exists:cities,id|different:pickup_city_id',
                'travel_date' => 'required|date|after_or_equal:today',
                'travel_time' => 'required|date_format:H:i',
                'passengers' => 'required|integer|min:1|max:4',
                'customer_name' => 'required|string|max:255',
                'customer_email' => 'required|email|max:255',
                'customer_phone' => 'required|string|max:20',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Get shared ride service
            $sharedRideService = TransportationService::where('service_type', 'shared_ride')
                ->where('is_active', true)
                ->first();

            if (!$sharedRideService) {
                return response()->json(['error' => 'Shared ride service not available'], 404);
            }

            // Get pricing
            $pricing = ServicePricing::where('transportation_service_id', $sharedRideService->id)
                ->where('pickup_city_id', $request->pickup_city_id)
                ->where('dropoff_city_id', $request->dropoff_city_id)
                ->where('is_active', true)
                ->first();

            if (!$pricing) {
                // Try reverse route
                $pricing = ServicePricing::where('transportation_service_id', $sharedRideService->id)
                    ->where('pickup_city_id', $request->dropoff_city_id)
                    ->where('dropoff_city_id', $request->pickup_city_id)
                    ->where('is_active', true)
                    ->first();
            }

            if (!$pricing) {
                return response()->json(['error' => 'No pricing available for this route'], 404);
            }

            // Calculate total price
            $travelDateTime = $request->travel_date . ' ' . $request->travel_time;
            $isWeekend = in_array(date('w', strtotime($request->travel_date)), [0, 6]);
            $pricePerPassenger = $pricing->calculateTotalPrice($travelDateTime, $isWeekend);
            $totalPrice = $pricePerPassenger * $request->passengers;

            // Debug: Log the data being saved
            Log::info('Creating booking with data:', [
                'service_id' => $sharedRideService->id,
                'pricing_id' => $pricing->id,
                'customer' => $request->customer_name,
                'route' => $request->pickup_city_id . ' to ' . $request->dropoff_city_id,
                'travel' => $request->travel_date . ' ' . $request->travel_time,
                'price' => $totalPrice
            ]);

            // Create booking record
            try {
                $booking = new Booking();
                $booking->transportation_service_id = $sharedRideService->id;
                $booking->service_pricing_id = $pricing->id;
                $booking->user_id = auth()->id(); // Will be null if not logged in
                $booking->customer_name = $request->customer_name;
                $booking->customer_email = $request->customer_email;
                $booking->customer_phone = $request->customer_phone;
                $booking->pickup_city_id = $request->pickup_city_id;
                $booking->dropoff_city_id = $request->dropoff_city_id;
                $booking->travel_date = $request->travel_date;
                $booking->travel_time = $request->travel_time;
                $booking->passengers = $request->passengers;
                $booking->price_per_unit = $pricePerPassenger;
                $booking->total_price = $totalPrice;
                $booking->status = Booking::STATUS_PENDING;
                $booking->payment_status = Booking::PAYMENT_STATUS_PENDING;
                $booking->save();
            } catch (\Exception $e) {
                Log::error('Error creating booking: ' . $e->getMessage());
                Log::error('Stack trace: ' . $e->getTraceAsString());
                throw $e;
            }

            // In a production application, you would also:
            // 1. Send confirmation email
            // 2. Send SMS notification
            // 3. Process payment if required
            // 4. Notify drivers/operators

            return response()->json([
                'success' => true,
                'booking_reference' => $booking->booking_reference,
                'message' => 'Booking successful! We will contact you shortly with confirmation details.',
                'booking_details' => [
                    'service' => 'Shared Ride',
                    'route' => $pricing->route_description,
                    'travel_date' => $request->travel_date,
                    'travel_time' => $request->travel_time,
                    'passengers' => $request->passengers,
                    'price_per_passenger' => $pricePerPassenger,
                    'total_price' => $totalPrice,
                    'customer_name' => $request->customer_name,
                    'customer_email' => $request->customer_email,
                    'customer_phone' => $request->customer_phone,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error booking shared ride: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to process booking. Please try again.'], 500);
        }
    }
}
