<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        Admin::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'System Administrator',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // Create test admin user
        Admin::firstOrCreate(
            ['email' => 'test@admin.com'],
            [
                'name' => 'Test Admin',
                'email' => 'test@admin.com', 
                'password' => Hash::make('test'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin users created successfully!');
        $this->command->info('Default admin: admin@example.com / admin123');
        $this->command->info('Test admin: test@admin.com / test');
    }
}
