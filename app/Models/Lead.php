<?php

namespace App\Models;
use App\Models\User;
use App\Models\Departement;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;
    protected $primaryKey = 'idLead';
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'adress',
        'CNE', 
        'phoneNumber',
        'nationalite',
        'dateCreation',
        'source',
        'note',
        'type',
        'idUser',
        'idClient',
        'idDepartement'
    ];
    function client(){
        return $this->belongsTo(User::class, 'idUser', 'idClient');
    }
     function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'idUser'); 
    }
    function departements(){
        return $this->belongsTo(Departement::class, 'idDepartement', 'idDepartement');
    }
}
