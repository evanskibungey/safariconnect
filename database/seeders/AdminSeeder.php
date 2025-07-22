<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Exception;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates only ONE admin account for security
     */
    public function run(): void
    {
        try {
            // Check if admin already exists
            if (Admin::adminExists()) {
                $this->command->warn('Admin account already exists. Skipping creation.');
                $admin = Admin::getSingleAdmin();
                $this->command->info('Current admin: ' . $admin->email);
                return;
            }

            // Create single admin user using secure method
            $admin = Admin::createSingleAdmin([
                'name' => 'System Administrator',
                'email' => 'admin@safarikonnect.com',
                'password' => Hash::make('Admin@2025!Secure'),
                'email_verified_at' => now(),
            ]);

            $this->command->info('✓ Single admin account created successfully!');
            $this->command->info('Email: admin@safarikonnect.com');
            $this->command->info('Password: Admin@2025!Secure');
            $this->command->warn('');
            $this->command->warn('⚠️  SECURITY REMINDER:');
            $this->command->warn('   Please change the default password after first login!');
            $this->command->warn('   Only ONE admin account is allowed in the system.');
            $this->command->warn('');

        } catch (Exception $e) {
            $this->command->error('Failed to create admin: ' . $e->getMessage());
        }
    }
}
