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
        $categorias = Categoria::all();
        $platillos = Platillo::all();
        $mesas = Mesa::all();
        $ordenes = Orden::all();

        $ventas = 0;

        foreach($ordenes as $orden){

            $ventas += $orden->totalPedido;

        }

        //session()->put('idUser', auth()->user()->id);

        return view('index', compact('categorias', 'platillos', 'mesas', 'ordenes', 'ventas'));
    }
}
