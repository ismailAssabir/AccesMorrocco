<?php

namespace App\Models;
use App\Models\Tache;
use Illuminate\Database\Eloquent\Model;

class Objectif extends Model
{
    use HasFactory;
    protected $primaryKey = 'idObjectif';
    protected $fillable = [
        'titre',
        'description',
        'dateFin',
        'dateDebut',
        'status',
        'avancement',
        'idDepartement'
    ];
    function taches(){
        return $this->hasMany(Tache::class, 'idObjectif', 'idObjectif');
    }
}
