<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Prime;

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
        'typejustif',
        'justification_status',
        'motif_refus'
    ];
    public function user() {
        return $this->belongsTo(\App\Models\User::class, 'idUser', 'idUser');
    }

    public function primes() {
        return $this->hasMany(Prime::class, 'idPointage', 'idPointage');
    }
}
