<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Departement extends Model
{
    use HasFactory;
    protected $primaryKey= 'idDepartement';
    protected $fillable = [
        'title',
        'description',
        'idUser',
        'created_at',
        'updated_at',
    ];
    function employes(){
        $this->hasMany(User::class, 'idDepartement');
    }
    function manager(){
        $this->belongsTo(User::class, 'idUser');
    }
}
