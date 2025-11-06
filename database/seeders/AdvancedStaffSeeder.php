<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdvancedStaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Use database transaction for data integrity
        DB::transaction(function () {
            // Define staff data with proper structure
            $staffData = [
                [
                    'email' => 'admin@lunaray.com',
                    'name' => 'Lunaray Admin',
                    'password' => 'admin123456',
                    'role' => 'admin',
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'email' => 'content@lunaray.com',
                    'name' => 'Content Manager',
                    'password' => 'content123456',
                    'role' => 'content_manager',
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'email' => 'marketing@lunaray.com',
                    'name' => 'Marketing Manager',
                    'password' => 'marketing123456',
                    'role' => 'content_manager',
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'email' => 'product@lunaray.com',
                    'name' => 'Product Manager',
                    'password' => 'product123456',
                    'role' => 'content_manager',
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'email' => 'superadmin@lunaray.com',
                    'name' => 'Super Admin',
                    'password' => 'superadmin123456',
                    'role' => 'admin',
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'email' => 'hr@lunaray.com',
                    'name' => 'HR Manager',
                    'password' => 'hr123456',
                    'role' => 'content_manager',
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'email' => 'finance@lunaray.com',
                    'name' => 'Finance Manager',
                    'password' => 'finance123456',
                    'role' => 'content_manager',
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            // Create users with bulk operations for better performance
            $createdUsers = [];
            
            foreach ($staffData as $userData) {
                $user = User::updateOrCreate(
                    ['email' => $userData['email']], // Unique identifier
                    [
                        'name' => $userData['name'],
                        'password' => Hash::make($userData['password']),
                        'email_verified_at' => $userData['email_verified_at'],
                        'created_at' => $userData['created_at'],
                        'updated_at' => $userData['updated_at'],
                    ]
                );

                // Assign role if not already assigned
                if (!$user->hasRole($userData['role'])) {
                    $user->assignRole($userData['role']);
                }

                $createdUsers[] = $user;
            }

            // Create test public users
            $publicUsers = [
                [
                    'email' => 'user1@example.com',
                    'name' => 'Test Public User 1',
                    'password' => 'password123',
                ],
                [
                    'email' => 'user2@example.com',
                    'name' => 'Test Public User 2',
                    'password' => 'password123',
                ],
                [
                    'email' => 'user3@example.com',
                    'name' => 'Test Public User 3',
                    'password' => 'password123',
                ],
            ];

            foreach ($publicUsers as $publicUserData) {
                $user = User::updateOrCreate(
                    ['email' => $publicUserData['email']], // Unique identifier
                    [
                        'name' => $publicUserData['name'],
                        'password' => Hash::make($publicUserData['password']),
                        'email_verified_at' => now(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );

                // Assign user role if not already assigned
                if (!$user->hasRole('user')) {
                    $user->assignRole('user');
                }
            }

            // Create demo users with different roles for testing
            $demoUsers = [
                [
                    'email' => 'demo.admin@lunaray.com',
                    'name' => 'Demo Admin',
                    'password' => 'demo123456',
                    'role' => 'admin',
                ],
                [
                    'email' => 'demo.content@lunaray.com',
                    'name' => 'Demo Content Manager',
                    'password' => 'demo123456',
                    'role' => 'content_manager',
                ],
                [
                    'email' => 'demo.user@example.com',
                    'name' => 'Demo Public User',
                    'password' => 'demo123456',
                    'role' => 'user',
                ],
            ];

            foreach ($demoUsers as $demoUserData) {
                $userData = [
                    'email' => $demoUserData['email'],
                    'name' => $demoUserData['name'],
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Add password for all users
                if (isset($demoUserData['password'])) {
                    $userData['password'] = Hash::make($demoUserData['password']);
                }

                $user = User::updateOrCreate(
                    ['email' => $demoUserData['email']], // Unique identifier
                    $userData
                );

                // Assign role if not already assigned
                if (!$user->hasRole($demoUserData['role'])) {
                    $user->assignRole($demoUserData['role']);
                }
            }
        });

        // Output success message with statistics
        $this->command->info('Advanced staff users created successfully!');
        $this->command->info('=====================================');
        
        // Count users by role
        $adminCount = User::role('admin')->count();
        $contentManagerCount = User::role('content_manager')->count();
        $userCount = User::role('user')->count();
        $totalUsers = User::count();

        $this->command->info("Total Users: {$totalUsers}");
        $this->command->info("Admins: {$adminCount}");
        $this->command->info("Content Managers: {$contentManagerCount}");
        $this->command->info("Public Users: {$userCount}");
        $this->command->info('=====================================');
        
        $this->command->info('Staff Login Credentials:');
        $this->command->info('Admin: admin@lunaray.com (password: admin123456)');
        $this->command->info('Content Manager: content@lunaray.com (password: content123456)');
        $this->command->info('Marketing Manager: marketing@lunaray.com (password: marketing123456)');
        $this->command->info('Product Manager: product@lunaray.com (password: product123456)');
        $this->command->info('Super Admin: superadmin@lunaray.com (password: superadmin123456)');
        $this->command->info('HR Manager: hr@lunaray.com (password: hr123456)');
        $this->command->info('Finance Manager: finance@lunaray.com (password: finance123456)');
        $this->command->info('Demo Admin: demo.admin@lunaray.com (password: demo123456)');
        $this->command->info('Demo Content Manager: demo.content@lunaray.com (password: demo123456)');
        $this->command->info('=====================================');
        $this->command->info('Public Users:');
        $this->command->info('Test Public User 1: user1@example.com (password: password123)');
        $this->command->info('Test Public User 2: user2@example.com (password: password123)');
        $this->command->info('Test Public User 3: user3@example.com (password: password123)');
        $this->command->info('Demo Public User: demo.user@example.com (password: demo123456)');
    }
}