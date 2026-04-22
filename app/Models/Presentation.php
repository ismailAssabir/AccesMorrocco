<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dossier;

class Presentation extends Model
{
    use HasFactory;
    protected $primaryKey = 'idPresentation';
    protected $fillable = [
        'idDossier',
        'titre',
        'date',
        'status',
        'comment',
        'reponse'
    ];
    function dossier(){
        return $this->belongsTo(Dossier::class, 'idDossier', 'idDossier');
    }
    function presentationItems(){
        return $this->hasMany(PresentationItem::class, 'idPresentation', 'idPresentation');
    }
}
