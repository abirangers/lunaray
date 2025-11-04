<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Seed roles and permissions for testing
        $this->seed(\Database\Seeders\RoleSeeder::class);
        $this->seed(\Database\Seeders\PermissionSeeder::class);
    }

    /**
     * Create an admin user for testing.
     */
    protected function createAdmin(): \App\Models\User
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'admin@test.com',
            'name' => 'Test Admin',
        ]);

        $user->assignRole('admin');

        return $user;
    }

    /**
     * Create a content manager user for testing.
     */
    protected function createContentManager(): \App\Models\User
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'content@test.com',
            'name' => 'Test Content Manager',
        ]);

        $user->assignRole('content_manager');

        return $user;
    }

    /**
     * Create a regular user for testing.
     */
    protected function createUser(): \App\Models\User
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'user@test.com',
            'name' => 'Test User',
        ]);

        $user->assignRole('user');

        return $user;
    }
}
