<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Departement;
class Reunion extends Model
{
    use HasFactory;
    protected $primaryKey = 'idReunion';
    protected $fillable = [
        'idDepartement',
        'objectif',
        'titre',
        'description',
        'dateHeure',
        'heureFin',
        'type',
        'lien', 
        'lieu'
    ];
    function departement(){
        return $this->belongsTo(Departement::class, 'idDepartement', 'idDepartement');
    }
}
