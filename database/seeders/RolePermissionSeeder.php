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
            'dashboard.view',
            // --- Permission ---
            'permission.edit',
            'permission.view',

            // --- Category ---
            'category.view',
            'category.create',
            'category.delete',
            'category.edit',

            // --- Users ---
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',

            // --- Départements ---
            'departement.view',
            'departement.create',
            'departement.edit',
            'departement.delete',

            // --- Clients ---
            'client.view',
            'client.create',
            'client.edit',
            'client.delete',

            // --- Leads ---
            'lead.view',
            'lead.create',
            'lead.edit',
            'lead.delete',

            // --- Dossiers ---
            'dossier.view',
            'dossier.create',
            'dossier.edit',
            'dossier.delete',

            // --- Présentations ---
            'presentation.view',
            'presentation.create',
            'presentation.edit',
            'presentation.delete',

            // --- Paiements ---
            'paiement.view',
            'paiement.create',
            'paiement.edit',
            'paiement.delete',

            // --- Tâches ---
            'tache.view',
            'tache.create',
            'tache.edit',
            'tache.delete',

            // --- Pointages ---
            'pointage.view',
            'pointage.create',
            'pointage.edit',
            'pointage.delete',

            // --- Congés ---
            'conge.view',
            'conge.create',
            'conge.edit',
            'conge.delete',
            'conge.approve',

            // --- Réclamations ---
            'reclamation.view',
            'reclamation.create',
            'reclamation.edit',
            'reclamation.delete',
            'reclamation.respond',

            // --- Documents ---
            'document.view',
            'document.create',
            'document.edit',
            'document.delete',
            'document.approve',

            // --- Réunions ---
            'reunion.view',
            'reunion.create',
            'reunion.edit',
            'reunion.delete',

            // --- Objectifs ---
            'objectif.view',
            'objectif.create',
            'objectif.edit',
            'objectif.delete',

            // --- Primes ---
            'prime.view',
            'prime.create',
            'prime.edit',
            'prime.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to admin (All except pointage creation/edit)
        $adminPermissions = Permission::whereNotIn('name', ['pointage.create', 'pointage.edit'])->get();
        $adminRole->syncPermissions($adminPermissions);

        // Assign permissions to manager
        $managerRole->syncPermissions([
            'user.view', 'user.create', 'user.edit',
            'departement.view', 'departement.create', 'departement.edit',
            'client.view', 'client.create', 'client.edit',
            'lead.view', 'lead.create', 'lead.edit',
            'dossier.view', 'dossier.create', 'dossier.edit',
            'tache.view', 'tache.create', 'tache.edit', 'tache.delete',
            'pointage.view', 'pointage.create', 'pointage.edit',
            'conge.view', 'conge.create', 'conge.edit', 'conge.approve',
            'reclamation.view', 'reclamation.create', 'reclamation.edit', 'reclamation.respond',
            'document.view', 'document.create', 'document.edit', 'document.approve',
            'reunion.view', 'reunion.create', 'reunion.edit', 'reunion.delete',
            'objectif.view', 'objectif.create', 'objectif.edit', 'objectif.delete',
        ]);

        // Assign permissions to employee
        $employeeRole->syncPermissions([
            'tache.view',
            'pointage.view', 'pointage.create', 'pointage.edit',
            'conge.view', 'conge.create',
            'reclamation.view', 'reclamation.create',
            'document.view', 'document.create',
            'reunion.view',
            'objectif.view',
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