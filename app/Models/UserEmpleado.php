<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEmpleado extends Model
{
    use HasFactory;

    protected $table = 'user_empleados';

    protected $fillable = [

        'idUser',
        'idEmpleado'

    ];
}
