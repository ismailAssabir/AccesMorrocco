<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
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
        'created_at',
        'updated_at',
        'idUser',
        'idClient',
        'idDepartement'
    ];
}
