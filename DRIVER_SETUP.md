# Driver Management Setup Instructions

## 1. Run the migration to add vehicle details fields:
```bash
php artisan migrate
```

## 2. Create storage link for file uploads:
```bash
php artisan storage:link
```

## 3. Create the driver-agreements directory (if needed):
```bash
mkdir -p storage/app/public/driver-agreements
```

## 4. Set proper permissions (on Linux/Mac):
```bash
chmod -R 755 storage/app/public/driver-agreements
```

## Features Added:

### Driver Creation Form:
- **Personal Information**: Name, Email, Phone, License details
- **Vehicle Information**: 
  - Vehicle Type (dropdown from vehicle_types table)
  - Registration Number
  - Make, Model, Year, Color (optional)
- **Agreement Document**: 
  - Upload support for PDF, DOC, DOCX, JPG, PNG files
  - Maximum file size: 5MB
  - Agreement date tracking
- **Additional Notes**: Text area for any extra information

### Driver Edit Form:
- All fields from create form
- Current agreement document preview with link
- Option to replace agreement document
- Display driver statistics (trips, rating)

### Driver Details View:
- Complete driver information
- Vehicle details
- Agreement document access
- Recent bookings list
- Driver statistics
- Current booking status
- Quick actions (status update, activate/deactivate)

### File Upload Security:
- Files are stored in `storage/app/public/driver-agreements`
- Only authorized admins can access through the application
- Old files are automatically deleted when replaced

### Access URLs:
- Create Driver: `/admin/drivers/create`
- Edit Driver: `/admin/drivers/{id}/edit`
- View Driver: `/admin/drivers/{id}`
- List Drivers: `/admin/drivers`
