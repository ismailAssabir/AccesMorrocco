<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Departement;
class Reunion extends Model
{
    use HasFactory;
    protected $primaryKey = 'idReunion';
    protected $fillable = [
        'idDepartement',
        'objectif',
        'titre',
        'description',
        'dateHeure',
        'heureFin',
        'type',
        'lien', 
        'lieu'
    ];

    protected $casts = [
        'dateHeure' => 'datetime',
    ];

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'idDepartement', 'idDepartement');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'reunion_participants', 'idReunion', 'idUser')->withTimestamps();
    }

    public function getTypeColorAttribute()
    {
        return match($this->type) {
            'Interne' => 'bg-slate-200 text-slate-700',
            'Externe' => 'bg-blue-100 text-blue-700',
            default => 'bg-[#b11d40]/10 text-[#b11d40]'
        };
    }
}
