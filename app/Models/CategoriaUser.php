<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaUser extends Model
{
    use HasFactory;

    protected $table = 'categoria_users';

    protected $fillable = [

        'idCategoria',
        'idUser'

    ];

    public function categorias(){

        return $this->belongToMany(Categoria::class, 'categoria_users', 'id', 'idCategoria');

    }

    public function users(){

        return $this->belongToMany(User::class, 'categoria_users', 'id', 'idUser');
        
    }
}
