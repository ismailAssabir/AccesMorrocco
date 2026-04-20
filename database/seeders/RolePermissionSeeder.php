<?php namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {

        $permissions = [

            // --- Ctegory ---
            'category.view',
            'category.create',
            'category.delete',
            'category.edit',
            // --- Users ---
            'user.view',
            'user.create',
            'user.edit',

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
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());

        $manager = Role::firstOrCreate(['name' => 'manager']);
        $manager->syncPermissions([
            'user.view',
            'departement.view',
            'client.view', 'client.create', 'client.edit',
            'lead.view', 'lead.create', 'lead.edit',
            'dossier.view', 'dossier.create', 'dossier.edit',
            'presentation.view', 'presentation.create', 'presentation.edit',
            'paiement.view', 'paiement.create',
            'objectif.view', 'objectif.create', 'objectif.edit',
            'tache.view', 'tache.create', 'tache.edit',
            'pointage.view',
            'conge.view', 'conge.approve',
            'reclamation.view', 'reclamation.respond',
            'document.view', 'document.approve',
            'reunion.view', 'reunion.create', 'reunion.edit',
            'prime.view', 'prime.create',
        ]);
        $employe = Role::firstOrCreate(['name' => 'employe']);
        $employe->syncPermissions([
            'tache.view',
            'pointage.view', 'pointage.create',
            'conge.view', 'conge.create',
            'reclamation.view', 'reclamation.create',
            'document.view', 'document.create',
            'reunion.view',
            'objectif.view',
            'prime.view',
            'presentation.view',
            'dossier.view',
        ]);


    
    }

        

    
    
}