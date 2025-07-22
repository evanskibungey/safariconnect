@echo off
echo 🔧 ADMIN LOGIN QUICK FIX SCRIPT
echo ===============================
echo.

echo 📋 Step 1: Clearing all Laravel caches...
php artisan config:clear >nul 2>&1
php artisan cache:clear >nul 2>&1
php artisan route:clear >nul 2>&1
php artisan view:clear >nul 2>&1
php artisan optimize:clear >nul 2>&1
echo ✅ Caches cleared
echo.

echo 📋 Step 2: Checking admin account status...
php artisan admin:manage info >nul 2>&1
if %ERRORLEVEL% EQU 0 (
    echo ✅ Admin management command working
    php artisan admin:manage info
) else (
    echo ⚠️  Using alternative admin script...
    if exist "manage_admin.php" (
        php manage_admin.php info
    ) else (
        echo ❌ Admin management not available
    )
)
echo.

echo 📋 Step 3: Testing database connection...
echo exit() | php artisan tinker --execute="echo App\Models\Admin::count() . ' admins found';" >nul 2>&1
if %ERRORLEVEL% EQU 0 (
    echo ✅ Database connection working
) else (
    echo ❌ Database connection failed
)
echo.

echo 📋 Step 4: Checking important files...
if exist "storage\logs" (
    echo ✅ Log directory exists
) else (
    echo ❌ Log directory missing
)

if exist "resources\views\admin\auth\login.blade.php" (
    echo ✅ Admin login view exists
) else (
    echo ❌ Admin login view missing
)
echo.

echo 📋 Step 5: Running diagnostic tool...
if exist "admin_login_diagnostic.php" (
    echo 🔍 Running comprehensive diagnostic...
    echo This will test your admin login setup...
    echo.
    php admin_login_diagnostic.php
) else (
    echo ❌ Diagnostic tool not found
    echo 💡 Please create admin_login_diagnostic.php
)
echo.

echo ✅ QUICK FIX COMPLETE
echo ====================
echo.
echo 🌐 Now test your login at:
echo https://safarikonect.co.ke/admin/login
echo.
echo 📖 If issues persist:
echo 1. Check browser console for errors
echo 2. Check storage/logs/laravel.log
echo 3. Try incognito/private browsing
echo 4. Verify admin credentials with diagnostic tool
echo.
pause
