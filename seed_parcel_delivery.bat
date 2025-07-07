@echo off
echo ==========================================
echo SafariConnect - Parcel Delivery Setup
echo ==========================================
echo.

echo This will seed parcel types and pricing data
echo.

echo Running parcel type seeder...
php artisan db:seed --class=ParcelTypeSeeder
echo.

echo Running parcel delivery pricing seeder...
php artisan db:seed --class=ParcelDeliveryPricingSeeder
echo.

echo ==========================================
echo Setup Complete!
echo ==========================================
echo.
echo You can now:
echo 1. Visit the main page and test parcel delivery booking
echo 2. Manage parcel types at: /admin/transportation/parcel-types
echo 3. Configure pricing at: /admin/transportation/pricing
echo.
pause
