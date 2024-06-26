<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impresora extends Model
{
    use HasFactory;

    protected $table = 'impresoras';

    protected $fillable = [

        'seriePrint',
        'tipoImpresion',
        'idUser',

    ];

    public function user(){

        return $this->hasOne( User::class, 'id', 'idUser' );
        
    }
    
}
