<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::updateOrCreate(
            ['email' => 'admin@lunaray.com'], // Unique identifier
            [
                'name' => 'Lunaray Admin',
                'password' => Hash::make('admin123456'),
                'email_verified_at' => now(),
            ]
        );

        // Assign admin role if not already assigned
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Create Content Manager User
        $contentManager = User::updateOrCreate(
            ['email' => 'content@lunaray.com'], // Unique identifier
            [
                'name' => 'Content Manager',
                'password' => Hash::make('content123456'),
                'email_verified_at' => now(),
            ]
        );

        // Assign content_manager role if not already assigned
        if (!$contentManager->hasRole('content_manager')) {
            $contentManager->assignRole('content_manager');
        }

        // Create additional staff members for testing
        $staffMembers = [
            [
                'name' => 'Marketing Manager',
                'email' => 'marketing@lunaray.com',
                'password' => 'marketing123456',
                'role' => 'content_manager'
            ],
            [
                'name' => 'Product Manager',
                'email' => 'product@lunaray.com',
                'password' => 'product123456',
                'role' => 'content_manager'
            ],
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@lunaray.com',
                'password' => 'superadmin123456',
                'role' => 'admin'
            ]
        ];

        foreach ($staffMembers as $staffData) {
            $user = User::updateOrCreate(
                ['email' => $staffData['email']], // Unique identifier
                [
                    'name' => $staffData['name'],
                    'password' => Hash::make($staffData['password']),
                    'email_verified_at' => now(),
                ]
            );

            // Assign role if not already assigned
            if (!$user->hasRole($staffData['role'])) {
                $user->assignRole($staffData['role']);
            }
        }

        // Create a test public user (Google OAuth user)
        $publicUser = User::updateOrCreate(
            ['email' => 'user@example.com'], // Unique identifier
            [
                'name' => 'Test Public User',
                'google_id' => '123456789', // Simulate Google OAuth ID
                'google_token' => 'test_google_token',
                'google_refresh_token' => 'test_refresh_token',
                'email_verified_at' => now(),
            ]
        );

        // Assign user role if not already assigned
        if (!$publicUser->hasRole('user')) {
            $publicUser->assignRole('user');
        }

        // Output success message
        $this->command->info('Staff users created successfully!');
        $this->command->info('Admin: admin@lunaray.com (password: admin123456)');
        $this->command->info('Content Manager: content@lunaray.com (password: content123456)');
        $this->command->info('Marketing Manager: marketing@lunaray.com (password: marketing123456)');
        $this->command->info('Product Manager: product@lunaray.com (password: product123456)');
        $this->command->info('Super Admin: superadmin@lunaray.com (password: superadmin123456)');
        $this->command->info('Test Public User: user@example.com (Google OAuth)');
    }
}
