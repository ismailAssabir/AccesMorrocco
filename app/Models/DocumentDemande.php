<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentDemande extends Model
{
    use HasFactory;
    protected $primaryKey = 'idDocument';
    protected $fillable = [
        'idUser',
        'titre', 
        'description',
        'dateDemande',
        'status',
        'type', 
        'fichier'
    ];
    function user(){
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }
}
