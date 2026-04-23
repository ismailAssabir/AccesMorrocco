<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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

    protected $casts = [
        'dateFin' => 'date',
        'dateDebut' => 'date',
    ];

    public function taches(){
        return $this->hasMany(Tache::class, 'idObjectif', 'idObjectif');
    }

    public function departement(){
        return $this->belongsTo(Departement::class, 'idDepartement', 'idDepartement');
    }

    /**
     * Get the status configuration (label and color)
     */
    public function getStatusConfigAttribute()
    {
        return match($this->status) {
            'atteint' => ['label' => 'Atteint', 'class' => 'bg-emerald-100 text-emerald-700'],
            'en_cours' => ['label' => 'En cours', 'class' => 'bg-blue-100 text-blue-700'],
            'echoue'   => ['label' => 'Échoué', 'class' => 'bg-red-100 text-red-700'],
            default    => ['label' => $this->status ?? 'À définir', 'class' => 'bg-gray-100 text-gray-700']
        };
    }

    /**
     * Calculate progress based on sub-tasks
     */
    public function getCalculatedProgressAttribute()
    {
        $total = $this->taches()->count();
        if ($total === 0) return $this->avancement ?? 0;
        
        $completed = $this->taches()->where('status', 'termine')->count();
        return round(($completed / $total) * 100);
    }
}
