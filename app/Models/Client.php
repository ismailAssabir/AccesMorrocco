<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Lead;
use App\Models\Dossier;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Client extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;
    protected $primaryKey = 'idClient';
    protected $guard = 'client';
    protected $guard_name = 'client';
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'address',
        'CNE', 
        'phoneNumber',
        'nationalite',
        'dateNaissance',
        'status',
        'type',
        'idLead',
        'note',
    ];
      protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    function lead(){
        return $this->hasOne(Lead::class, 'idClient');
    }
    function dossiers(){
        return $this->hasMany(Dossier::class, 'idClient', 'idClient');
    }
     public function getFirstNameAttribute($value)
    {
        return $value;
    }

    public function getLastNameAttribute($value)
    {
        return $value;
    }
   
}
