<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenPlatillo extends Model
{
    use HasFactory;

    protected $table = 'orden_platillos';

    protected $fillable = [
        
        'idOrden',
        'idPlatillo',
        'cantidad',
        'nota'

    ];

    public function orden(){

        return $this->hasOne(Orden::class, 'id', 'idOrden');

    }

    public function platillos(){

        return $this->belongToMany(Platillo::class, 'orden_platillos', 'id', 'idPlatillo');
        
    }
}
