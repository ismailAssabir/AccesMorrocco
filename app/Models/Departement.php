<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Lead;

class Departement extends Model
{
    use HasFactory;
    use HasFactory;
    protected $primaryKey= 'idDepartement';
    protected $fillable = [
        'title',
        'description',
        'idUser',
    ];
    function employes(){
       return $this->hasMany(User::class, 'idDepartement', 'idDepartement');
    }
    function manager(){
        return $this->belongsTo(User::class, 'idUser', 'idUser');
    }
    function leads(){
        return $this->hasMany(Lead::class, 'IdDepartement','idDepartement');
    }
    function reunions(){
        return $this->hasMany(Reunion::class, 'idDepartement', 'idDepartement');
    }
    function dossiers(){
        return $this->hasMany(Dossier::class, 'idDepartement', 'idDepartement');
    }
}
