<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Departement;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $primaryKey = 'idLead';
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'address',
        'CNE', 
        'phoneNumber',
        'nationalite',
        'dateCreation',
        'source',
        'note',
        'type',
        'idUser',
        'idClient',
        'idDepartement',
        'statut',
        "contentAppel",
        "duree"
    ];
    function client(){
        return $this->belongsTo(Client::class, 'idClient', 'idClient');
    }
     function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'idUser'); 
    }
    function departements(){
        return $this->belongsTo(Departement::class, 'idDepartement', 'idDepartement');
    }
}