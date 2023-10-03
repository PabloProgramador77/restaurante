<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Platillo;
use App\Models\Mesa;
use App\Models\MenuCategoria;
use App\Models\Orden;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categorias = Categoria::join('categoria_users', 'categorias.id', '=', 'categoria_users.idCategoria')
            ->where('categoria_users.idUser', '=', auth()->user()->id)
            ->get();

        $platillos = Platillo::join('platillo_users', 'platillos.id', '=', 'platillo_users.idPlatillo')
            ->where('platillo_users.idUser', '=', auth()->user()->id)
            ->get();

        $mesas = Mesa::join('mesa_users', 'mesas.id', '=', 'mesa_users.idMesa')
            ->where('mesa_users.idUser', '=', auth()->user()->id)
            ->get();

        $ordenes = Orden::join('mesa_users', 'ordens.idMesa', '=', 'mesa_users.idMesa')
            ->where('mesa_users.idUser', '=', auth()->user()->id)
            ->get();

        $ventas = 0;

        foreach($ordenes as $orden){

            $ventas += $orden->totalPedido;

        }

        //session()->put('idUser', auth()->user()->id);

        return view('index', compact('categorias', 'platillos', 'mesas', 'ordenes', 'ventas'));
    }

    /**
     * Mostrar el indice de videos
     * 
     */
    public function create(){
        try {
            
            if( auth()->user()->id ){

                return view('videos');

            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
