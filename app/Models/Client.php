<?php

namespace App\Models;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
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
    ];
    function lead(){
        return $this->hasOne(Lead::class, 'idClient');
    }
}
