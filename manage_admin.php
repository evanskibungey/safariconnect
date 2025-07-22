<?php
/**
 * Simple Admin Management Script
 * Use this if artisan commands don't work
 * 
 * Usage: php manage_admin.php [action]
 * Actions: info, create, reset, delete
 */

// Load Laravel
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

// Get command line argument
$action = $argv[1] ?? 'info';

try {
    switch ($action) {
        case 'info':
            showAdminInfo();
            break;
        case 'create':
            createAdmin();
            break;
        case 'reset':
            resetAdmin();
            break;
        case 'delete':
            deleteAdmin();
            break;
        default:
            showUsage();
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}

function showUsage()
{
    echo "🔐 Admin Management Script\n";
    echo "Usage: php manage_admin.php [action]\n";
    echo "Actions:\n";
    echo "  info   - Show admin account information\n";
    echo "  create - Create new admin account (interactive)\n";
    echo "  reset  - Reset admin account (interactive)\n";
    echo "  delete - Delete admin account\n";
}

function showAdminInfo()
{
    echo "📋 Admin Account Information:\n";
    
    if (!Admin::adminExists()) {
        echo "⚠️  No admin account exists.\n";
        echo "💡 Use 'php manage_admin.php create' to create one.\n";
        return;
    }

    $admin = Admin::getSingleAdmin();
    echo "Name: {$admin->name}\n";
    echo "Email: {$admin->email}\n";
    echo "Created: {$admin->created_at}\n";
    echo "Last Updated: {$admin->updated_at}\n";
    echo "Email Verified: " . ($admin->email_verified_at ? 'Yes' : 'No') . "\n";
}

function createAdmin()
{
    echo "🆕 Create Admin Account\n";
    
    if (Admin::adminExists()) {
        echo "❌ Admin account already exists. Use 'reset' to modify.\n";
        exit(1);
    }

    echo "Enter admin name: ";
    $name = trim(fgets(STDIN));
    
    echo "Enter admin email: ";
    $email = trim(fgets(STDIN));
    
    echo "Enter admin password: ";
    $password = trim(fgets(STDIN));

    // Basic validation
    if (empty($name) || empty($email) || empty($password)) {
        echo "❌ All fields are required.\n";
        exit(1);
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "❌ Invalid email format.\n";
        exit(1);
    }

    if (strlen($password) < 8) {
        echo "❌ Password must be at least 8 characters.\n";
        exit(1);
    }

    try {
        $admin = Admin::createSingleAdmin([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        echo "✅ Admin account created successfully!\n";
        echo "Name: {$admin->name}\n";
        echo "Email: {$admin->email}\n";
        echo "⚠️  Please store the credentials securely.\n";
    } catch (Exception $e) {
        echo "❌ Failed to create admin: " . $e->getMessage() . "\n";
        exit(1);
    }
}

function resetAdmin()
{
    echo "🔄 Reset Admin Account\n";
    
    if (!Admin::adminExists()) {
        echo "❌ No admin account exists. Use 'create' first.\n";
        exit(1);
    }

    $admin = Admin::getSingleAdmin();
    echo "Current admin: {$admin->email}\n";
    
    echo "Enter new admin name (press Enter to keep '{$admin->name}'): ";
    $name = trim(fgets(STDIN));
    if (empty($name)) $name = $admin->name;
    
    echo "Enter new admin email (press Enter to keep '{$admin->email}'): ";
    $email = trim(fgets(STDIN));
    if (empty($email)) $email = $admin->email;
    
    echo "Enter new admin password: ";
    $password = trim(fgets(STDIN));

    // Basic validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "❌ Invalid email format.\n";
        exit(1);
    }

    if (strlen($password) < 8) {
        echo "❌ Password must be at least 8 characters.\n";
        exit(1);
    }

    try {
        $admin->update([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        echo "✅ Admin account updated successfully!\n";
        echo "Name: {$admin->name}\n";
        echo "Email: {$admin->email}\n";
    } catch (Exception $e) {
        echo "❌ Failed to update admin: " . $e->getMessage() . "\n";
        exit(1);
    }
}

function deleteAdmin()
{
    echo "🗑️  Delete Admin Account\n";
    
    if (!Admin::adminExists()) {
        echo "⚠️  No admin account exists.\n";
        return;
    }

    $admin = Admin::getSingleAdmin();
    echo "⚠️  This will delete the admin account: {$admin->email}\n";
    echo "Are you sure? Type 'YES' to confirm: ";
    $confirmation = trim(fgets(STDIN));
    
    if ($confirmation !== 'YES') {
        echo "Operation cancelled.\n";
        return;
    }

    try {
        $admin->delete();
        echo "✅ Admin account deleted successfully.\n";
        echo "💡 You can now create a new admin account if needed.\n";
    } catch (Exception $e) {
        echo "❌ Failed to delete admin: " . $e->getMessage() . "\n";
        exit(1);
    }
}
