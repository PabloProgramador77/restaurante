<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatilloUsers extends Model
{
    use HasFactory;

    protected $table = 'platillo_users';

    protected $fillable = [
        
        'idPlatillo',
        'idUser'

    ];

    public function platillos(){

        return $this->belongToMany(Platillo::class, 'platillo_users', 'id', 'idPlatillo');

    }

    public function users(){

        return $this->belongToMany(User::class, 'platillo_users', 'id', 'idUser');

    }
    
}
