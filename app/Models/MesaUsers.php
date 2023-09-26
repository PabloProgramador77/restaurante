<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MesaUsers extends Model
{
    use HasFactory;

    protected $table = 'mesa_users';

    protected $fillable = [

        'idMesa',
        'idUser'

    ];

    public function mesas(){

        return $this->belongToMany(Mesa::class, 'mesa_users', 'id', 'idMesa');

    }

    public function users(){

        return $this->belongToMany(Users::class, 'mesa_users', 'id', 'idUser');
        
    }
}
