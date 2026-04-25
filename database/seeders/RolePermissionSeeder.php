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
<<<<<<< HEAD
            'users.view', 'users.manage',
            'reunions.view', 'reunions.manage',
            'reclamations.view', 'reclamations.manage',
            'dashboard.view',
            'objectif.view', 'objectif.create', 'objectif.edit', 'objectif.delete',
=======
        
>>>>>>> 902eae50e825771163336ffc8f5158d767daa782

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

            // --- Primes ---
            'prime.view',
            'prime.create',
            'prime.edit',
            'prime.delete',
<<<<<<< HEAD
=======

>>>>>>> 902eae50e825771163336ffc8f5158d767daa782
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

<<<<<<< HEAD
=======

>>>>>>> 902eae50e825771163336ffc8f5158d767daa782
        // Assign permissions to roles
        $adminRole->syncPermissions(['permission.edit',
            'permission.view',]);

<<<<<<< HEAD
        $managerRole->syncPermissions([
            'dashboard.view',
            'users.view', 'users.manage',
            'user.view',
            'client.view', 'client.create', 'client.edit',
            'lead.view', 'lead.create', 'lead.edit',
            'dossier.view', 'dossier.create', 'dossier.edit',
            'presentation.view', 'presentation.create', 'presentation.edit',
            'paiement.view', 'paiement.create',
            'objectif.view', 'objectif.create', 'objectif.edit',
            'tache.view', 'tache.create', 'tache.edit',
            'pointage.view',
            'conge.view', 'conge.approve',
            'reclamation.view', 'reclamation.respond', 'reclamations.view', 'reclamations.manage',
            'document.view', 'document.approve',
            'reunion.view', 'reunion.create', 'reunion.edit', 'reunions.view', 'reunions.manage',
            'prime.view', 'prime.create', 'prime.delete',
        ]);

        $employeeRole->syncPermissions([
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
=======
       
>>>>>>> 902eae50e825771163336ffc8f5158d767daa782
    }
}