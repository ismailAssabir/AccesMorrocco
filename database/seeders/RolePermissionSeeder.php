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
<<<<<<< HEAD
        
=======
=======
<<<<<<< HEAD
            // --- Legacy / Plural / Custom (from HEAD) ---
=======
>>>>>>> 04a6baae2143338c3134c3b358acc68e030686a7
>>>>>>> ad975bf7b2e921d1b92d096d3764c8fb25bcea78
            'users.view', 'users.manage',
            'reunions.view', 'reunions.manage',
            'reclamations.view', 'reclamations.manage',
            'dashboard.view',
<<<<<<< HEAD
=======
>>>>>>> 7f66f8f966f514da8a3288712e728d31919943c9

=======
            'objectif.view', 'objectif.create', 'objectif.edit', 'objectif.delete',
<<<<<<< HEAD
>>>>>>> 7c796e9f5a864443e53e933abdac9c3335d98aea

=======
>>>>>>> 04a6baae2143338c3134c3b358acc68e030686a7
>>>>>>> ad975bf7b2e921d1b92d096d3764c8fb25bcea78
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
<<<<<<< HEAD

=======
>>>>>>> 7c796e9f5a864443e53e933abdac9c3335d98aea
=======
<<<<<<< HEAD
=======

>>>>>>> 7f66f8f966f514da8a3288712e728d31919943c9
=======
>>>>>>> 04a6baae2143338c3134c3b358acc68e030686a7
>>>>>>> ad975bf7b2e921d1b92d096d3764c8fb25bcea78
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> 04a6baae2143338c3134c3b358acc68e030686a7
        // Assign permissions to roles
        $adminRole->givePermissionTo(Permission::all());
>>>>>>> ad975bf7b2e921d1b92d096d3764c8fb25bcea78

=======
>>>>>>> 7c796e9f5a864443e53e933abdac9c3335d98aea
        // Assign permissions to roles
        $adminRole->syncPermissions(['permission.edit',
            'permission.view',]);

<<<<<<< HEAD
       
=======
        $managerRole->syncPermissions([
<<<<<<< HEAD
            'dashboard.view',
            'users.view', 'users.manage',
=======
<<<<<<< HEAD
            'dashboard.view',
            'users.view', 'users.manage',
=======

        $manager = Role::firstOrCreate(['name' => 'manager']);
        $manager->syncPermissions([
>>>>>>> 7f66f8f966f514da8a3288712e728d31919943c9
=======
>>>>>>> 04a6baae2143338c3134c3b358acc68e030686a7
>>>>>>> ad975bf7b2e921d1b92d096d3764c8fb25bcea78
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
<<<<<<< HEAD
            'prime.view', 'prime.create',
<<<<<<< HEAD
=======

>>>>>>> 7f66f8f966f514da8a3288712e728d31919943c9
=======
            'prime.view', 'prime.create', 'prime.delete',
<<<<<<< HEAD
=======
            'dashboard.view'
>>>>>>> 04a6baae2143338c3134c3b358acc68e030686a7
>>>>>>> ad975bf7b2e921d1b92d096d3764c8fb25bcea78
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
>>>>>>> 7c796e9f5a864443e53e933abdac9c3335d98aea
    }
}