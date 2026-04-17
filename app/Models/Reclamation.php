<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model
{
    use HasFactory;
    protected $primaryKey = 'idReclamation';
    protected $fillable = [
        'idUser',
        'description',
        'dateEnvoi',
        'status',
        'priorite',
        'reponse', 
        'titre',
        'fichier'
    ];
    function user(){
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }
}
