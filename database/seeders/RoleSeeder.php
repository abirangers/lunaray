<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $userRole = Role::create(['name' => 'user']);
        $contentManagerRole = Role::create(['name' => 'content_manager']);
        $adminRole = Role::create(['name' => 'admin']);

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
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to roles
        $userRole->givePermissionTo(['view_articles', 'use_chatbot']);
        
        $contentManagerRole->givePermissionTo([
            'view_articles', 'use_chatbot',
            'create_articles', 'edit_articles', 'delete_articles', 'publish_articles',
            'manage_categories', 'view_dashboard'
        ]);
        
        $adminRole->givePermissionTo([
            'view_articles', 'use_chatbot',
            'create_articles', 'edit_articles', 'delete_articles', 'publish_articles',
            'manage_categories', 'view_dashboard',
            'manage_users', 'assign_roles', 'view_admin_dashboard', 'manage_system_settings'
        ]);
    }
}
