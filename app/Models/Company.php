<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'companyGps',
        'companyEntryTime',
        'companyExitTime',
        'distance'
    ];
}
