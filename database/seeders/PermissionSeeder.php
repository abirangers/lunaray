<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Create the initial permissions and assign them to roles.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User permissions
            'access chat',
            'use_chatbot',
            'view articles',
            
            // Content Manager permissions
            'edit articles',
            'create articles',
            'delete articles',
            'publish articles',
            'unpublish articles',
            'manage products',
            'manage heroes',
            
            // Admin permissions
            'manage users',
            'manage roles',
            'manage permissions',
            'view admin dashboard',
            'manage system settings',
        ];

        // Create permissions and store them
        $permissionObjects = [];
        foreach ($permissions as $permission) {
            $permissionObjects[$permission] = Permission::findOrCreate($permission);
        }

        // Get roles
        $userRole = Role::findByName('user');
        $contentManagerRole = Role::findByName('content_manager');
        $adminRole = Role::findByName('admin');

        // Assign permissions to roles using permission objects
        // User role - basic permissions
        $userRole->givePermissionTo([
            $permissionObjects['access chat'],
            $permissionObjects['use_chatbot'],
            $permissionObjects['view articles'],
        ]);

        // Content Manager role - content management permissions
        $contentManagerRole->givePermissionTo([
            $permissionObjects['access chat'],
            $permissionObjects['use_chatbot'],
            $permissionObjects['view articles'],
            $permissionObjects['edit articles'],
            $permissionObjects['create articles'],
            $permissionObjects['delete articles'],
            $permissionObjects['publish articles'],
            $permissionObjects['unpublish articles'],
            $permissionObjects['manage products'],
            $permissionObjects['manage heroes'],
            $permissionObjects['view admin dashboard'],
        ]);

        // Admin role - all permissions
        $adminRole->givePermissionTo([
            $permissionObjects['access chat'],
            $permissionObjects['use_chatbot'],
            $permissionObjects['view articles'],
            $permissionObjects['edit articles'],
            $permissionObjects['create articles'],
            $permissionObjects['delete articles'],
            $permissionObjects['publish articles'],
            $permissionObjects['unpublish articles'],
            $permissionObjects['manage products'],
            $permissionObjects['manage heroes'],
            $permissionObjects['manage users'],
            $permissionObjects['manage roles'],
            $permissionObjects['manage permissions'],
            $permissionObjects['view admin dashboard'],
            $permissionObjects['manage system settings'],
        ]);

        $this->command->info('Permissions created and assigned to roles successfully!');
    }
}
