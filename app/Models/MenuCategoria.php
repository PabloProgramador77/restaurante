<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuCategoria extends Model
{
    use HasFactory;

    protected $table = 'menu_categorias';

    protected $fillable = [

        'idCategoria',
        'idPlatillo'

    ];

    public function platillos(){

        return $this->belongToMany(Platillo::class, 'platillos', 'id', 'idPlatillo');
        
    }
}
