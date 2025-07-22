<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;

class ManageAdmin extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'admin:manage 
                            {action : The action to perform: create, reset, info, delete}
                            {--name= : Admin name (for create/reset)}
                            {--email= : Admin email (for create/reset)}
                            {--password= : Admin password (for create/reset)}
                            {--force : Force action without confirmation}';

    /**
     * The console command description.
     */
    protected $description = 'Securely manage the single admin account';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');

        switch ($action) {
            case 'create':
                return $this->createAdmin();
            case 'reset':
                return $this->resetAdmin();
            case 'info':
                return $this->showAdminInfo();
            case 'delete':
                return $this->deleteAdmin();
            default:
                $this->error("Invalid action. Use: create, reset, info, or delete");
                return 1;
        }
    }

    /**
     * Create the admin account
     */
    private function createAdmin()
    {
        if (Admin::adminExists()) {
            $this->error('Admin account already exists. Use "reset" to modify or "delete" to remove first.');
            return 1;
        }

        $name = $this->option('name') ?: $this->ask('Admin name');
        $email = $this->option('email') ?: $this->ask('Admin email');
        $password = $this->option('password') ?: $this->secret('Admin password');

        // Validate input
        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            $this->error('Validation failed:');
            foreach ($validator->errors()->all() as $error) {
                $this->error("  - $error");
            }
            return 1;
        }

        try {
            $admin = Admin::createSingleAdmin([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]);

            $this->info('✓ Admin account created successfully!');
            $this->info("Name: {$admin->name}");
            $this->info("Email: {$admin->email}");
            $this->warn('⚠️  Please store the credentials securely.');
            
            return 0;
        } catch (Exception $e) {
            $this->error("Failed to create admin: {$e->getMessage()}");
            return 1;
        }
    }

    /**
     * Reset the admin account
     */
    private function resetAdmin()
    {
        if (!Admin::adminExists()) {
            $this->error('No admin account exists. Use "create" first.');
            return 1;
        }

        $admin = Admin::getSingleAdmin();
        $this->info("Current admin: {$admin->email}");

        if (!$this->option('force') && !$this->confirm('Are you sure you want to reset the admin account?')) {
            $this->info('Operation cancelled.');
            return 0;
        }

        $name = $this->option('name') ?: $this->ask('New admin name', $admin->name);
        $email = $this->option('email') ?: $this->ask('New admin email', $admin->email);
        $password = $this->option('password') ?: $this->secret('New admin password');

        // Validate input
        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            $this->error('Validation failed:');
            foreach ($validator->errors()->all() as $error) {
                $this->error("  - $error");
            }
            return 1;
        }

        try {
            $admin->update([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]);

            $this->info('✓ Admin account updated successfully!');
            $this->info("Name: {$admin->name}");
            $this->info("Email: {$admin->email}");
            
            return 0;
        } catch (Exception $e) {
            $this->error("Failed to update admin: {$e->getMessage()}");
            return 1;
        }
    }

    /**
     * Show admin account information
     */
    private function showAdminInfo()
    {
        if (!Admin::adminExists()) {
            $this->warn('No admin account exists.');
            return 0;
        }

        $admin = Admin::getSingleAdmin();
        
        $this->info('📋 Admin Account Information:');
        $this->info("Name: {$admin->name}");
        $this->info("Email: {$admin->email}");
        $this->info("Created: {$admin->created_at}");
        $this->info("Last Updated: {$admin->updated_at}");
        $this->info("Email Verified: " . ($admin->email_verified_at ? 'Yes' : 'No'));
        
        return 0;
    }

    /**
     * Delete the admin account
     */
    private function deleteAdmin()
    {
        if (!Admin::adminExists()) {
            $this->warn('No admin account exists.');
            return 0;
        }

        $admin = Admin::getSingleAdmin();
        $this->warn("This will delete the admin account: {$admin->email}");
        
        if (!$this->option('force') && !$this->confirm('Are you sure? This action cannot be undone.')) {
            $this->info('Operation cancelled.');
            return 0;
        }

        try {
            $admin->delete();
            $this->info('✓ Admin account deleted successfully.');
            $this->warn('⚠️  You can now create a new admin account if needed.');
            
            return 0;
        } catch (Exception $e) {
            $this->error("Failed to delete admin: {$e->getMessage()}");
            return 1;
        }
    }
}
