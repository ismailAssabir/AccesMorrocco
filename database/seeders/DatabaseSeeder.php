<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(RolePermissionSeeder::class);
        $user =User::factory()->create([
            'firstName'=>'ismail',
            'lastName'=>"assabir",
            'email'=>"ismailassabir@gmail.com",
            'password'=>Hash::make('ismail1234'), 
            'cin'=>'IC162465', 
            'birthday'=>"2002/08/06", 
            'address'=>null, 
            'phoneNumber'=>'0632939206', 
            'typeContrat'=>"CI", 
            'salaire'=>9000.00, 
            'post'=>null, 
            'dateEmb'=>now(), 'idDepartement'=>null, 
            'status'=>"active",
            'type'=>'admin', 
            'fichier'=> "fichier.pdf", 
            'rip'=> '209Y655TR5',
            'created_at'=>now(), 
            'updated_at'=>now()
        ]);
        $user->syncRoles(['admin']);
    }
}
