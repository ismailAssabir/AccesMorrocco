<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reclamation extends Model
{
    use HasFactory;
    
    protected $table = 'reclamations';
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
