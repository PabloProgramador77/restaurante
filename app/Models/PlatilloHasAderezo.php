<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatilloHasAderezo extends Model
{
    use HasFactory;

    protected $table = 'platillo_has_aderezos';

    protected $fillable = [
        'idPlatillo',
        'idAderezo',
    ];

    public function platillos(){

        return $this->belongsToMany( Platillo::class, 'platillo_has_aderezos', 'idPlatillo', 'idAderezo' );

    }

    public function aderezos(){

        return $this->belongsToMany( Aderezo::class, 'platillo_has_aderezos', 'idAderezo', 'idPlatillo' );
        
    }
}
