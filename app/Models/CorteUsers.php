<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorteUsers extends Model
{
    use HasFactory;

    protected $table = 'corte_users';

    protected $fillable = [

        'idCorte',
        'idUser'

    ];

    public function cortes(){

        return $this->belongToMany(Corte::class, 'corte_users', 'id', 'idCorte');

    }

    public function users(){

        return $this->belongToMany(Users::class, 'corte_users', 'id', 'idUser');
        
    }
}
