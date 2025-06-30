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
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [AdminLoginController::class, 'destroy'])->name('logout');
        
        Route::get('/verify-email', [AdminEmailVerificationPromptController::class, 'index'])->name('verification.notice');
        Route::get('/verify-email/{id}/{hash}', [AdminVerifyEmailController::class, 'verify'])
            ->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
        Route::post('/email/verification-notification', [AdminEmailVerificationNotificationController::class, 'store'])
            ->middleware('throttle:6,1')->name('verification.send');
            
        Route::get('/confirm-password', [AdminConfirmablePasswordController::class, 'show'])->name('password.confirm');
        Route::post('/confirm-password', [AdminConfirmablePasswordController::class, 'store']);
    });
});

require __DIR__.'/auth.php';