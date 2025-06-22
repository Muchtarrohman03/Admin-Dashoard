<?php
// database/seeders/RolePermissionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions
        $permissions = [
            'view products', 'create products', 'edit products', 'delete products',
            'view services', 'create services', 'edit services', 'delete services',
            'view orders', 'create orders', 'edit orders', 'delete orders',
            'view users', 'create users', 'edit users', 'delete users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Roles
    $admin = Role::firstOrCreate(['name' => 'admin']);
    $pimpinan = Role::firstOrCreate(['name' => 'pimpinan']);
    $superAdmin = Role::firstOrCreate(['name' => 'super admin', 'guard_name' => 'web']);

    // Admin: CRUD products, services, orders (no user)
    $admin->syncPermissions([
        'view products', 'create products', 'edit products', 'delete products',
        'view services', 'create services', 'edit services', 'delete services',
        'view orders', 'create orders', 'edit orders', 'delete orders',
    ]);

    // Pimpinan: View semua, hanya CRUD users
    $pimpinan->syncPermissions([
        'view products', 'view services', 'view orders',
        'view users', 'create users', 'edit users', 'delete users',
    ]);

    // Super Admin: full access
    $superAdmin->syncPermissions(Permission::all());

    }
}

