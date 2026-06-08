<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();

        $permissions = [
            'create expense',
            'view own expenses',

            'approve expense',
            'verify expense',
            'final approve expense',
            'final cancel expense',

            'manage budgets',
            'manage departments',
            'manage users',

            'view reports',
            'export reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $superAdmin = Role::firstOrCreate([
            'name' => 'super-admin',
            'guard_name' => 'web',
        ]);

        $manager = Role::firstOrCreate([
            'name' => 'manager',
            'guard_name' => 'web',
        ]);

        $accounts = Role::firstOrCreate([
            'name' => 'accounts',
            'guard_name' => 'web',
        ]);

        $staff = Role::firstOrCreate([
            'name' => 'staff',
            'guard_name' => 'web',
        ]);

        // Super Admin
        $superAdmin->syncPermissions(Permission::all());

        // Manager
        $manager->syncPermissions([
            'verify expense',
            'view reports',
            'manage budgets',
        ]);

        // Accounts
        $accounts->syncPermissions([
            'approve expense',
            'verify expense',
            'view reports',
            'export reports',
        ]);

        // Staff
        $staff->syncPermissions([
            'create expense',
            'view own expenses',
        ]);
    }
}