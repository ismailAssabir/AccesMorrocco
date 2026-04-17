<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $primaryKey = 'idClient';
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'adress',
        'CNE', 
        'phoneNumber',
        'nationalite',
        'dateNaissance',
        'status',
        'type',
        'created_at',
        'updated_at',
    ];
}
