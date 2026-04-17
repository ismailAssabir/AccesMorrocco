<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pointage;
use App\Models\Tache;

class Prime extends Model
{
    use HasFactory;
    protected $primaryKey = 'idPrime';
    protected $fillable = [
        'idTache',
        'idPointage',
        'idObjectif',
        'montant',
        'motif',
        'dateAttribution',
        'status'
    ];
    function pointage(){
        return $this->belongsTo(Pointage::class, 'idPointage', 'idPointage');
    }
    function tache(){
        return $this->belongsTo(Tache::class, 'idTache', 'idTache');
    }
}
