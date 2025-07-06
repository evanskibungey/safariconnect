# Car Hire Admin Setup Guide - Updated

## Quick Setup Instructions

To get the Car Hire service working with the updated pricing logic, you need to create the following in your admin panel:

### 1. Create Car Hire Transportation Service

Navigate to **Admin → Transportation → Services → Create**

```
Name: Car Hire
Service Type: car_hire
Description: Rent a vehicle for your desired duration
Pricing Model: time_based
Features: ["Self-drive", "Flexible duration", "Multiple vehicle types"]
Is Active: ✓ Yes
```

### 2. Create Vehicle Types (if not already created)

Navigate to **Admin → Transportation → Vehicle Types → Create**

Example vehicle types:
```
Economy Car
- Name: Economy Car
- Description: Fuel efficient and affordable
- Capacity: 4
- Is Active: ✓ Yes

Sedan
- Name: Sedan  
- Description: Comfortable mid-size vehicle
- Capacity: 4
- Is Active: ✓ Yes

SUV
- Name: SUV
- Description: Spacious and versatile
- Capacity: 7
- Is Active: ✓ Yes

Premium Car
- Name: Premium Car
- Description: Luxury and comfort
- Capacity: 4  
- Is Active: ✓ Yes
```

### 3. Create Service Pricing for Car Hire

Navigate to **Admin → Transportation → Pricing → Create**

**Important Fields for Car Hire:**
- Transportation Service: Select "Car Hire" (REQUIRED)
- Vehicle Type: Select vehicle type (REQUIRED - admin will enforce this)
- Base Price: Set price (REQUIRED by admin validation)
- Price Per Day: Set daily rental rate (OPTIONAL but recommended)
- Pickup City: Optional - leave blank for general pricing, or select specific city
- Is Active: ✓ Yes

**How Pricing Works Now:**
1. **Priority**: API will use `price_per_day` if it's set and > 0
2. **Fallback**: If `price_per_day` is empty/zero, it will use `base_price`
3. **Validation**: Admin will require at least one of these fields to be > 0

**Example Pricing Setup:**

```
Economy Car - General Pricing:
- Transportation Service: Car Hire
- Vehicle Type: Economy Car
- Pickup City: [Leave blank for general pricing]
- Base Price: 2500.00 (fallback price)
- Price Per Day: 2500.00 (preferred - this will be used)
- Is Active: ✓ Yes

Sedan - General Pricing:
- Transportation Service: Car Hire  
- Vehicle Type: Sedan
- Pickup City: [Leave blank for general pricing]
- Base Price: 4000.00
- Price Per Day: 4000.00
- Is Active: ✓ Yes

SUV - General Pricing:
- Transportation Service: Car Hire
- Vehicle Type: SUV
- Pickup City: [Leave blank for general pricing] 
- Base Price: 6000.00
- Price Per Day: 6000.00
- Is Active: ✓ Yes

Premium Car - General Pricing:
- Transportation Service: Car Hire
- Vehicle Type: Premium Car
- Pickup City: [Leave blank for general pricing]
- Base Price: 8000.00
- Price Per Day: 8000.00
- Is Active: ✓ Yes
```

**Alternative Setup (using only base_price):**
If you prefer to use only the base_price field:

```
Economy Car:
- Base Price: 2500.00
- Price Per Day: [Leave empty or 0]
```

**Optional: City-Specific Pricing**
If you want different prices for different cities:

```
SUV - Nairobi Specific:
- Transportation Service: Car Hire
- Vehicle Type: SUV
- Pickup City: Nairobi
- Base Price: 7000.00
- Price Per Day: 7000.00
- Is Active: ✓ Yes
```

## How the Updated Pricing Logic Works

### 1. Price Calculation
- **Formula**: Total Price = Daily Rate × Number of Days
- **Daily Rate Determination**:
  1. If `price_per_day` > 0, use `price_per_day`
  2. Else if `base_price` > 0, use `base_price`
  3. Else return error

### 2. City Priority
- City-specific pricing (where pickup_city_id is set) takes priority
- General pricing (where pickup_city_id is null) is used as fallback

### 3. Admin Validation
- Vehicle Type is now REQUIRED for car hire services
- At least one of `base_price` or `price_per_day` must be > 0
- Admin will show clear error messages if validation fails

### 4. API Response
The API now provides detailed information about which price was used:

```json
{
  "success": true,
  "price_per_day": 4000,
  "total_price": 12000,
  "hire_days": 3,
  "pricing_details": {
    "base_price": 4000,
    "price_per_day_field": 4000,
    "used_daily_rate": 4000,
    "rate_source": "price_per_day",
    "city_specific": false
  }
}
```

## Testing the Setup

1. Go to your website's welcome page
2. Click the "Car Hire" card
3. Select a vehicle type
4. Choose pickup location (optional)
5. Select start and end dates
6. Check browser console (F12) for detailed pricing logs
7. You should see the pricing calculation appear automatically

## Troubleshooting

**If pricing doesn't show:**
1. Check browser console for JavaScript errors
2. Check Laravel logs for API errors
3. Verify car hire service exists and is active
4. Ensure vehicle types exist and are active
5. Check that pricing records have either `base_price` or `price_per_day` > 0
6. Verify vehicle type is selected in pricing record

**Console Logs to Check:**
- "Checking car hire pricing with:" - shows request parameters
- "Making pricing request with params:" - shows API call
- "Pricing API response:" - shows API response
- "Price display updated successfully" - confirms UI update

**Common Issues:**
- Both `price_per_day` and `base_price` are 0 or empty
- Car hire service is not active
- Vehicle type not specified in pricing record
- No pricing record matches the selected vehicle type
- Vehicle type is not active

**Debug API Directly:**
Test the pricing API directly:
```
GET /api/car-hire/pricing?vehicle_type_id=1&hire_days=3&pickup_city_id=1
```

The API will log detailed information to help debug issues. All calculations and database queries are logged for troubleshooting.

## Migration from Old Setup

If you had existing car hire pricing that's not working:

1. **Check existing records**: Look at your current pricing records
2. **Ensure vehicle types**: Make sure each record has a vehicle_type_id
3. **Set daily rates**: Ensure either `price_per_day` or `base_price` is > 0
4. **Test each vehicle**: Test pricing for each vehicle type individually

The updated system is more robust and provides better error handling and debugging information.
