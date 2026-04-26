<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Lead;
use App\Models\Dossier;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $primaryKey = 'idClient';
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
    function lead(){
        return $this->hasOne(Lead::class, 'idClient');
    }
    function dossiers(){
        return $this->hasMany(Dossier::class, 'idClient', 'idClient');
    }
    public function departement()
    {
        return $this->belongsTo(\App\Models\Departement::class, 'idDepartement', 'idDepartement');
    }

    public function assignedUser()
    {
        return $this->belongsTo(\App\Models\User::class, 'idUser', 'idUser');
    }
}
