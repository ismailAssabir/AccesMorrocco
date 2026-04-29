<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ClientRolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Créer le rôle client
        $client = Role::firstOrCreate([
            'name' => 'client',
            'guard_name' => 'client'
        ]);

        // Liste des permissions
        $clientPermissions = [
            'client.view_own_dossiers',
            'client.view_dossier_details',
            'client.download_documents',
            'client.upload_documents',

            'client.edit_profile',
            'client.view_profile',

            'client.view_payments',
            'client.make_payments',

            'client.contact_support',
            'client.view_tickets',
            'client.create_tickets',

            'client.view_travel_insurance',
            'client.request_modification',
            'client.view_notifications',
            'client.export_data',
        ];

        foreach ($clientPermissions as $permission) {
            $perm = Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'client'
            ]);

            
            $client->givePermissionTo($perm);
        }

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}