<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
     protected $primaryKey = 'idUser';
    protected $fillable = [
        'firstName', 'lastName', 'email', 'password', 'cin', 'birthday', 'address', 'phoneNumber', 
        'typeContrat', 'salaire', 'post', 'dateEmb', 'idDepartement', 'status','type', 
        'fichier', 'rip'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
      function departement(){
        $this->belongsto(Departement::class, 'idDepartement');
    }
    function departementManager(){
        $this->hasOne(Departement::class, 'idUser');
    }
}
