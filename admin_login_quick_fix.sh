#!/bin/bash

echo "🔧 ADMIN LOGIN QUICK FIX SCRIPT"
echo "==============================="
echo ""

echo "📋 Step 1: Clearing all Laravel caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
echo "✅ Caches cleared"
echo ""

echo "📋 Step 2: Checking admin account status..."
if php artisan admin:manage info > /dev/null 2>&1; then
    echo "✅ Admin management command working"
    php artisan admin:manage info
else
    echo "⚠️  Using alternative admin script..."
    if [ -f "manage_admin.php" ]; then
        php manage_admin.php info
    else
        echo "❌ Admin management not available"
    fi
fi
echo ""

echo "📋 Step 3: Testing database connection..."
if php artisan tinker --execute="echo App\\Models\\Admin::count() . ' admins found';" 2>/dev/null; then
    echo "✅ Database connection working"
else
    echo "❌ Database connection failed"
fi
echo ""

echo "📋 Step 4: Checking file permissions..."
if [ -w "storage/logs" ]; then
    echo "✅ Log directory writable"
else
    echo "❌ Log directory not writable"
    echo "💡 Try: chmod -R 775 storage/"
fi
echo ""

echo "📋 Step 5: Running diagnostic tool..."
if [ -f "admin_login_diagnostic.php" ]; then
    echo "🔍 Running comprehensive diagnostic..."
    echo "This will test your admin login setup..."
    echo ""
    php admin_login_diagnostic.php
else
    echo "❌ Diagnostic tool not found"
    echo "💡 Please create admin_login_diagnostic.php"
fi
echo ""

echo "✅ QUICK FIX COMPLETE"
echo "===================="
echo ""
echo "🌐 Now test your login at:"
echo "https://safarikonect.co.ke/admin/login"
echo ""
echo "📖 If issues persist:"
echo "1. Check browser console for errors"
echo "2. Check storage/logs/laravel.log"
echo "3. Try incognito/private browsing"
echo "4. Verify admin credentials with diagnostic tool"
