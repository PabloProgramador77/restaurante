<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatilloHasSabores extends Model
{
    use HasFactory;

    protected $table = 'platillo_has_sabores';

    protected $fillable = [

        'idPlatillo',
        'idSabor',

    ];
}
