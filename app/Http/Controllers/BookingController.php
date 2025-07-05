<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Airport;
use App\Models\TransportationService;
use App\Models\ServicePricing;
use App\Models\Booking;
use App\Models\User;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

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
     * Get all active airports for dropdown
     */
    public function getAirports()
    {
        try {
            $airports = Airport::active()
                ->with('city')
                ->orderBy('name')
                ->select('id', 'name', 'code', 'city_id')
                ->get();

            return response()->json($airports);
        } catch (\Exception $e) {
            Log::error('Error fetching airports: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch airports'], 500);
        }
    }

    /**
     * Get airports by city
     */
    public function getAirportsByCity(Request $request)
    {
        try {
            $cityId = $request->get('city_id');
            
            if (!$cityId) {
                return response()->json([]);
            }

            $airports = Airport::active()
                ->where('city_id', $cityId)
                ->orderBy('name')
                ->select('id', 'name', 'code')
                ->get();

            return response()->json($airports);
        } catch (\Exception $e) {
            Log::error('Error fetching airports by city: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch airports'], 500);
        }
    }

    /**
     * Get all active vehicle types for dropdown
     */
    public function getVehicleTypes()
    {
        try {
            $vehicleTypes = VehicleType::active()
                ->orderBy('name')
                ->select('id', 'name', 'description', 'capacity')
                ->get();

            return response()->json($vehicleTypes);
        } catch (\Exception $e) {
            Log::error('Error fetching vehicle types: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch vehicle types'], 500);
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
                'password' => 'required|string|min:4|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Handle user registration/authentication
            $user = null;
            $accountCreated = false;
            
            // Check if user already exists
            $existingUser = User::where('email', $request->customer_email)->first();
            
            if ($existingUser) {
                // User exists - verify the password matches
                if (!Hash::check($request->password, $existingUser->password)) {
                    return response()->json([
                        'error' => 'An account with this email already exists. Please use the correct password or use a different email address.',
                        'errors' => [
                            'customer_email' => ['An account with this email already exists.'],
                            'password' => ['Please enter your existing account password.']
                        ]
                    ], 422);
                }
                
                // Update user info if they've changed their name or phone
                $existingUser->update([
                    'name' => $request->customer_name,
                    'phone' => $request->customer_phone,
                ]);
                
                $user = $existingUser;
                
                Log::info('Existing user logged in during booking', [
                    'user_id' => $user->id,
                    'email' => $user->email
                ]);
            } else {
                // Create new user account
                try {
                    $user = User::create([
                        'name' => $request->customer_name,
                        'email' => $request->customer_email,
                        'phone' => $request->customer_phone,
                        'password' => Hash::make($request->password),
                    ]);
                    
                    $accountCreated = true;
                    
                    // Fire the registered event
                    event(new Registered($user));
                    
                    Log::info('New user account created during booking', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'name' => $user->name
                    ]);
                } catch (\Exception $e) {
                    Log::error('Error creating user account during booking: ' . $e->getMessage());
                    return response()->json(['error' => 'Unable to create account. Please try again.'], 500);
                }
            }
            
            // Authenticate the user
            Auth::login($user);

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
                $booking->user_id = $user->id; // Now always linked to authenticated user
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
                
                Log::info('Booking created successfully', [
                    'booking_id' => $booking->id,
                    'booking_reference' => $booking->booking_reference,
                    'user_id' => $user->id,
                    'account_created' => $accountCreated
                ]);
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
                'account_created' => $accountCreated,
                'user_id' => $user->id,
                'message' => $accountCreated 
                    ? 'Booking successful! Your SafariConnect account has been created. We will contact you shortly with confirmation details.'
                    : 'Booking successful! We will contact you shortly with confirmation details.',
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
                ],
                'account_info' => [
                    'account_created' => $accountCreated,
                    'login_email' => $user->email,
                    'user_authenticated' => true
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error booking shared ride: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to process booking. Please try again.'], 500);
        }
    }

    /**
     * Get pricing for solo ride between two cities with specific vehicle type
     */
    public function getSoloRidePricing(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'pickup_city_id' => 'required|exists:cities,id',
                'dropoff_city_id' => 'required|exists:cities,id|different:pickup_city_id',
                'vehicle_type_id' => 'required|exists:vehicle_types,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Get solo ride service
            $soloRideService = TransportationService::where('service_type', 'solo_ride')
                ->where('is_active', true)
                ->first();

            if (!$soloRideService) {
                return response()->json(['error' => 'Solo ride service not available'], 404);
            }

            // Get pricing for the route and vehicle type
            $pricing = ServicePricing::where('transportation_service_id', $soloRideService->id)
                ->where('pickup_city_id', $request->pickup_city_id)
                ->where('dropoff_city_id', $request->dropoff_city_id)
                ->where('vehicle_type_id', $request->vehicle_type_id)
                ->where('is_active', true)
                ->first();

            if (!$pricing) {
                // Try reverse route
                $pricing = ServicePricing::where('transportation_service_id', $soloRideService->id)
                    ->where('pickup_city_id', $request->dropoff_city_id)
                    ->where('dropoff_city_id', $request->pickup_city_id)
                    ->where('vehicle_type_id', $request->vehicle_type_id)
                    ->where('is_active', true)
                    ->first();
            }

            if (!$pricing) {
                return response()->json(['error' => 'No pricing available for this route and vehicle type'], 404);
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
                'service_id' => $soloRideService->id,
                'pricing_id' => $pricing->id,
                'vehicle_type_id' => $request->vehicle_type_id,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching solo ride pricing: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch pricing'], 500);
        }
    }

    /**
     * Book a solo ride
     */
    public function bookSoloRide(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'pickup_city_id' => 'required|exists:cities,id',
                'dropoff_city_id' => 'required|exists:cities,id|different:pickup_city_id',
                'vehicle_type_id' => 'required|exists:vehicle_types,id',
                'travel_date' => 'required|date|after_or_equal:today',
                'travel_time' => 'required|date_format:H:i',
                'passengers' => 'required|integer|min:1|max:10',
                'customer_name' => 'required|string|max:255',
                'customer_email' => 'required|email|max:255',
                'customer_phone' => 'required|string|max:20',
                'password' => 'required|string|min:4|confirmed',
                'special_requirements' => 'nullable|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Handle user registration/authentication
            $user = null;
            $accountCreated = false;
            
            // Check if user already exists
            $existingUser = User::where('email', $request->customer_email)->first();
            
            if ($existingUser) {
                // User exists - verify the password matches
                if (!Hash::check($request->password, $existingUser->password)) {
                    return response()->json([
                        'error' => 'An account with this email already exists. Please use the correct password or use a different email address.',
                        'errors' => [
                            'customer_email' => ['An account with this email already exists.'],
                            'password' => ['Please enter your existing account password.']
                        ]
                    ], 422);
                }
                
                // Update user info if they've changed their name or phone
                $existingUser->update([
                    'name' => $request->customer_name,
                    'phone' => $request->customer_phone,
                ]);
                
                $user = $existingUser;
                
                Log::info('Existing user logged in during solo ride booking', [
                    'user_id' => $user->id,
                    'email' => $user->email
                ]);
            } else {
                // Create new user account
                try {
                    $user = User::create([
                        'name' => $request->customer_name,
                        'email' => $request->customer_email,
                        'phone' => $request->customer_phone,
                        'password' => Hash::make($request->password),
                    ]);
                    
                    $accountCreated = true;
                    
                    // Fire the registered event
                    event(new Registered($user));
                    
                    Log::info('New user account created during solo ride booking', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'name' => $user->name
                    ]);
                } catch (\Exception $e) {
                    Log::error('Error creating user account during solo ride booking: ' . $e->getMessage());
                    return response()->json(['error' => 'Unable to create account. Please try again.'], 500);
                }
            }
            
            // Authenticate the user
            Auth::login($user);

            // Get solo ride service
            $soloRideService = TransportationService::where('service_type', 'solo_ride')
                ->where('is_active', true)
                ->first();

            if (!$soloRideService) {
                return response()->json(['error' => 'Solo ride service not available'], 404);
            }

            // Get pricing
            $pricing = ServicePricing::where('transportation_service_id', $soloRideService->id)
                ->where('pickup_city_id', $request->pickup_city_id)
                ->where('dropoff_city_id', $request->dropoff_city_id)
                ->where('vehicle_type_id', $request->vehicle_type_id)
                ->where('is_active', true)
                ->first();

            if (!$pricing) {
                // Try reverse route
                $pricing = ServicePricing::where('transportation_service_id', $soloRideService->id)
                    ->where('pickup_city_id', $request->dropoff_city_id)
                    ->where('dropoff_city_id', $request->pickup_city_id)
                    ->where('vehicle_type_id', $request->vehicle_type_id)
                    ->where('is_active', true)
                    ->first();
            }

            if (!$pricing) {
                return response()->json(['error' => 'No pricing available for this route and vehicle type'], 404);
            }

            // Calculate total price
            $travelDateTime = $request->travel_date . ' ' . $request->travel_time;
            $isWeekend = in_array(date('w', strtotime($request->travel_date)), [0, 6]);
            $basePrice = $pricing->calculateTotalPrice($travelDateTime, $isWeekend);
            
            // For solo rides, price doesn't multiply by passengers (it's the total price for the vehicle)
            $totalPrice = $basePrice;

            // Debug: Log the data being saved
            Log::info('Creating solo ride booking with data:', [
                'service_id' => $soloRideService->id,
                'pricing_id' => $pricing->id,
                'vehicle_type_id' => $request->vehicle_type_id,
                'customer' => $request->customer_name,
                'route' => $request->pickup_city_id . ' to ' . $request->dropoff_city_id,
                'travel' => $request->travel_date . ' ' . $request->travel_time,
                'price' => $totalPrice
            ]);

            // Create booking record
            try {
                $booking = new Booking();
                $booking->transportation_service_id = $soloRideService->id;
                $booking->service_pricing_id = $pricing->id;
                $booking->user_id = $user->id;
                $booking->customer_name = $request->customer_name;
                $booking->customer_email = $request->customer_email;
                $booking->customer_phone = $request->customer_phone;
                $booking->pickup_city_id = $request->pickup_city_id;
                $booking->dropoff_city_id = $request->dropoff_city_id;
                $booking->vehicle_type_id = $request->vehicle_type_id;
                $booking->travel_date = $request->travel_date;
                $booking->travel_time = $request->travel_time;
                $booking->passengers = $request->passengers;
                $booking->price_per_unit = $basePrice;
                $booking->total_price = $totalPrice;
                $booking->special_requirements = $request->special_requirements;
                $booking->status = Booking::STATUS_PENDING;
                $booking->payment_status = Booking::PAYMENT_STATUS_PENDING;
                $booking->save();
                
                Log::info('Solo ride booking created successfully', [
                    'booking_id' => $booking->id,
                    'booking_reference' => $booking->booking_reference,
                    'user_id' => $user->id,
                    'account_created' => $accountCreated
                ]);
            } catch (\Exception $e) {
                Log::error('Error creating solo ride booking: ' . $e->getMessage());
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
                'account_created' => $accountCreated,
                'user_id' => $user->id,
                'message' => $accountCreated 
                    ? 'Solo ride booking successful! Your SafariConnect account has been created. We will contact you shortly with confirmation details and driver assignment.'
                    : 'Solo ride booking successful! We will contact you shortly with confirmation details and driver assignment.',
                'booking_details' => [
                    'service' => 'Solo Ride',
                    'route' => $pricing->route_description,
                    'vehicle_type' => $request->vehicle_type_id,
                    'travel_date' => $request->travel_date,
                    'travel_time' => $request->travel_time,
                    'passengers' => $request->passengers,
                    'total_price' => $totalPrice,
                    'customer_name' => $request->customer_name,
                    'customer_email' => $request->customer_email,
                    'customer_phone' => $request->customer_phone,
                    'special_requirements' => $request->special_requirements,
                ],
                'account_info' => [
                    'account_created' => $accountCreated,
                    'login_email' => $user->email,
                    'user_authenticated' => true
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error booking solo ride: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to process solo ride booking. Please try again.'], 500);
        }
    }

    /**
     * Get pricing for airport transfer
     */
    public function getAirportTransferPricing(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'transfer_type' => 'required|in:pickup,dropoff',
                'vehicle_type_id' => 'required|exists:vehicle_types,id',
                'pickup_airport_id' => 'required_if:transfer_type,pickup|exists:airports,id',
                'dropoff_city_id' => 'required_if:transfer_type,pickup|exists:cities,id',
                'pickup_city_id' => 'required_if:transfer_type,dropoff|exists:cities,id',
                'dropoff_airport_id' => 'required_if:transfer_type,dropoff|exists:airports,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Get airport transfer service
            $airportTransferService = TransportationService::where('service_type', 'airport_transfer')
                ->where('is_active', true)
                ->first();

            if (!$airportTransferService) {
                return response()->json(['error' => 'Airport transfer service not available'], 404);
            }

            // Build pricing query based on transfer type
            $pricingQuery = ServicePricing::where('transportation_service_id', $airportTransferService->id)
                ->where('transfer_type', $request->transfer_type)
                ->where('vehicle_type_id', $request->vehicle_type_id)
                ->where('is_active', true);

            if ($request->transfer_type === 'pickup') {
                $pricingQuery->where('pickup_airport_id', $request->pickup_airport_id)
                           ->where('dropoff_city_id', $request->dropoff_city_id);
            } else {
                $pricingQuery->where('pickup_city_id', $request->pickup_city_id)
                           ->where('dropoff_airport_id', $request->dropoff_airport_id);
            }

            $pricing = $pricingQuery->first();

            if (!$pricing) {
                return response()->json(['error' => 'No pricing available for this airport transfer route'], 404);
            }

            // Calculate price with any applicable surcharges
            $travelDateTime = $request->travel_date . ' ' . $request->travel_time;
            $isWeekend = in_array(date('w', strtotime($request->travel_date)), [0, 6]);
            $totalPrice = $pricing->calculateTotalPrice($travelDateTime, $isWeekend);

            // Add airport surcharges
            if ($request->transfer_type === 'pickup' && $pricing->airport_pickup_surcharge > 0) {
                $totalPrice += $pricing->airport_pickup_surcharge;
            } elseif ($request->transfer_type === 'dropoff' && $pricing->airport_dropoff_surcharge > 0) {
                $totalPrice += $pricing->airport_dropoff_surcharge;
            }

            return response()->json([
                'price' => $totalPrice,
                'base_price' => $pricing->base_price,
                'route' => $pricing->route_description,
                'transfer_type' => $request->transfer_type,
                'airport_surcharge' => $request->transfer_type === 'pickup' ? $pricing->airport_pickup_surcharge : $pricing->airport_dropoff_surcharge,
                'service_id' => $airportTransferService->id,
                'pricing_id' => $pricing->id,
                'vehicle_type_id' => $request->vehicle_type_id,
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching airport transfer pricing: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch pricing'], 500);
        }
    }

    /**
     * Book an airport transfer
     */
    public function bookAirportTransfer(Request $request)
    {
        try {
            // First validate basic fields
            $basicValidator = Validator::make($request->all(), [
                'transfer_type' => 'required|in:pickup,dropoff',
                'vehicle_type_id' => 'required|exists:vehicle_types,id',
                'travel_date' => 'required|date|after_or_equal:today',
                'travel_time' => 'required|date_format:H:i',
                'passengers' => 'required|integer|min:1|max:8',
                'customer_name' => 'required|string|max:255',
                'customer_email' => 'required|email|max:255',
                'customer_phone' => 'required|string|max:20',
                'password' => 'required|string|min:4|confirmed',
                'flight_number' => 'nullable|string|max:20',
                'special_requirements' => 'nullable|string|max:1000',
            ]);

            if ($basicValidator->fails()) {
                return response()->json(['errors' => $basicValidator->errors()], 422);
            }

            // Validate transfer-type specific fields
            if ($request->transfer_type === 'pickup') {
                $transferValidator = Validator::make($request->all(), [
                    'pickup_airport_id' => 'required|exists:airports,id',
                    'dropoff_city_id' => 'required|exists:cities,id',
                ]);
            } else {
                $transferValidator = Validator::make($request->all(), [
                    'pickup_city_id' => 'required|exists:cities,id',
                    'dropoff_airport_id' => 'required|exists:airports,id',
                ]);
            }

            if ($transferValidator->fails()) {
                return response()->json(['errors' => $transferValidator->errors()], 422);
            }

            // Handle user registration/authentication
            $user = null;
            $accountCreated = false;
            
            // Check if user already exists
            $existingUser = User::where('email', $request->customer_email)->first();
            
            if ($existingUser) {
                // User exists - verify the password matches
                if (!Hash::check($request->password, $existingUser->password)) {
                    return response()->json([
                        'error' => 'An account with this email already exists. Please use the correct password or use a different email address.',
                        'errors' => [
                            'customer_email' => ['An account with this email already exists.'],
                            'password' => ['Please enter your existing account password.']
                        ]
                    ], 422);
                }
                
                // Update user info if they've changed their name or phone
                $existingUser->update([
                    'name' => $request->customer_name,
                    'phone' => $request->customer_phone,
                ]);
                
                $user = $existingUser;
                
                Log::info('Existing user logged in during airport transfer booking', [
                    'user_id' => $user->id,
                    'email' => $user->email
                ]);
            } else {
                // Create new user account
                try {
                    $user = User::create([
                        'name' => $request->customer_name,
                        'email' => $request->customer_email,
                        'phone' => $request->customer_phone,
                        'password' => Hash::make($request->password),
                    ]);
                    
                    $accountCreated = true;
                    
                    // Fire the registered event
                    event(new Registered($user));
                    
                    Log::info('New user account created during airport transfer booking', [
                        'user_id' => $user->id,
                        'email' => $user->email,
                        'name' => $user->name
                    ]);
                } catch (\Exception $e) {
                    Log::error('Error creating user account during airport transfer booking: ' . $e->getMessage());
                    return response()->json(['error' => 'Unable to create account. Please try again.'], 500);
                }
            }
            
            // Authenticate the user
            Auth::login($user);

            // Get airport transfer service
            $airportTransferService = TransportationService::where('service_type', 'airport_transfer')
                ->where('is_active', true)
                ->first();

            if (!$airportTransferService) {
                return response()->json(['error' => 'Airport transfer service not available'], 404);
            }

            // Get pricing
            $pricingQuery = ServicePricing::where('transportation_service_id', $airportTransferService->id)
                ->where('transfer_type', $request->transfer_type)
                ->where('vehicle_type_id', $request->vehicle_type_id)
                ->where('is_active', true);

            if ($request->transfer_type === 'pickup') {
                $pricingQuery->where('pickup_airport_id', $request->pickup_airport_id)
                           ->where('dropoff_city_id', $request->dropoff_city_id);
            } else {
                $pricingQuery->where('pickup_city_id', $request->pickup_city_id)
                           ->where('dropoff_airport_id', $request->dropoff_airport_id);
            }

            $pricing = $pricingQuery->first();

            if (!$pricing) {
                return response()->json(['error' => 'No pricing available for this airport transfer route'], 404);
            }

            // Calculate total price
            $travelDateTime = $request->travel_date . ' ' . $request->travel_time;
            $isWeekend = in_array(date('w', strtotime($request->travel_date)), [0, 6]);
            $basePrice = $pricing->calculateTotalPrice($travelDateTime, $isWeekend);
            
            // Add airport surcharges
            $surchargeAmount = 0;
            if ($request->transfer_type === 'pickup' && $pricing->airport_pickup_surcharge > 0) {
                $surchargeAmount = $pricing->airport_pickup_surcharge;
            } elseif ($request->transfer_type === 'dropoff' && $pricing->airport_dropoff_surcharge > 0) {
                $surchargeAmount = $pricing->airport_dropoff_surcharge;
            }
            
            $totalPrice = $basePrice + $surchargeAmount;

            // Debug: Log the data being saved
            Log::info('Creating airport transfer booking with data:', [
                'service_id' => $airportTransferService->id,
                'pricing_id' => $pricing->id,
                'transfer_type' => $request->transfer_type,
                'vehicle_type_id' => $request->vehicle_type_id,
                'customer' => $request->customer_name,
                'travel' => $request->travel_date . ' ' . $request->travel_time,
                'price' => $totalPrice
            ]);

            // Create booking record
            try {
                $booking = new Booking();
                $booking->transportation_service_id = $airportTransferService->id;
                $booking->service_pricing_id = $pricing->id;
                $booking->user_id = $user->id;
                $booking->customer_name = $request->customer_name;
                $booking->customer_email = $request->customer_email;
                $booking->customer_phone = $request->customer_phone;
                
                // Set city and airport fields based on transfer type
                if ($request->transfer_type === 'pickup') {
                    $booking->pickup_airport_id = $request->pickup_airport_id;
                    $booking->dropoff_city_id = $request->dropoff_city_id;
                    $booking->pickup_city_id = null;
                    $booking->dropoff_airport_id = null;
                } else {
                    $booking->pickup_city_id = $request->pickup_city_id;
                    $booking->dropoff_airport_id = $request->dropoff_airport_id;
                    $booking->pickup_airport_id = null;
                    $booking->dropoff_city_id = null;
                }
                
                $booking->vehicle_type_id = $request->vehicle_type_id;
                $booking->travel_date = $request->travel_date;
                $booking->travel_time = $request->travel_time;
                $booking->passengers = $request->passengers;
                $booking->transfer_type = $request->transfer_type;
                $booking->price_per_unit = $basePrice;
                $booking->total_price = $totalPrice;
                $booking->surcharge_amount = $surchargeAmount;
                $booking->flight_number = $request->flight_number;
                $booking->special_requirements = $request->special_requirements;
                $booking->status = Booking::STATUS_PENDING;
                $booking->payment_status = Booking::PAYMENT_STATUS_PENDING;
                $booking->save();
                
                Log::info('Airport transfer booking created successfully', [
                    'booking_id' => $booking->id,
                    'booking_reference' => $booking->booking_reference,
                    'user_id' => $user->id,
                    'account_created' => $accountCreated
                ]);
            } catch (\Exception $e) {
                Log::error('Error creating airport transfer booking: ' . $e->getMessage());
                Log::error('Stack trace: ' . $e->getTraceAsString());
                throw $e;
            }

            return response()->json([
                'success' => true,
                'booking_reference' => $booking->booking_reference,
                'account_created' => $accountCreated,
                'user_id' => $user->id,
                'message' => $accountCreated 
                    ? 'Airport transfer booking successful! Your SafariConnect account has been created. We will contact you shortly with confirmation details and driver assignment.'
                    : 'Airport transfer booking successful! We will contact you shortly with confirmation details and driver assignment.',
                'booking_details' => [
                    'service' => 'Airport Transfer',
                    'transfer_type' => ucfirst($request->transfer_type),
                    'route' => $pricing->route_description,
                    'vehicle_type' => $request->vehicle_type_id,
                    'travel_date' => $request->travel_date,
                    'travel_time' => $request->travel_time,
                    'passengers' => $request->passengers,
                    'base_price' => $basePrice,
                    'surcharge_amount' => $surchargeAmount,
                    'total_price' => $totalPrice,
                    'customer_name' => $request->customer_name,
                    'customer_email' => $request->customer_email,
                    'customer_phone' => $request->customer_phone,
                    'flight_number' => $request->flight_number,
                    'special_requirements' => $request->special_requirements,
                ],
                'account_info' => [
                    'account_created' => $accountCreated,
                    'login_email' => $user->email,
                    'user_authenticated' => true
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error booking airport transfer: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to process airport transfer booking. Please try again.'], 500);
        }
    }
}