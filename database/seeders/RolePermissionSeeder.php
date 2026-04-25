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
        

            // --- Permission ---
            'permission.edit',
            'permission.view',
            // --- Ctegory ---
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

            // --- Objectifs ---
            'objectif.view',
            'objectif.create',
            'objectif.edit',
            'objectif.delete',

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

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }


        // Assign permissions to roles
        $adminRole->syncPermissions(['permission.edit',
            'permission.view',]);

       
    }
}