<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure permission cache is cleared to avoid stale data
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles idempotently
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $contentManagerRole = Role::firstOrCreate(['name' => 'content_manager']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Create permissions
        $permissions = [
            // User permissions
            'view_articles',
            'use_chatbot',
            
            // Content Manager permissions
            'create_articles',
            'edit_articles',
            'delete_articles',
            'publish_articles',
            'manage_categories',
            'view_dashboard',
            
            // Admin permissions
            'manage_users',
            'assign_roles',
            'view_admin_dashboard',
            'manage_system_settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $userRole->syncPermissions(['view_articles', 'use_chatbot']);
        
        $contentManagerRole->syncPermissions([
            'view_articles', 'use_chatbot',
            'create_articles', 'edit_articles', 'delete_articles', 'publish_articles',
            'manage_categories', 'view_dashboard'
        ]);
        
        $adminRole->syncPermissions([
            'view_articles', 'use_chatbot',
            'create_articles', 'edit_articles', 'delete_articles', 'publish_articles',
            'manage_categories', 'view_dashboard',
            'manage_users', 'assign_roles', 'view_admin_dashboard', 'manage_system_settings'
        ]);
    }
}
