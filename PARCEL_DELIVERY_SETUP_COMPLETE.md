# PARCEL DELIVERY SETUP INSTRUCTIONS

## Summary of Changes

I have successfully configured the Parcel Delivery system to load parcel types from the database and display them in the customer booking form. Here's what was done:

### 1. **Database Seeders Created/Activated**
- **ParcelTypeSeeder.php** - Seeds 5 parcel types (Documents, Small Package, Medium Package, Large Package, Extra Large)
- **ParcelDeliveryPricingSeeder.php** - Seeds pricing for all routes and parcel types

### 2. **Updated DatabaseSeeder.php**
- Added ParcelTypeSeeder and ParcelDeliveryPricingSeeder to the seeding sequence
- Ensures proper order of seeding (Cities → Airports → VehicleTypes → ParcelTypes → Services → Pricing)

### 3. **System Architecture**
The system is already properly configured to:
- Fetch parcel types from the database via `/api/parcel-types` endpoint
- Display them in the dropdown in the parcel delivery modal
- Calculate dynamic pricing based on:
  - Selected parcel type
  - Pickup and delivery locations
  - Weight of the parcel
  - Additional options (urgent delivery, insurance)

## Steps to Complete Setup

### Option 1: Full Database Seed (Recommended)
```bash
# This will seed all data including parcel types and pricing
php artisan db:seed
```

### Option 2: Seed Only Parcel Data
```bash
# Seed parcel types
php artisan db:seed --class=ParcelTypeSeeder

# Seed parcel delivery pricing
php artisan db:seed --class=ParcelDeliveryPricingSeeder
```

### Option 3: Fresh Migration and Seed (Clean Install)
```bash
# Drop all tables and re-run migrations with seed
php artisan migrate:fresh --seed
```

## How It Works

1. **Frontend (parcel-delivery-modal.blade.php)**
   - The modal is already configured with a dropdown for parcel types
   - JavaScript automatically loads parcel types when the modal opens

2. **API Endpoint (/api/parcel-types)**
   - Returns all active parcel types from the database
   - Includes: id, name, description, max_weight_kg, base_rate

3. **JavaScript (scripts-enhanced.blade.php)**
   - `loadParcelDeliveryData()` - Fetches cities and parcel types
   - `populateParcelTypes()` - Populates the dropdown with database data
   - `checkParcelDeliveryPricing()` - Calculates pricing based on selections

4. **Pricing Calculation**
   - Base price from database configuration
   - Weight surcharge (KSh 100 per kg over 1kg)
   - Urgent delivery (+50% of base price)
   - Insurance (+2% of base price)

## Admin Panel URLs

After seeding, you can manage the data at:
- **Parcel Types**: http://127.0.0.1:8000/admin/transportation/parcel-types
- **Pricing Configuration**: http://127.0.0.1:8000/admin/transportation/pricing

## Troubleshooting

If parcel types don't appear in the dropdown:
1. Check browser console for errors
2. Verify the database has parcel types: `SELECT * FROM parcel_types;`
3. Ensure the parcel delivery service is active in the database
4. Clear browser cache and reload the page

## Testing the Implementation

1. Visit the main page
2. Click on "Parcel Delivery" service card
3. The dropdown should show:
   - Documents (max 2kg)
   - Small Package (max 5kg)
   - Medium Package (max 15kg)
   - Large Package (max 30kg)
   - Extra Large (max 50kg)

4. Select cities and parcel type to see dynamic pricing

The system is now fully configured to handle parcel delivery bookings with database-driven parcel types and intelligent pricing!
