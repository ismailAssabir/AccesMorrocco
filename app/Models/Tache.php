<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Prime;
class Tache extends Model
{
    use HasFactory;
    protected $primaryKey = 'idTache';
    protected $fillable=[
        'idObjectif',
        'titre',
        'dateDebut',
        'duree',
        'typeDuree',
        'heureDebut',
        'priorite',
        'status',
        'description'
    ];
    function objectif(){
        return $this->belongsTo(Objectif::class, 'idObjectif', 'idObjectif');
    }
    function users(){
        return $this->belongsToMany(User::class, 'user_taches', 'idTache', 'idUser');
    }
    function primes(){
        return $this->hasMany(Prime::class, 'idTache', 'idTache');
    }
}
