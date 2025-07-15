<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Get current authenticated user data for booking form pre-fill
     */
    public function getCurrentUser()
    {
        try {
            if (Auth::check()) {
                $user = Auth::user();
                return response()->json([
                    'authenticated' => true,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone ?? '',
                    ]
                ]);
            }

            return response()->json([
                'authenticated' => false,
                'user' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'authenticated' => false,
                'user' => null,
                'error' => 'Unable to fetch user data'
            ], 500);
        }
    }

    /**
     * Get user booking preferences and statistics
     */
    public function getUserBookingData()
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'authenticated' => false,
                    'data' => null
                ]);
            }

            $user = Auth::user();
            $bookings = $user->bookings();

            // Get booking statistics
            $totalBookings = $bookings->count();
            $completedBookings = $bookings->where('status', 'completed')->count();
            $totalSpent = $bookings->sum('total_price');

            // Get most frequent routes (pickup/dropoff cities)
            $frequentRoutes = $bookings
                ->selectRaw('pickup_city_id, dropoff_city_id, COUNT(*) as frequency')
                ->whereNotNull('pickup_city_id')
                ->whereNotNull('dropoff_city_id')
                ->groupBy('pickup_city_id', 'dropoff_city_id')
                ->orderBy('frequency', 'desc')
                ->limit(3)
                ->with(['pickupCity', 'dropoffCity'])
                ->get();

            // Get most used services
            $frequentServices = $bookings
                ->selectRaw('transportation_service_id, COUNT(*) as frequency')
                ->groupBy('transportation_service_id')
                ->orderBy('frequency', 'desc')
                ->with('transportationService')
                ->get();

            return response()->json([
                'authenticated' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone ?? '',
                ],
                'statistics' => [
                    'total_bookings' => $totalBookings,
                    'completed_bookings' => $completedBookings,
                    'total_spent' => $totalSpent,
                    'success_rate' => $totalBookings > 0 ? round(($completedBookings / $totalBookings) * 100, 1) : 0,
                ],
                'preferences' => [
                    'frequent_routes' => $frequentRoutes,
                    'frequent_services' => $frequentServices,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'authenticated' => false,
                'data' => null,
                'error' => 'Unable to fetch user booking data'
            ], 500);
        }
    }
}
