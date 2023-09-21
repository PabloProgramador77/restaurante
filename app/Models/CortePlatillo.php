<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CortePlatillo extends Model
{
    use HasFactory;

    protected $table = 'corte_platillos';

    protected $fillable = [
        'idCorte',
        'idPedido'
    ];

    public function corte(){

        return $this->hasOne(Corte::class, 'id', 'idCorte');

    }

    public function pedidos(){

        return $this->belongToMany(Orden::class, 'corte_platillos', 'id', 'idPedido');

    }
}
