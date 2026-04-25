<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Prime;
class Tache extends Model
{
    use HasFactory;
    protected $primaryKey = 'idTache';
    protected $fillable=[
        'idObjectif',
        'idDepartement',
        'titre',
        'dateDebut',
        'duree',
        'typeDuree',
        'heureDebut',
        'priorite',
        'status',
        'description'
    ];
    protected $casts = [
        'dateDebut' => 'datetime',
        'duree' => 'datetime',
    ];

    public function getFormattedDurationAttribute()
    {
        if (!$this->dateDebut || !$this->duree) {
            return 'N/A';
        }

        $start = $this->dateDebut;
        $end = $this->duree;

        if ($start->equalTo($end)) {
            return 'Short Task';
        }

        $totalMinutes = $start->diffInMinutes($end);

        // Scenario A: More than 24 hours (Multiple Days)
        if ($totalMinutes >= 1440) {
            $days = floor($totalMinutes / 1440);
            $remainingMinutes = $totalMinutes % 1440;
            $hours = floor($remainingMinutes / 60);
            
            return $hours > 0 ? "{$days}j {$hours}h" : "{$days} " . ($days > 1 ? 'Jours' : 'Jour');
        }

        // Scenario B: Less than 24 hours (Hours/Minutes)
        if ($totalMinutes < 60) {
            return $totalMinutes . ' min';
        }

        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;

        return $minutes > 0 ? "{$hours}h {$minutes}min" : "{$hours}h";
    }

    public function getPriorityConfigAttribute()
    {
        $configs = [
            'haute' => ['border' => 'bg-red-500', 'bg' => 'bg-red-50', 'text' => 'text-red-700', 'label' => 'HAUTE'],
            'moyenne' => ['border' => 'bg-amber-500', 'bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'label' => 'MOYENNE'],
            'basse' => ['border' => 'bg-emerald-500', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'label' => 'BASSE'],
        ];

        return $configs[$this->priorite] ?? $configs['moyenne'];
    }

    public function getIsOverdueAttribute()
    {
        return $this->duree && $this->duree->isPast() && $this->status !== 'termine';
    }

    function departement(){
        return $this->belongsTo(Departement::class, 'idDepartement', 'idDepartement');
    }
    function objectif(){
        return $this->belongsTo(Objectif::class, 'idObjectif', 'idObjectif');
    }
    function users(){
        return $this->belongsToMany(User::class, 'user_taches', 'idTache', 'idUser');
    }
    function primes(){
        return $this->hasMany(Prime::class, 'idTache', 'idTache');
    }
}
