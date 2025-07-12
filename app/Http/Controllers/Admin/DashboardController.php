<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Driver;
use App\Models\User;
use App\Models\TransportationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Get date ranges
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
        
        // Overall Statistics
        $totalBookings = Booking::count();
        $totalRevenue = Booking::where('payment_status', 'paid')->sum('total_price');
        $totalUsers = User::count();
        $totalDrivers = Driver::where('is_active', true)->count();
        
        // Today's Statistics
        $todayBookings = Booking::whereDate('created_at', $today)->count();
        $todayRevenue = Booking::whereDate('created_at', $today)
            ->where('payment_status', 'paid')
            ->sum('total_price');
        $todayNewUsers = User::whereDate('created_at', $today)->count();
        
        // This Month's Statistics
        $monthBookings = Booking::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $monthRevenue = Booking::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('payment_status', 'paid')
            ->sum('total_price');
        
        // Last Month's Statistics (for comparison)
        $lastMonthBookings = Booking::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $lastMonthRevenue = Booking::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->where('payment_status', 'paid')
            ->sum('total_price');
        
        // Calculate growth percentages
        $bookingGrowth = $lastMonthBookings > 0 
            ? (($monthBookings - $lastMonthBookings) / $lastMonthBookings) * 100 
            : 0;
        $revenueGrowth = $lastMonthRevenue > 0 
            ? (($monthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 
            : 0;
        
        // Booking Status Distribution
        $bookingsByStatus = Booking::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
        
        // Service Type Distribution
        $bookingsByService = Booking::join('transportation_services', 'bookings.transportation_service_id', '=', 'transportation_services.id')
            ->select('transportation_services.service_type', 'transportation_services.name', DB::raw('count(*) as total'))
            ->groupBy('transportation_services.service_type', 'transportation_services.name')
            ->get();
        
        // Recent Bookings
        $recentBookings = Booking::with(['transportationService', 'pickupCity', 'dropoffCity', 'driver'])
            ->latest()
            ->limit(10)
            ->get();
        
        // Upcoming Bookings (Next 7 days)
        $upcomingBookings = Booking::where('travel_date', '>=', $today)
            ->where('travel_date', '<=', $today->copy()->addDays(7))
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();
        
        // Driver Statistics
        $availableDrivers = Driver::where('status', 'available')->where('is_active', true)->count();
        $busyDrivers = Driver::where('status', 'busy')->where('is_active', true)->count();
        $offlineDrivers = Driver::where('status', 'offline')->where('is_active', true)->count();
        
        // Top Performing Drivers (by trips completed)
        $topDrivers = Driver::withCount(['bookings' => function ($query) {
                $query->where('status', 'completed');
            }])
            ->where('is_active', true)
            ->orderBy('bookings_count', 'desc')
            ->limit(5)
            ->get();
        
        // Revenue by Service Type (This Month)
        $revenueByService = Booking::join('transportation_services', 'bookings.transportation_service_id', '=', 'transportation_services.id')
            ->whereBetween('bookings.created_at', [$startOfMonth, $endOfMonth])
            ->where('bookings.payment_status', 'paid')
            ->select('transportation_services.name', DB::raw('SUM(bookings.total_price) as revenue'))
            ->groupBy('transportation_services.name')
            ->orderBy('revenue', 'desc')
            ->get();
        
        // Daily Revenue Chart (Last 7 days)
        $dailyRevenue = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $revenue = Booking::whereDate('created_at', $date)
                ->where('payment_status', 'paid')
                ->sum('total_price');
            $dailyRevenue[] = [
                'date' => $date->format('M d'),
                'revenue' => $revenue
            ];
        }
        
        // Popular Routes
        $popularRoutes = Booking::select(
                'pickup_city_id',
                'dropoff_city_id',
                DB::raw('count(*) as trip_count')
            )
            ->with(['pickupCity', 'dropoffCity'])
            ->whereNotNull('pickup_city_id')
            ->whereNotNull('dropoff_city_id')
            ->groupBy('pickup_city_id', 'dropoff_city_id')
            ->orderBy('trip_count', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($route) {
                return [
                    'route' => ($route->pickupCity->name ?? 'Unknown') . ' → ' . ($route->dropoffCity->name ?? 'Unknown'),
                    'count' => $route->trip_count
                ];
            });
        
        // Payment Status Distribution
        $paymentStats = Booking::select('payment_status', DB::raw('count(*) as total'))
            ->groupBy('payment_status')
            ->pluck('total', 'payment_status')
            ->toArray();
        
        // Active Services Count
        $activeServices = TransportationService::where('is_active', true)->count();
        
        // User Growth (Last 30 days)
        $userGrowth = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $count = User::whereDate('created_at', '<=', $date)->count();
            $userGrowth[] = [
                'date' => $date->format('M d'),
                'count' => $count
            ];
        }

        return view('admin.dashboard', compact(
            'totalBookings',
            'totalRevenue',
            'totalUsers',
            'totalDrivers',
            'todayBookings',
            'todayRevenue',
            'todayNewUsers',
            'monthBookings',
            'monthRevenue',
            'bookingGrowth',
            'revenueGrowth',
            'bookingsByStatus',
            'bookingsByService',
            'recentBookings',
            'upcomingBookings',
            'availableDrivers',
            'busyDrivers',
            'offlineDrivers',
            'topDrivers',
            'revenueByService',
            'dailyRevenue',
            'popularRoutes',
            'paymentStats',
            'activeServices',
            'userGrowth'
        ));
    }
}
