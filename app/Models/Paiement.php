<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Dossier;

class Paiement extends Model
{
    use HasFactory;
    protected $primaryKey = 'idPaiement';
    protected $fillable = [
        'idDossier',
        'montantPaye',
        'montantReste',
        'modePaiement',
        'date',
        'ref',
        'status',
        'note'
    ];
    function dossier(){
        return $this->belongsTo(Dossier::class, 'idDossier', 'idDossier');
    }
}
