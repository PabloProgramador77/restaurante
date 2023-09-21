<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;

    protected $table = 'ordens';

    protected $fillable = [

        'totalPedido',
        'estadoPedido',
        'idMesa'

    ];

    public function mesa(){

        return $this->hasOne(Mesa::class, 'id', 'idMesa');
        
    }
}
