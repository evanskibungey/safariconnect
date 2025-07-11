<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\Auth\RegisterController as AdminRegisterController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController as AdminPasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\NewPasswordController as AdminNewPasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController as AdminEmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController as AdminVerifyEmailController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController as AdminEmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController as AdminConfirmablePasswordController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

// Transportation Services Controllers
use App\Http\Controllers\Admin\TransportationServiceController;
use App\Http\Controllers\Admin\ServicePricingController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\VehicleTypeController;
use App\Http\Controllers\Admin\ParcelTypeController;
use App\Http\Controllers\Admin\AirportController;

use Illuminate\Support\Facades\Route;

// Customer Routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Customer Booking Management Routes
    Route::get('/booking/{booking}', [App\Http\Controllers\CustomerBookingController::class, 'show'])->name('booking.details');
    Route::get('/bookings/history', [App\Http\Controllers\CustomerBookingController::class, 'history'])->name('booking.history');
    Route::post('/booking/{booking}/cancel', [App\Http\Controllers\CustomerBookingController::class, 'cancel'])->name('booking.cancel');
});

// Public API Routes for Booking
Route::prefix('api')->group(function () {
    Route::get('/cities', [App\Http\Controllers\BookingController::class, 'getCities'])->name('api.cities');
    Route::get('/vehicle-types', [App\Http\Controllers\BookingController::class, 'getVehicleTypes'])->name('api.vehicle-types');
    
    // Shared Ride Routes
    Route::get('/shared-ride/pricing', [App\Http\Controllers\BookingController::class, 'getSharedRidePricing'])->name('api.shared-ride.pricing');
    Route::post('/shared-ride/book', [App\Http\Controllers\BookingController::class, 'bookSharedRide'])->name('api.shared-ride.book');
    
    // Solo Ride Routes
    Route::get('/solo-ride/pricing', [App\Http\Controllers\BookingController::class, 'getSoloRidePricing'])->name('api.solo-ride.pricing');
    Route::post('/solo-ride/book', [App\Http\Controllers\BookingController::class, 'bookSoloRide'])->name('api.solo-ride.book');
    
    // Airport Transfer Routes
    Route::get('/airports', [App\Http\Controllers\BookingController::class, 'getAirports'])->name('api.airports');
    Route::get('/airports-by-city', [App\Http\Controllers\BookingController::class, 'getAirportsByCity'])->name('api.airports-by-city');
    Route::get('/airport-transfer/pricing', [App\Http\Controllers\BookingController::class, 'getAirportTransferPricing'])->name('api.airport-transfer.pricing');
    Route::post('/airport-transfer/book', [App\Http\Controllers\BookingController::class, 'bookAirportTransfer'])->name('api.airport-transfer.book');
    
    // Car Hire Routes
    Route::get('/car-hire/pricing', [App\Http\Controllers\BookingController::class, 'getCarHirePricing'])->name('api.car-hire.pricing');
    Route::post('/car-hire/book', [App\Http\Controllers\BookingController::class, 'bookCarHire'])->name('api.car-hire.book');
    
    // Parcel Delivery Routes
    Route::get('/parcel-types', [App\Http\Controllers\BookingController::class, 'getParcelTypes'])->name('api.parcel-types');
    Route::get('/parcel-delivery/pricing', [App\Http\Controllers\BookingController::class, 'getParcelDeliveryPricing'])->name('api.parcel-delivery.pricing');
    Route::post('/parcel-delivery/book', [App\Http\Controllers\BookingController::class, 'bookParcelDelivery'])->name('api.parcel-delivery.book');
    
    // Test Routes (for development only - remove in production)
    Route::get('/test/solo-ride-data', [App\Http\Controllers\TestController::class, 'testSoloRideData'])->name('api.test.solo-ride-data');
    Route::get('/test/solo-ride-pricing', [App\Http\Controllers\TestController::class, 'testSoloRidePricing'])->name('api.test.solo-ride-pricing');
    Route::get('/test/booking-success', [App\Http\Controllers\TestController::class, 'testBookingSuccess'])->name('api.test.booking-success');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Admin Guest Routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'create'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'store']);
        
        Route::get('/register', [AdminRegisterController::class, 'create'])->name('register');
        Route::post('/register', [AdminRegisterController::class, 'store']);
        
        Route::get('/forgot-password', [AdminPasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('/forgot-password', [AdminPasswordResetLinkController::class, 'store'])->name('password.email');
        Route::get('/reset-password/{token}', [AdminNewPasswordController::class, 'create'])->name('password.reset');
        Route::post('/reset-password', [AdminNewPasswordController::class, 'store'])->name('password.store');
    });

    // Admin Authenticated Routes  
    Route::middleware('admin.auth')->group(function () {
        // Main Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminLoginController::class, 'destroy'])->name('logout');
        
        // Email Verification Routes
        Route::get('/verify-email', [AdminEmailVerificationPromptController::class, 'index'])->name('verification.notice');
        Route::get('/verify-email/{id}/{hash}', [AdminVerifyEmailController::class, 'verify'])
            ->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
        Route::post('/email/verification-notification', [AdminEmailVerificationNotificationController::class, 'store'])
            ->middleware('throttle:6,1')->name('verification.send');
            
        // Password Confirmation
        Route::get('/confirm-password', [AdminConfirmablePasswordController::class, 'show'])->name('password.confirm');
        Route::post('/confirm-password', [AdminConfirmablePasswordController::class, 'store']);
        
        // ===================================
        // Transportation Services Management
        // ===================================
        Route::prefix('transportation')->name('transportation.')->group(function () {
            
            // Transportation Services CRUD
            Route::resource('services', TransportationServiceController::class);
            Route::patch('services/{service}/toggle', [TransportationServiceController::class, 'toggle'])
                ->name('services.toggle');
            
            // Service Pricing CRUD
            Route::resource('pricing', ServicePricingController::class);
            Route::patch('pricing/{pricing}/toggle', [ServicePricingController::class, 'toggle'])
                ->name('pricing.toggle');
            Route::post('pricing/{pricing}/duplicate', [ServicePricingController::class, 'duplicate'])
                ->name('pricing.duplicate');
            
            // Cities Management CRUD
            Route::resource('cities', CityController::class);
            Route::patch('cities/{city}/toggle', [CityController::class, 'toggle'])
                ->name('cities.toggle');
            
            // Vehicle Types Management CRUD
            Route::resource('vehicle-types', VehicleTypeController::class);
            Route::patch('vehicle-types/{vehicleType}/toggle', [VehicleTypeController::class, 'toggle'])
                ->name('vehicle-types.toggle');
            
            // Parcel Types Management CRUD
            Route::resource('parcel-types', ParcelTypeController::class);
            Route::patch('parcel-types/{parcelType}/toggle', [ParcelTypeController::class, 'toggle'])
                ->name('parcel-types.toggle');
            
            // Airports Management CRUD
            Route::resource('airports', AirportController::class);
            Route::patch('airports/{airport}/toggle', [AirportController::class, 'toggle'])
                ->name('airports.toggle');
            Route::get('api/airports-by-city', [AirportController::class, 'getByCity'])
                ->name('api.airports-by-city');
            
            // Additional API endpoints for pricing
            Route::get('api/airports-by-city-pricing', [ServicePricingController::class, 'getAirportsByCity'])
                ->name('api.airports-by-city-pricing');
            
            // Temporary debugging route
            Route::any('debug/pricing-form', [App\Http\Controllers\Admin\DebugController::class, 'debugPricingForm'])
                ->name('debug.pricing-form');
        });
        
        // ===================================
        // Booking Management
        // ===================================
        Route::prefix('bookings')->name('bookings.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\BookingController::class, 'index'])->name('index');
            Route::get('/{booking}', [App\Http\Controllers\Admin\BookingController::class, 'show'])->name('show');
            Route::patch('/{booking}', [App\Http\Controllers\Admin\BookingController::class, 'update'])->name('update');
            Route::delete('/{booking}', [App\Http\Controllers\Admin\BookingController::class, 'destroy'])->name('destroy');
            
            // Quick actions
            Route::post('/{booking}/confirm', [App\Http\Controllers\Admin\BookingController::class, 'confirm'])->name('confirm');
            Route::post('/{booking}/cancel', [App\Http\Controllers\Admin\BookingController::class, 'cancel'])->name('cancel');
            
            // Driver assignment
            Route::post('/{booking}/assign-driver', [App\Http\Controllers\Admin\BookingController::class, 'assignDriver'])->name('assign-driver');
            Route::post('/{booking}/remove-driver', [App\Http\Controllers\Admin\BookingController::class, 'removeDriver'])->name('remove-driver');
        });
        
        // ===================================
        // Driver Management
        // ===================================
        Route::prefix('drivers')->name('drivers.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\DriverController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Admin\DriverController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Admin\DriverController::class, 'store'])->name('store');
            Route::get('/{driver}', [App\Http\Controllers\Admin\DriverController::class, 'show'])->name('show');
            Route::get('/{driver}/edit', [App\Http\Controllers\Admin\DriverController::class, 'edit'])->name('edit');
            Route::put('/{driver}', [App\Http\Controllers\Admin\DriverController::class, 'update'])->name('update');
            Route::delete('/{driver}', [App\Http\Controllers\Admin\DriverController::class, 'destroy'])->name('destroy');
            Route::patch('/{driver}/toggle', [App\Http\Controllers\Admin\DriverController::class, 'toggle'])->name('toggle');
            Route::patch('/{driver}/status', [App\Http\Controllers\Admin\DriverController::class, 'updateStatus'])->name('update-status');
            Route::get('/{driver}/download-document', [App\Http\Controllers\Admin\DriverController::class, 'downloadDocument'])->name('download-document');
        });
    });
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Transportation Services Route Summary
|--------------------------------------------------------------------------
| 
| The following routes are now available for transportation services:
|
| Transportation Services:
| GET     /admin/transportation/services                           admin.transportation.services.index
| GET     /admin/transportation/services/create                    admin.transportation.services.create
| POST    /admin/transportation/services                           admin.transportation.services.store
| GET     /admin/transportation/services/{service}                 admin.transportation.services.show
| GET     /admin/transportation/services/{service}/edit            admin.transportation.services.edit
| PUT     /admin/transportation/services/{service}                 admin.transportation.services.update
| DELETE  /admin/transportation/services/{service}                 admin.transportation.services.destroy
| PATCH   /admin/transportation/services/{service}/toggle          admin.transportation.services.toggle
|
| Service Pricing:
| GET     /admin/transportation/pricing                            admin.transportation.pricing.index
| GET     /admin/transportation/pricing/create                     admin.transportation.pricing.create
| POST    /admin/transportation/pricing                            admin.transportation.pricing.store
| GET     /admin/transportation/pricing/{pricing}                  admin.transportation.pricing.show
| GET     /admin/transportation/pricing/{pricing}/edit             admin.transportation.pricing.edit
| PUT     /admin/transportation/pricing/{pricing}                  admin.transportation.pricing.update
| DELETE  /admin/transportation/pricing/{pricing}                  admin.transportation.pricing.destroy
| PATCH   /admin/transportation/pricing/{pricing}/toggle           admin.transportation.pricing.toggle
| POST    /admin/transportation/pricing/{pricing}/duplicate        admin.transportation.pricing.duplicate
|
| Cities:
| GET     /admin/transportation/cities                             admin.transportation.cities.index
| GET     /admin/transportation/cities/create                      admin.transportation.cities.create
| POST    /admin/transportation/cities                             admin.transportation.cities.store
| GET     /admin/transportation/cities/{city}                      admin.transportation.cities.show
| GET     /admin/transportation/cities/{city}/edit                 admin.transportation.cities.edit
| PUT     /admin/transportation/cities/{city}                      admin.transportation.cities.update
| DELETE  /admin/transportation/cities/{city}                      admin.transportation.cities.destroy
| PATCH   /admin/transportation/cities/{city}/toggle               admin.transportation.cities.toggle
|
| Vehicle Types:
| GET     /admin/transportation/vehicle-types                      admin.transportation.vehicle-types.index
| GET     /admin/transportation/vehicle-types/create               admin.transportation.vehicle-types.create
| POST    /admin/transportation/vehicle-types                      admin.transportation.vehicle-types.store
| GET     /admin/transportation/vehicle-types/{vehicleType}        admin.transportation.vehicle-types.show
| GET     /admin/transportation/vehicle-types/{vehicleType}/edit   admin.transportation.vehicle-types.edit
| PUT     /admin/transportation/vehicle-types/{vehicleType}        admin.transportation.vehicle-types.update
| DELETE  /admin/transportation/vehicle-types/{vehicleType}        admin.transportation.vehicle-types.destroy
| PATCH   /admin/transportation/vehicle-types/{vehicleType}/toggle admin.transportation.vehicle-types.toggle
|
| Parcel Types:
| GET     /admin/transportation/parcel-types                       admin.transportation.parcel-types.index
| GET     /admin/transportation/parcel-types/create                admin.transportation.parcel-types.create
| POST    /admin/transportation/parcel-types                       admin.transportation.parcel-types.store
| GET     /admin/transportation/parcel-types/{parcelType}          admin.transportation.parcel-types.show
| GET     /admin/transportation/parcel-types/{parcelType}/edit     admin.transportation.parcel-types.edit
| PUT     /admin/transportation/parcel-types/{parcelType}          admin.transportation.parcel-types.update
| DELETE  /admin/transportation/parcel-types/{parcelType}          admin.transportation.parcel-types.destroy
| PATCH   /admin/transportation/parcel-types/{parcelType}/toggle   admin.transportation.parcel-types.toggle
|
*/