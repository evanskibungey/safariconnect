<?php
/**
 * Admin Login Diagnostic Script
 * Use this to troubleshoot login issues
 * 
 * Usage: php admin_login_diagnostic.php
 */

// Load Laravel
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

echo "🔍 ADMIN LOGIN DIAGNOSTIC TOOL\n";
echo "===============================\n\n";

try {
    // Test 1: Check if admin exists
    echo "📋 Test 1: Checking admin account...\n";
    
    if (Admin::adminExists()) {
        $admin = Admin::getSingleAdmin();
        echo "✅ Admin account found\n";
        echo "   Email: {$admin->email}\n";
        echo "   Name: {$admin->name}\n";
        echo "   Created: {$admin->created_at}\n";
        echo "   Email Verified: " . ($admin->email_verified_at ? 'Yes' : 'No') . "\n";
    } else {
        echo "❌ No admin account found!\n";
        echo "💡 Create admin: php artisan admin:manage create\n";
        echo "💡 Or use: php manage_admin.php create\n";
        exit(1);
    }

    echo "\n";

    // Test 2: Check password
    echo "📋 Test 2: Testing password...\n";
    echo "Enter the password you're trying to use: ";
    $testPassword = trim(fgets(STDIN));

    $admin = Admin::getSingleAdmin();
    if (Hash::check($testPassword, $admin->password)) {
        echo "✅ Password is CORRECT\n";
    } else {
        echo "❌ Password is INCORRECT\n";
        echo "💡 Reset password: php artisan admin:manage reset\n";
        echo "💡 Or use: php manage_admin.php reset\n";
    }

    echo "\n";

    // Test 3: Check auth configuration
    echo "📋 Test 3: Checking auth configuration...\n";
    
    $authConfig = config('auth');
    if (isset($authConfig['guards']['admin'])) {
        echo "✅ Admin guard configured\n";
        echo "   Driver: {$authConfig['guards']['admin']['driver']}\n";
        echo "   Provider: {$authConfig['guards']['admin']['provider']}\n";
    } else {
        echo "❌ Admin guard not configured!\n";
    }

    if (isset($authConfig['providers']['admins'])) {
        echo "✅ Admin provider configured\n";
        echo "   Driver: {$authConfig['providers']['admins']['driver']}\n";
        echo "   Model: {$authConfig['providers']['admins']['model']}\n";
    } else {
        echo "❌ Admin provider not configured!\n";
    }

    echo "\n";

    // Test 4: Test direct authentication
    echo "📋 Test 4: Testing direct authentication...\n";
    
    $credentials = [
        'email' => $admin->email,
        'password' => $testPassword
    ];

    if (Auth::guard('admin')->attempt($credentials)) {
        echo "✅ Direct authentication SUCCESS\n";
        Auth::guard('admin')->logout(); // Clean up
    } else {
        echo "❌ Direct authentication FAILED\n";
        echo "💡 This indicates a password or configuration issue\n";
    }

    echo "\n";

    // Test 5: Check database connection
    echo "📋 Test 5: Checking database connection...\n";
    
    try {
        $adminCount = DB::table('admins')->count();
        echo "✅ Database connection working\n";
        echo "   Total admins in database: {$adminCount}\n";
    } catch (Exception $e) {
        echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    }

    echo "\n";

    // Test 6: Check routes
    echo "📋 Test 6: Checking admin routes...\n";
    
    try {
        $loginRoute = route('admin.login');
        $dashboardRoute = route('admin.dashboard');
        echo "✅ Admin routes configured\n";
        echo "   Login route: {$loginRoute}\n";
        echo "   Dashboard route: {$dashboardRoute}\n";
    } catch (Exception $e) {
        echo "❌ Route configuration issue: " . $e->getMessage() . "\n";
    }

    echo "\n";

    // Test 7: Check session configuration
    echo "📋 Test 7: Checking session configuration...\n";
    
    $sessionDriver = config('session.driver');
    $sessionLifetime = config('session.lifetime');
    echo "✅ Session configuration\n";
    echo "   Driver: {$sessionDriver}\n";
    echo "   Lifetime: {$sessionLifetime} minutes\n";

    echo "\n";

    // Summary and recommendations
    echo "📋 DIAGNOSTIC SUMMARY\n";
    echo "=====================\n";
    
    if (Admin::adminExists() && Hash::check($testPassword, $admin->password)) {
        echo "✅ Admin account and password are correct\n";
        echo "✅ Basic authentication should work\n";
        echo "\n";
        echo "🔧 If login still fails, try:\n";
        echo "1. Clear Laravel caches: php artisan config:clear && php artisan cache:clear\n";
        echo "2. Check browser console for JavaScript errors\n";
        echo "3. Check Laravel logs: tail -f storage/logs/laravel.log\n";
        echo "4. Ensure CSRF token is working\n";
        echo "5. Try disabling browser extensions\n";
    } else {
        echo "❌ Authentication setup issues detected\n";
        echo "\n";
        echo "🔧 Fix the issues above and try again\n";
    }

    echo "\n";

} catch (Exception $e) {
    echo "❌ Diagnostic failed: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
