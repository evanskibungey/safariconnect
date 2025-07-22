#!/bin/bash

echo "🔐 TESTING SECURE ADMIN IMPLEMENTATION"
echo "======================================"
echo ""

# Test 1: Check admin status
echo "📋 Test 1: Checking admin account status..."
php artisan admin:manage info
echo ""

# Test 2: Try to access registration route
echo "🚫 Test 2: Testing registration route protection..."
echo "Attempting to access /admin/register (should be blocked if admin exists)..."
curl -s -o /dev/null -w "HTTP Status: %{http_code}\n" http://localhost/admin/register 2>/dev/null || echo "cURL not available or server not running"
echo ""

# Test 3: Check seeder behavior
echo "🌱 Test 3: Testing admin seeder (safe to run multiple times)..."
php artisan db:seed --class=AdminSeeder
echo ""

# Test 4: Show security logs
echo "📝 Test 4: Recent admin-related log entries..."
if [ -f "storage/logs/laravel.log" ]; then
    echo "Last 5 admin-related log entries:"
    tail -100 storage/logs/laravel.log | grep -i admin | tail -5 || echo "No admin-related logs found"
else
    echo "No log file found yet"
fi
echo ""

echo "✅ TESTING COMPLETE"
echo "==================="
echo ""
echo "🔍 WHAT TO VERIFY:"
echo "1. Only one admin account should exist"
echo "2. /admin/register should return 403 when admin exists"  
echo "3. Admin seeder should skip creation if admin exists"
echo "4. Logs should show any unauthorized attempts"
echo ""
echo "📖 For full documentation, see: ADMIN_SECURITY_DOCUMENTATION.md"
echo "🛠️  For admin management, use: php artisan admin:manage [action]"
