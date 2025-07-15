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
     * Handle user authentication/registration for booking
     */
    protected function handleUserForBooking(Request $request)
    {
        $user = null;
        $accountCreated = false;
        
        // If user is already authenticated, use the authenticated user
        if (Auth::check()) {
            $user = Auth::user();
            
            // Update user info if they've changed their name or phone
            $user->update([
                'name' => $request->customer_name,
                'phone' => $request->customer_phone,
            ]);
            
            Log::info('Authenticated user making booking', [
                'user_id' => $user->id,
                'email' => $user->email
            ]);
        } else {
            // Check if user already exists
            $existingUser = User::where('email', $request->customer_email)->first();
            
            if ($existingUser) {
                // User exists - verify the password matches
                if (!Hash::check($request->password, $existingUser->password)) {
                    throw new \Exception('password_mismatch');
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
            }
            
            // Authenticate the user
            Auth::login($user);
        }
        
        return [$user, $accountCreated];
    }

    /**
     * Get base validation rules for booking (without password for authenticated users)
     */
    protected function getBookingValidationRules($additionalRules = [])
    {
        $baseRules = [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ];

        // Add password validation only if user is not authenticated
        if (!Auth::check()) {
            $baseRules['password'] = 'required|string|min:4|confirmed';
        }

        return array_merge($baseRules, $additionalRules);
    }
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
                'passengers' => 'required|integer|min:1|max:7',
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
            $pricePerPassenger = $pricing->calculateTotalPrice($travelDateTime, $isWeekend);
            
            // Multiply by number of passengers for shared rides
            $passengers = $request->passengers;
            $totalPrice = $pricePerPassenger * $passengers;

            return response()->json([
                'price' => $totalPrice,
                'price_per_passenger' => $pricePerPassenger,
                'passengers' => $passengers,
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
            // Base validation rules
            $rules = [
                'pickup_city_id' => 'required|exists:cities,id',
                'dropoff_city_id' => 'required|exists:cities,id|different:pickup_city_id',
                'travel_date' => 'required|date|after_or_equal:today',
                'travel_time' => 'required|date_format:H:i',
                'passengers' => 'required|integer|min:1|max:7',
                'customer_name' => 'required|string|max:255',
                'customer_email' => 'required|email|max:255',
                'customer_phone' => 'required|string|max:20',
            ];

            // Add password validation only if user is not authenticated
            if (!Auth::check()) {
                $rules['password'] = 'required|string|min:4|confirmed';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Handle user registration/authentication
            $user = null;
            $accountCreated = false;
            
            // If user is already authenticated, use the authenticated user
            if (Auth::check()) {
                $user = Auth::user();
                
                // Update user info if they've changed their name or phone
                $user->update([
                    'name' => $request->customer_name,
                    'phone' => $request->customer_phone,
                ]);
                
                Log::info('Authenticated user making booking', [
                    'user_id' => $user->id,
                    'email' => $user->email
                ]);
            } else {
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

            // Get cities for route description
            $pickupCity = City::find($request->pickup_city_id);
            $dropoffCity = City::find($request->dropoff_city_id);
            $routeDescription = ($pickupCity ? $pickupCity->name : 'Unknown') . ' → ' . ($dropoffCity ? $dropoffCity->name : 'Unknown');
            
            // Format travel date and time
            $travelDate = \Carbon\Carbon::parse($request->travel_date)->format('l, F j, Y');
            
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
                    'route' => $routeDescription,
                    'travel_date' => $travelDate,
                    'travel_time' => $request->travel_time,
                    'travel_info' => $travelDate . ' at ' . $request->travel_time,
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
            // Base validation rules
            $rules = [
                'pickup_city_id' => 'required|exists:cities,id',
                'dropoff_city_id' => 'required|exists:cities,id|different:pickup_city_id',
                'vehicle_type_id' => 'required|exists:vehicle_types,id',
                'travel_date' => 'required|date|after_or_equal:today',
                'travel_time' => 'required|date_format:H:i',
                'passengers' => 'required|integer|min:1|max:10',
                'customer_name' => 'required|string|max:255',
                'customer_email' => 'required|email|max:255',
                'customer_phone' => 'required|string|max:20',
                'special_requirements' => 'nullable|string|max:1000',
            ];

            // Add password validation only if user is not authenticated
            if (!Auth::check()) {
                $rules['password'] = 'required|string|min:4|confirmed';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Handle user registration/authentication
            $user = null;
            $accountCreated = false;
            
            // If user is already authenticated, use the authenticated user
            if (Auth::check()) {
                $user = Auth::user();
                
                // Update user info if they've changed their name or phone
                $user->update([
                    'name' => $request->customer_name,
                    'phone' => $request->customer_phone,
                ]);
                
                Log::info('Authenticated user making solo ride booking', [
                    'user_id' => $user->id,
                    'email' => $user->email
                ]);
            } else {
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
            }

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
            // Base validation rules
            $baseRules = $this->getBookingValidationRules([
                'transfer_type' => 'required|in:pickup,dropoff',
                'vehicle_type_id' => 'required|exists:vehicle_types,id',
                'travel_date' => 'required|date|after_or_equal:today',
                'travel_time' => 'required|date_format:H:i',
                'passengers' => 'required|integer|min:1|max:8',
                'flight_number' => 'nullable|string|max:20',
                'special_requirements' => 'nullable|string|max:1000',
            ]);
            
            // First validate basic fields
            $basicValidator = Validator::make($request->all(), $baseRules);

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
            try {
                list($user, $accountCreated) = $this->handleUserForBooking($request);
            } catch (\Exception $e) {
                if ($e->getMessage() === 'password_mismatch') {
                    return response()->json([
                        'error' => 'An account with this email already exists. Please use the correct password or use a different email address.',
                        'errors' => [
                            'customer_email' => ['An account with this email already exists.'],
                            'password' => ['Please enter your existing account password.']
                        ]
                    ], 422);
                }
                Log::error('Error handling user for airport transfer booking: ' . $e->getMessage());
                return response()->json(['error' => 'Unable to process account. Please try again.'], 500);
            }

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

            // Get route description based on transfer type
            $routeDescription = '';
            if ($request->transfer_type === 'pickup') {
                $airport = Airport::find($request->pickup_airport_id);
                $city = City::find($request->dropoff_city_id);
                $routeDescription = ($airport ? $airport->name : 'Airport') . ' → ' . ($city ? $city->name : 'City');
            } else {
                $city = City::find($request->pickup_city_id);
                $airport = Airport::find($request->dropoff_airport_id);
                $routeDescription = ($city ? $city->name : 'City') . ' → ' . ($airport ? $airport->name : 'Airport');
            }
            
            // Format travel date and time
            $travelDate = \Carbon\Carbon::parse($request->travel_date)->format('l, F j, Y');
            
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
                    'route' => $routeDescription,
                    'travel_date' => $travelDate,
                    'travel_time' => $request->travel_time,
                    'travel_info' => $travelDate . ' at ' . $request->travel_time,
                    'vehicle_type' => $request->vehicle_type_id,
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

    /**
     * Get pricing for car hire with specific vehicle type and duration
     */
    public function getCarHirePricing(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'vehicle_type_id' => 'required|exists:vehicle_types,id',
                'hire_days' => 'required|integer|min:1|max:365',
                'pickup_city_id' => 'nullable|exists:cities,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Get car hire service
            $carHireService = TransportationService::where('service_type', 'car_hire')
                ->where('is_active', true)
                ->first();

            if (!$carHireService) {
                return response()->json(['error' => 'Car hire service not available'], 404);
            }

            // Try to find city-specific pricing first if pickup city is provided
            $pricing = null;
            if ($request->pickup_city_id) {
                $pricing = ServicePricing::where('transportation_service_id', $carHireService->id)
                    ->where('vehicle_type_id', $request->vehicle_type_id)
                    ->where('pickup_city_id', $request->pickup_city_id)
                    ->where('is_active', true)
                    ->first();
            }

            // If no city-specific pricing found, get general pricing (where pickup_city_id is null)
            if (!$pricing) {
                $pricing = ServicePricing::where('transportation_service_id', $carHireService->id)
                    ->where('vehicle_type_id', $request->vehicle_type_id)
                    ->whereNull('pickup_city_id')
                    ->where('is_active', true)
                    ->first();
            }

            if (!$pricing) {
                return response()->json(['error' => 'No pricing available for this vehicle type'], 404);
            }

            // Determine the daily rate - prioritize price_per_day, fallback to base_price
            $pricePerDay = null;
            if ($pricing->price_per_day && $pricing->price_per_day > 0) {
                $pricePerDay = $pricing->price_per_day;
            } elseif ($pricing->base_price && $pricing->base_price > 0) {
                $pricePerDay = $pricing->base_price;
            }
            
            if (!$pricePerDay || $pricePerDay <= 0) {
                return response()->json([
                    'error' => 'Invalid pricing configuration - both base_price and price_per_day are missing or zero'
                ], 404);
            }
            
            // Calculate total price (simple: daily_rate * number_of_days)
            $hireDays = $request->hire_days;
            $totalPrice = $pricePerDay * $hireDays;

            // Log for debugging
            Log::info('Car hire pricing calculation:', [
                'vehicle_type_id' => $request->vehicle_type_id,
                'pickup_city_id' => $request->pickup_city_id,
                'hire_days' => $hireDays,
                'base_price' => $pricing->base_price,
                'price_per_day_field' => $pricing->price_per_day,
                'calculated_daily_rate' => $pricePerDay,
                'total_price' => $totalPrice,
                'pricing_id' => $pricing->id
            ]);

            return response()->json([
                'success' => true,
                'price_per_day' => $pricePerDay,
                'hire_days' => $hireDays,
                'total_price' => $totalPrice,
                'service_id' => $carHireService->id,
                'pricing_id' => $pricing->id,
                'vehicle_type_id' => $request->vehicle_type_id,
                'pricing_details' => [
                    'base_price' => $pricing->base_price ?? 0,
                    'price_per_day_field' => $pricing->price_per_day ?? 0,
                    'used_daily_rate' => $pricePerDay,
                    'rate_source' => ($pricing->price_per_day && $pricing->price_per_day > 0) ? 'price_per_day' : 'base_price',
                    'city_specific' => $pricing->pickup_city_id ? true : false
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching car hire pricing: ' . $e->getMessage());
            Log::error('Request data: ' . json_encode($request->all()));
            return response()->json(['error' => 'Unable to fetch pricing'], 500);
        }
    }

    /**
     * Get all active parcel types for dropdown
     */
    public function getParcelTypes()
    {
        try {
            $parcelTypes = \App\Models\ParcelType::active()
                ->orderBy('max_weight_kg')
                ->select('id', 'name', 'description', 'max_weight_kg', 'base_rate')
                ->get();

            return response()->json($parcelTypes);
        } catch (\Exception $e) {
            Log::error('Error fetching parcel types: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch parcel types'], 500);
        }
    }

    /**
     * Get pricing for parcel delivery between two cities with specific parcel type
     * ONLY uses admin-configured pricing rules - no fallbacks
     */
    public function getParcelDeliveryPricing(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'pickup_city_id' => 'required|exists:cities,id',
                'dropoff_city_id' => 'required|exists:cities,id|different:pickup_city_id',
                'parcel_type_id' => 'required|exists:parcel_types,id',
                'weight' => 'required|numeric|min:0.1',
                'urgent_delivery' => 'boolean',
                'insurance_required' => 'boolean',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Get parcel delivery service
            $parcelDeliveryService = TransportationService::where('service_type', 'parcel_delivery')
                ->where('is_active', true)
                ->first();

            if (!$parcelDeliveryService) {
                return response()->json(['error' => 'Parcel delivery service not available'], 404);
            }

            // Get parcel type to validate weight
            $parcelType = \App\Models\ParcelType::find($request->parcel_type_id);
            if (!$parcelType) {
                return response()->json(['error' => 'Invalid parcel type'], 404);
            }

            // Validate weight against parcel type limits
            if ($request->weight > $parcelType->max_weight_kg) {
                return response()->json([
                    'error' => "Weight {$request->weight}kg exceeds maximum {$parcelType->max_weight_kg}kg for {$parcelType->name}"
                ], 422);
            }

            // Get cities for response
            $pickupCity = City::find($request->pickup_city_id);
            $dropoffCity = City::find($request->dropoff_city_id);

            // ONLY use admin-configured pricing - no fallbacks
            $pricing = ServicePricing::where('transportation_service_id', $parcelDeliveryService->id)
                ->where('pickup_city_id', $request->pickup_city_id)
                ->where('dropoff_city_id', $request->dropoff_city_id)
                ->where('parcel_type', $this->mapParcelTypeToString($parcelType->name))
                ->where('is_active', true)
                ->first();

            if (!$pricing) {
                // Try reverse route
                $pricing = ServicePricing::where('transportation_service_id', $parcelDeliveryService->id)
                    ->where('pickup_city_id', $request->dropoff_city_id)
                    ->where('dropoff_city_id', $request->pickup_city_id)
                    ->where('parcel_type', $this->mapParcelTypeToString($parcelType->name))
                    ->where('is_active', true)
                    ->first();
            }

            if (!$pricing) {
                // No pricing configuration found - admin must configure
                return response()->json([
                    'error' => 'No pricing configuration found for this route and parcel type. Please configure pricing in the admin panel.',
                    'admin_config_needed' => true,
                    'route' => ($pickupCity ? $pickupCity->name : 'Unknown') . ' to ' . ($dropoffCity ? $dropoffCity->name : 'Unknown'),
                    'parcel_type' => $parcelType->name,
                    'admin_url' => '/admin/transportation/pricing'
                ], 404);
            }

            // Use admin-configured pricing
            $basePrice = $pricing->base_price;

            // Calculate weight-based surcharge (if weight exceeds 1kg)
            $weightSurcharge = 0;
            if ($request->weight > 1.0) {
                $weightSurcharge = ($request->weight - 1.0) * 100; // KSh 100 per additional kg
            }

            // Calculate total base price
            $totalBasePrice = $basePrice + $weightSurcharge;

            // Calculate additional fees
            $urgentSurcharge = 0;
            if ($request->urgent_delivery) {
                $urgentSurcharge = $totalBasePrice * 0.5; // 50% surcharge for urgent delivery
            }

            $insuranceFee = 0;
            if ($request->insurance_required) {
                $insuranceFee = $totalBasePrice * 0.02; // 2% insurance fee
            }

            $totalPrice = $totalBasePrice + $urgentSurcharge + $insuranceFee;

            return response()->json([
                'success' => true,
                'base_price' => $totalBasePrice,
                'urgent_surcharge' => $urgentSurcharge,
                'insurance_fee' => $insuranceFee,
                'total_price' => $totalPrice,
                'parcel_type' => $parcelType->name,
                'max_weight' => $parcelType->max_weight_kg,
                'service_id' => $parcelDeliveryService->id,
                'pricing_id' => $pricing->id,
                'breakdown' => [
                    'base_rate' => $basePrice,
                    'distance_surcharge' => 0, // All distance costs included in base_price
                    'weight_surcharge' => $weightSurcharge,
                    'urgent_delivery' => $urgentSurcharge,
                    'insurance' => $insuranceFee
                ],
                'route_info' => [
                    'pickup_city' => $pickupCity ? $pickupCity->name : 'Unknown',
                    'dropoff_city' => $dropoffCity ? $dropoffCity->name : 'Unknown',
                    'has_specific_pricing' => true
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching parcel delivery pricing: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch pricing'], 500);
        }
    }

    /**
     * Book a parcel delivery
     */
    public function bookParcelDelivery(Request $request)
    {
        try {
            // Use base validation rules with parcel delivery specific rules
            $additionalRules = [
                'pickup_city_id' => 'required|exists:cities,id',
                'dropoff_city_id' => 'required|exists:cities,id|different:pickup_city_id',
                'parcel_type_id' => 'required|exists:parcel_types,id',
                'parcel_weight' => 'required|numeric|min:0.1|max:100',
                'pickup_date' => 'required|date|after_or_equal:today',
                'pickup_time' => 'required|date_format:H:i',
                'parcel_description' => 'required|string|max:1000',
                'sender_address' => 'required|string|max:500',
                'recipient_name' => 'required|string|max:255',
                'recipient_phone' => 'required|string|max:20',
                'recipient_address' => 'required|string|max:500',
                'urgent_delivery' => 'boolean',
                'signature_required' => 'boolean',
                'insurance_required' => 'boolean',
                'special_instructions' => 'nullable|string|max:1000',
            ];

            $validator = Validator::make($request->all(), $this->getBookingValidationRules($additionalRules));

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Validate parcel weight against parcel type
            $parcelType = \App\Models\ParcelType::find($request->parcel_type_id);
            if (!$parcelType) {
                return response()->json(['error' => 'Invalid parcel type'], 404);
            }

            if ($request->parcel_weight > $parcelType->max_weight_kg) {
                return response()->json([
                    'error' => "Weight {$request->parcel_weight}kg exceeds maximum {$parcelType->max_weight_kg}kg for {$parcelType->name}",
                    'errors' => [
                        'parcel_weight' => ["Weight cannot exceed {$parcelType->max_weight_kg}kg for {$parcelType->name}"]
                    ]
                ], 422);
            }

            // Handle user registration/authentication
            try {
                list($user, $accountCreated) = $this->handleUserForBooking($request);
            } catch (\Exception $e) {
                if ($e->getMessage() === 'password_mismatch') {
                    return response()->json([
                        'error' => 'An account with this email already exists. Please use the correct password or use a different email address.',
                        'errors' => [
                            'customer_email' => ['An account with this email already exists.'],
                            'password' => ['Please enter your existing account password.']
                        ]
                    ], 422);
                }
                Log::error('Error handling user for parcel delivery booking: ' . $e->getMessage());
                return response()->json(['error' => 'Unable to process account. Please try again.'], 500);
            }

            // Get parcel delivery service
            $parcelDeliveryService = TransportationService::where('service_type', 'parcel_delivery')
                ->where('is_active', true)
                ->first();

            if (!$parcelDeliveryService) {
                return response()->json(['error' => 'Parcel delivery service not available'], 404);
            }

            // Get pricing
            $pricing = ServicePricing::where('transportation_service_id', $parcelDeliveryService->id)
                ->where('pickup_city_id', $request->pickup_city_id)
                ->where('dropoff_city_id', $request->dropoff_city_id)
                ->where('parcel_type', $this->mapParcelTypeToString($parcelType->name))
                ->where('is_active', true)
                ->first();

            if (!$pricing) {
                // Try reverse route
                $pricing = ServicePricing::where('transportation_service_id', $parcelDeliveryService->id)
                    ->where('pickup_city_id', $request->dropoff_city_id)
                    ->where('dropoff_city_id', $request->pickup_city_id)
                    ->where('parcel_type', $this->mapParcelTypeToString($parcelType->name))
                    ->where('is_active', true)
                    ->first();
            }

            // Require admin-configured pricing - no fallbacks
            if (!$pricing) {
                $pickupCity = City::find($request->pickup_city_id);
                $dropoffCity = City::find($request->dropoff_city_id);
                
                return response()->json([
                    'error' => 'No pricing configuration found for this route and parcel type. Please contact support or try a different route.',
                    'admin_config_needed' => true,
                    'route' => ($pickupCity ? $pickupCity->name : 'Unknown') . ' to ' . ($dropoffCity ? $dropoffCity->name : 'Unknown'),
                    'parcel_type' => $parcelType->name
                ], 404);
            }
            
            $basePrice = $pricing->base_price;
            $distanceSurcharge = 0;

            // Calculate weight-based surcharge
            $weightSurcharge = 0;
            if ($request->parcel_weight > 1.0) {
                $weightSurcharge = ($request->parcel_weight - 1.0) * 100; // KSh 100 per additional kg
            }

            $totalBasePrice = $basePrice + $distanceSurcharge + $weightSurcharge;

            // Calculate additional fees
            $urgentSurcharge = 0;
            if ($request->urgent_delivery) {
                $urgentSurcharge = $totalBasePrice * 0.5;
            }

            $insuranceFee = 0;
            if ($request->insurance_required) {
                $insuranceFee = $totalBasePrice * 0.02;
            }

            $totalPrice = $totalBasePrice + $urgentSurcharge + $insuranceFee;

            // Prepare special requirements
            $specialRequirements = collect([
                "Parcel Description: {$request->parcel_description}",
                "Parcel Weight: {$request->parcel_weight}kg",
                "Parcel Type: {$parcelType->name}",
                "Sender Address: {$request->sender_address}",
                "Recipient: {$request->recipient_name}",
                "Recipient Phone: {$request->recipient_phone}",
                "Recipient Address: {$request->recipient_address}",
            ]);

            if ($request->urgent_delivery) {
                $specialRequirements->push('URGENT DELIVERY REQUESTED');
            }
            if ($request->signature_required) {
                $specialRequirements->push('SIGNATURE REQUIRED');
            }
            if ($request->insurance_required) {
                $specialRequirements->push('INSURANCE COVERAGE REQUESTED');
            }
            if ($request->special_instructions) {
                $specialRequirements->push("Special Instructions: {$request->special_instructions}");
            }

            // Debug: Log the data being saved
            Log::info('Creating parcel delivery booking with data:', [
                'service_id' => $parcelDeliveryService->id,
                'pricing_id' => $pricing ? $pricing->id : null,
                'parcel_type' => $parcelType->name,
                'customer' => $request->customer_name,
                'route' => $request->pickup_city_id . ' to ' . $request->dropoff_city_id,
                'pickup' => $request->pickup_date . ' ' . $request->pickup_time,
                'weight' => $request->parcel_weight,
                'total_price' => $totalPrice
            ]);

            // Create booking record
            try {
                $booking = new Booking();
                $booking->transportation_service_id = $parcelDeliveryService->id;
                $booking->service_pricing_id = $pricing ? $pricing->id : null;
                $booking->user_id = $user->id;
                $booking->customer_name = $request->customer_name;
                $booking->customer_email = $request->customer_email;
                $booking->customer_phone = $request->customer_phone;
                $booking->pickup_city_id = $request->pickup_city_id;
                $booking->dropoff_city_id = $request->dropoff_city_id;
                $booking->travel_date = $request->pickup_date;
                $booking->travel_time = $request->pickup_time;
                $booking->passengers = 1; // Default for parcel delivery
                $booking->price_per_unit = $totalBasePrice;
                $booking->total_price = $totalPrice;
                $booking->surcharge_amount = $urgentSurcharge + $insuranceFee;
                $booking->special_requirements = $specialRequirements->join("\n");
                $booking->status = Booking::STATUS_PENDING;
                $booking->payment_status = Booking::PAYMENT_STATUS_PENDING;
                $booking->save();
                
                Log::info('Parcel delivery booking created successfully', [
                    'booking_id' => $booking->id,
                    'booking_reference' => $booking->booking_reference,
                    'user_id' => $user->id,
                    'account_created' => $accountCreated
                ]);
            } catch (\Exception $e) {
                Log::error('Error creating parcel delivery booking: ' . $e->getMessage());
                Log::error('Stack trace: ' . $e->getTraceAsString());
                throw $e;
            }

            return response()->json([
                'success' => true,
                'booking_reference' => $booking->booking_reference,
                'account_created' => $accountCreated,
                'user_id' => $user->id,
                'message' => $accountCreated 
                    ? 'Parcel delivery booking successful! Your SafariConnect account has been created. We will contact you shortly with pickup confirmation and tracking details.'
                    : 'Parcel delivery booking successful! We will contact you shortly with pickup confirmation and tracking details.',
                'booking_details' => [
                    'service' => 'Parcel Delivery',
                    'parcel_type' => $parcelType->name,
                    'weight' => $request->parcel_weight . 'kg',
                    'route' => ($pricing ? $pricing->route_description : 'Custom Route'),
                    'pickup_date' => $request->pickup_date,
                    'pickup_time' => $request->pickup_time,
                    'base_price' => $totalBasePrice,
                    'urgent_surcharge' => $urgentSurcharge,
                    'insurance_fee' => $insuranceFee,
                    'total_price' => $totalPrice,
                    'customer_name' => $request->customer_name,
                    'customer_email' => $request->customer_email,
                    'customer_phone' => $request->customer_phone,
                    'sender_address' => $request->sender_address,
                    'recipient_name' => $request->recipient_name,
                    'recipient_phone' => $request->recipient_phone,
                    'recipient_address' => $request->recipient_address,
                    'parcel_description' => $request->parcel_description,
                ],
                'account_info' => [
                    'account_created' => $accountCreated,
                    'login_email' => $user->email,
                    'user_authenticated' => true
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error booking parcel delivery: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to process parcel delivery booking. Please try again.'], 500);
        }
    }

    /**
     * Map parcel type name to parcel_type string used in ServicePricing
     */
    private function mapParcelTypeToString($parcelTypeName)
    {
        $mapping = [
            'Documents' => 'documents',
            'Small Package' => 'small',
            'Medium Package' => 'medium',
            'Large Package' => 'large',
            'Extra Large' => 'extra_large',
        ];

        return $mapping[$parcelTypeName] ?? strtolower(str_replace(' ', '_', $parcelTypeName));
    }

    /**
     * Book a car hire
     */
    public function bookCarHire(Request $request)
    {
        try {
            // Use base validation rules with car hire specific rules
            $additionalRules = [
                'vehicle_type_id' => 'required|exists:vehicle_types,id',
                'pickup_city_id' => 'required|exists:cities,id',
                'hire_start_date' => 'required|date|after_or_equal:today',
                'hire_end_date' => 'required|date|after:hire_start_date',
                'pickup_time' => 'required|date_format:H:i',
                'drivers_license_number' => 'required|string|max:50',
                'special_requirements' => 'nullable|string|max:1000',
            ];

            $validator = Validator::make($request->all(), $this->getBookingValidationRules($additionalRules));

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Handle user registration/authentication
            try {
                list($user, $accountCreated) = $this->handleUserForBooking($request);
            } catch (\Exception $e) {
                if ($e->getMessage() === 'password_mismatch') {
                    return response()->json([
                        'error' => 'An account with this email already exists. Please use the correct password or use a different email address.',
                        'errors' => [
                            'customer_email' => ['An account with this email already exists.'],
                            'password' => ['Please enter your existing account password.']
                        ]
                    ], 422);
                }
                Log::error('Error handling user for car hire booking: ' . $e->getMessage());
                return response()->json(['error' => 'Unable to process account. Please try again.'], 500);
            }

            // Get car hire service
            $carHireService = TransportationService::where('service_type', 'car_hire')
                ->where('is_active', true)
                ->first();

            if (!$carHireService) {
                return response()->json(['error' => 'Car hire service not available'], 404);
            }

            // Get pricing
            $pricingQuery = ServicePricing::where('transportation_service_id', $carHireService->id)
                ->where('vehicle_type_id', $request->vehicle_type_id)
                ->where('is_active', true);

            // Try city-specific pricing first
            $pricing = $pricingQuery->where('pickup_city_id', $request->pickup_city_id)->first();

            // If no city-specific pricing, get general pricing
            if (!$pricing) {
                $pricing = ServicePricing::where('transportation_service_id', $carHireService->id)
                    ->where('vehicle_type_id', $request->vehicle_type_id)
                    ->whereNull('pickup_city_id')
                    ->where('is_active', true)
                    ->first();
            }

            if (!$pricing) {
                return response()->json(['error' => 'No pricing available for this vehicle type and location'], 404);
            }

            // Calculate hire duration and total price
            $hireStartDate = \Carbon\Carbon::parse($request->hire_start_date);
            $hireEndDate = \Carbon\Carbon::parse($request->hire_end_date);
            $hireDays = $hireStartDate->diffInDays($hireEndDate) + 1; // Include both start and end days
            
            // Determine the daily rate - prioritize price_per_day, fallback to base_price
            $pricePerDay = null;
            if ($pricing->price_per_day && $pricing->price_per_day > 0) {
                $pricePerDay = $pricing->price_per_day;
            } elseif ($pricing->base_price && $pricing->base_price > 0) {
                $pricePerDay = $pricing->base_price;
            }
            
            if (!$pricePerDay || $pricePerDay <= 0) {
                return response()->json([
                    'error' => 'Invalid pricing configuration - both base_price and price_per_day are missing or zero for this vehicle type and location'
                ], 404);
            }
            
            $totalPrice = $pricePerDay * $hireDays;

            // Debug: Log the data being saved
            Log::info('Creating car hire booking with data:', [
                'service_id' => $carHireService->id,
                'pricing_id' => $pricing->id,
                'vehicle_type_id' => $request->vehicle_type_id,
                'customer' => $request->customer_name,
                'pickup_city' => $request->pickup_city_id,
                'hire_period' => $request->hire_start_date . ' to ' . $request->hire_end_date,
                'hire_days' => $hireDays,
                'price_per_day' => $pricePerDay,
                'total_price' => $totalPrice
            ]);

            // Create booking record
            try {
                $booking = new Booking();
                $booking->transportation_service_id = $carHireService->id;
                $booking->service_pricing_id = $pricing->id;
                $booking->user_id = $user->id;
                $booking->customer_name = $request->customer_name;
                $booking->customer_email = $request->customer_email;
                $booking->customer_phone = $request->customer_phone;
                $booking->pickup_city_id = $request->pickup_city_id;
                $booking->dropoff_city_id = $request->pickup_city_id; // Same as pickup for car hire
                $booking->vehicle_type_id = $request->vehicle_type_id;
                $booking->travel_date = $request->hire_start_date;
                $booking->travel_time = $request->pickup_time;
                $booking->passengers = 1; // Default for car hire
                $booking->price_per_unit = $pricePerDay;
                $booking->total_price = $totalPrice;
                $booking->special_requirements = $request->special_requirements . 
                    "\n\nCar Hire Details:\n" .
                    "- Hire Duration: {$hireDays} days\n" .
                    "- Start Date: {$request->hire_start_date}\n" .
                    "- End Date: {$request->hire_end_date}\n" .
                    "- Driver's License: {$request->drivers_license_number}";
                $booking->status = Booking::STATUS_PENDING;
                $booking->payment_status = Booking::PAYMENT_STATUS_PENDING;
                $booking->save();
                
                Log::info('Car hire booking created successfully', [
                    'booking_id' => $booking->id,
                    'booking_reference' => $booking->booking_reference,
                    'user_id' => $user->id,
                    'account_created' => $accountCreated
                ]);
            } catch (\Exception $e) {
                Log::error('Error creating car hire booking: ' . $e->getMessage());
                Log::error('Stack trace: ' . $e->getTraceAsString());
                throw $e;
            }

            return response()->json([
                'success' => true,
                'booking_reference' => $booking->booking_reference,
                'account_created' => $accountCreated,
                'user_id' => $user->id,
                'message' => $accountCreated 
                    ? 'Car hire booking successful! Your SafariConnect account has been created. We will contact you shortly with confirmation details and vehicle pickup instructions.'
                    : 'Car hire booking successful! We will contact you shortly with confirmation details and vehicle pickup instructions.',
                'booking_details' => [
                    'service' => 'Car Hire',
                    'vehicle_type' => $request->vehicle_type_id,
                    'pickup_location' => $request->pickup_city_id,
                    'hire_start_date' => $request->hire_start_date,
                    'hire_end_date' => $request->hire_end_date,
                    'pickup_time' => $request->pickup_time,
                    'hire_days' => $hireDays,
                    'price_per_day' => $pricePerDay,
                    'total_price' => $totalPrice,
                    'customer_name' => $request->customer_name,
                    'customer_email' => $request->customer_email,
                    'customer_phone' => $request->customer_phone,
                    'drivers_license_number' => $request->drivers_license_number,
                    'special_requirements' => $request->special_requirements,
                ],
                'account_info' => [
                    'account_created' => $accountCreated,
                    'login_email' => $user->email,
                    'user_authenticated' => true
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error booking car hire: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to process car hire booking. Please try again.'], 500);
        }
    }
}