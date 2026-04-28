<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\Departement;
use App\Models\Presentation;
use App\Models\Paiement;
class Dossier extends Model
{
    use HasFactory;
    protected $primaryKey = 'idDossier';
    protected $fillable = [
        'idClient',
        'idDepartement',
        'reference',
        'distination',
        'dateCreation',
        'dateVoyage',
        'nombrePersonnes',
        'montant',
        'commentaire', 
        'reponse',
        'nombreJours',
        'document',
        'titreDocument',
        'status',
        'idUser'
    ];
    function client(){
        return $this->belongsTo(Client::class, 'idClient', 'idClient');
    }
    function departement(){
        return $this->belongsTo(Departement::class, 'idDepartement', 'idDepartement');
    }
    function presentations(){
        return $this->hasMany(Presentation::class, 'idDossier', 'idDossier');
    }
    function paiements(){
        return $this->hasMany(Paiement::class, 'idDossier', 'idDossier');
    }
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'idUser');
    }
}
