@echo off
echo 🔐 TESTING SECURE ADMIN IMPLEMENTATION
echo ======================================
echo.

REM Test 1: Check admin status
echo 📋 Test 1: Checking admin account status...
php artisan admin:manage info
echo.

REM Test 2: Check seeder behavior  
echo 🌱 Test 2: Testing admin seeder (safe to run multiple times)...
php artisan db:seed --class=AdminSeeder
echo.

REM Test 3: Show security logs
echo 📝 Test 3: Recent admin-related log entries...
if exist "storage\logs\laravel.log" (
    echo Last 5 admin-related log entries:
    powershell "Get-Content 'storage\logs\laravel.log' | Select-String -Pattern 'admin' -CaseSensitive:$false | Select-Object -Last 5"
) else (
    echo No log file found yet
)
echo.

echo ✅ TESTING COMPLETE
echo ===================
echo.
echo 🔍 WHAT TO VERIFY:
echo 1. Only one admin account should exist
echo 2. /admin/register should return 403 when admin exists  
echo 3. Admin seeder should skip creation if admin exists
echo 4. Logs should show any unauthorized attempts
echo.
echo 📖 For full documentation, see: ADMIN_SECURITY_DOCUMENTATION.md
echo 🛠️  For admin management, use: php artisan admin:manage [action]
echo.
pause
