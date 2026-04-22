<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Prime;
use Illuminate\Database\Eloquent\Model;

class Pointage extends Model
{
    use HasFactory;
    protected $primaryKey = 'idPointage';
    protected $fillable = [
        'idUser',
        'heureEntree',
        'heureSortie',
        'date',
        'status',
        'gps',
        'justification',
        'fichier',
        'typejustif'
    ];
    function primes(){
        return $this->hasMany(Prime::class, 'idPointage', 'idPointage');
    }
}
