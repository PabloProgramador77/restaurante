<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aderezo extends Model
{
    use HasFactory;

    protected $table = 'aderezos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'idUser',
    ];

    public function platillos(){

        return $this->belongsToMany( Platillo::class, 'platillo_has_aderezos', 'idPlatillo', 'idAderezo' );
        
    }
}
