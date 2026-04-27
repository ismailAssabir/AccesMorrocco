<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Tache;
use App\Models\Departement;
use App\Models\Reclamation;
use App\Models\Conge;
use App\Models\Dossier;
use App\Models\documentDemande;
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

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
        return $this->belongsto(Departement::class, 'idDepartement', 'idDepartement');
    }
    function departementManager(){
        return $this->hasOne(Departement::class, 'idUser', 'idUser');
    }
     function taches(){
        return $this->belongsToMany(Tache::class, 'user_taches', 'idUser', 'idTache');
    }
     function pointages()
    {
        return $this->hasMany(Pointage::class, 'idUser', 'idUser');
    }
    function conges(){
        return $this->hasMany(Conge::class, 'idUser', 'idUser');
    }
     function lead()
    {
        return $this->hasOne(Lead::class, 'idUser', 'idUser');
    }
    function documents(){
        return $this->hasMany(DocumentDemande::class, 'idUser', 'idUser');
    }
    function reclamations(){
        return $this->hasMany(Reclamation::class, 'idUser', 'idUser');
    }

    protected static function booted()
    {
        static::saved(function ($user) {
            if ($user->isDirty('type') || !$user->roles()->exists()) {
                $user->syncRoles([$user->type]);
            }
        });
    }

    public function isAdmin(): bool { return $this->type === 'admin'; }
    public function isManager(): bool { return $this->type === 'manager'; }

    public function getRoleAttribute()
    {
        return $this->type;
    }

    public function reunions()
    {
        return $this->belongsToMany(Reunion::class, 'reunion_participants', 'idUser', 'idReunion')->withTimestamps();
    }
    public function dossiers(){
        return $this->hasMany(Dossier::class, 'idUser', 'idUser')->withTimestamps();
    }
    public function primes(){
        return $this->hasMany(Prime::class, 'idUser', 'idUser');
    }
}
