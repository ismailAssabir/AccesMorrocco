<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PresentationItem;

class Category extends Model
{
    use HasFactory;
    protected $primaryKey = 'idCategory';
    protected $fillable = [
        'nom',
        'desc',
    ];
    function presentationItems(){
        return $this->hasMany(PresentationItem::class, 'idCategory', 'idCategory');
    }
}
