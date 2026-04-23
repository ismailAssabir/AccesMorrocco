<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $employeeRole = Role::firstOrCreate(['name' => 'employee']);

        // Create basic permissions if needed
        $permissions = [
            'users.view', 'users.manage',
            'reunions.view', 'reunions.manage',
            'reclamations.view', 'reclamations.manage',
            'dashboard.view',
            'objectif.view', 'objectif.create', 'objectif.edit', 'objectif.delete'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        $adminRole->givePermissionTo(Permission::all());
        $managerRole->givePermissionTo([
            'reunions.view', 'reunions.manage',
            'reclamations.view', 'reclamations.manage',
            'dashboard.view'
        ]);
        $employeeRole->givePermissionTo([
            'reunions.view',
            'reclamations.view',
            'dashboard.view',
            'objectif.view'
        ]);

        // Sync existing users
        User::all()->each(function ($user) use ($adminRole, $managerRole, $employeeRole) {
            if ($user->type === 'admin') {
                $user->assignRole($adminRole);
            } elseif ($user->type === 'manager') {
                $user->assignRole($managerRole);
            } else {
                $user->assignRole($employeeRole);
            }
        });
    }
}