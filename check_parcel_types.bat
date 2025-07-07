@echo off
echo ==========================================
echo Checking Parcel Type Configuration
echo ==========================================
echo.

echo Listing parcel types in the database...
php artisan tinker --execute="App\Models\ParcelType::select('id', 'name', 'max_weight_kg', 'is_active')->get()->each(function($pt) { echo sprintf('ID: %d | Name: %-20s | Max Weight: %5.1fkg | Active: %s', $pt->id, $pt->name, $pt->max_weight_kg, $pt->is_active ? 'Yes' : 'No') . PHP_EOL; });"

echo.
echo ==========================================
echo Mapped Parcel Type Values for Pricing
echo ==========================================
php artisan tinker --execute="$mapping = ['Documents' => 'documents', 'Small Package' => 'small', 'Medium Package' => 'medium', 'Large Package' => 'large', 'Extra Large' => 'extra_large']; App\Models\ParcelType::active()->get()->each(function($pt) use ($mapping) { $value = $mapping[$pt->name] ?? strtolower(str_replace(' ', '_', $pt->name)); echo sprintf('%-20s => %-15s', $pt->name, $value) . PHP_EOL; });"

echo.
echo ==========================================
echo Next Steps:
echo ==========================================
echo 1. Visit: http://127.0.0.1:8000/admin/transportation/pricing/create
echo 2. Select "Parcel Delivery" as the service type
echo 3. Check the "Parcel Type" dropdown shows database values
echo.
pause
