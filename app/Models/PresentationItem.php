<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Presentation;

class PresentationItem extends Model
{
    use HasFactory;
    protected $primaryKey='idItems';
    protected $fillable = [
        'idPresentation',
        'idCategory',
        'prixUnitaire',
        'quantity',
        'totale'
    ];
    function category(){
        return $this->belongsTo(Category::class, 'idCategory', 'idCategory');
    }
    function presentation(){
        return $this->belongsTo(Presentation::class, 'idPresentation', 'idPresentation');
    }
}
