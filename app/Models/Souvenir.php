<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\Dossier;

class Souvenir extends Model
{
    use HasFactory;

    protected $primaryKey = 'idSouvenir';

    protected $fillable = [
        'idClient',
        'idDossier',
        'titre',
        'description',
        'image',
        'date',
        'mood',
        'location'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'idClient', 'idClient');
    }

    public function dossier()
    {
        return $this->belongsTo(Dossier::class, 'idDossier', 'idDossier');
    }
}
