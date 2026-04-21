<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conge extends Model
{
    use HasFactory;
    protected $primaryKey = 'idConge';
    protected $fillable = [
        'idUser',
        'sold',
        'type', 
        'justification',
        'status', 'motif',
        'dateDebut',
        'dateFin',
        'dateDemande'
    ];
    function user(){
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }
}
