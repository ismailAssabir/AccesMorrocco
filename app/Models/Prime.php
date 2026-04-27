<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pointage;
use App\Models\Tache;

class Prime extends Model
{
    use HasFactory;
    protected $primaryKey = 'idPrime';
    protected $fillable = [
        'idUser',
        'idTache',
        'idPointage',
        'idObjectif',
        'montant',
        'motif',
        'dateAttribution',
        'status'
    ];
    public function user(){
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }
    public function objectif(){
        return $this->belongsTo(Objectif::class, 'idObjectif', 'idObjectif');
    }
    function pointage(){
        return $this->belongsTo(Pointage::class, 'idPointage', 'idPointage');
    }
    function tache(){
        return $this->belongsTo(Tache::class, 'idTache', 'idTache');
    }
}
