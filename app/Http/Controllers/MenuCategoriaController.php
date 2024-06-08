<?php

namespace App\Http\Controllers;

use App\Models\MenuCategoria;
use App\Models\Categoria;
use App\Models\Platillo;
use App\Models\Mesa;
use Illuminate\Http\Request;
use App\Http\Requests\Categorias\StoreMenu;

class MenuCategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( auth()->user()->hasRole('Gerente') || auth()->user()->hasRole('Supervisor') ){

            $categorias = Categoria::select('categorias.id', 'categorias.nombreCategoria')
                ->join('categoria_users', 'categorias.id', '=', 'categoria_users.idCategoria')
                ->where('categoria_users.idUser', '=', auth()->user()->id)
                ->orderBy('categorias.nombreCategoria', 'asc')
                ->get();

        }else{

            $categorias = Categoria::select('categorias.id', 'categorias.nombreCategoria')
                ->join('categoria_users', 'categorias.id', '=', 'categoria_users.idCategoria')
                ->join('user_empleados', 'categoria_users.idUser', '=', 'user_empleados.idUser')
                ->where('user_empleados.idEmpleado', '=', auth()->user()->id)
                ->orderBy('categorias.nombreCategoria', 'asc')
                ->get();

        }

        return view('menu', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($idCategoria)
    {
        $menu = Platillo::select('platillos.id', 'platillos.nombrePlatillo', 'platillos.precioPlatillo')
            ->join('menu_categorias', 'platillos.id', '=', 'menu_categorias.idPlatillo')
            ->where('menu_categorias.idCategoria', '=', $idCategoria)
            ->get();

        if( auth()->user()->hasRole('Gerente') ){

            $mesas = Mesa::select('mesas.id', 'mesas.nombreMesa')
                ->join('mesa_users', 'mesas.id', '=', 'mesa_users.idMesa')
                ->where('mesa_users.idUser', '=', auth()->user()->id)
                ->orderBy('mesas.nombreMesa', 'asc')
                ->get();

        }else{

            $mesas = Mesa::select('mesas.id', 'mesas.nombreMesa')
                ->join('mesa_users', 'mesas.id', '=', 'mesa_users.idMesa')
                ->join('user_empleados', 'mesa_users.idUser', '=', 'user_empleados.idUser')
                ->where('user_empleados.idEmpleado', '=', auth()->user()->id)
                ->orderBy('mesas.nombreMesa', 'asc')
                ->get();

        }

        return view('platillos', compact('menu', 'mesas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenu $request)
    {
        try {
            
            $platillos = MenuCategoria::select('*')
                ->where('idCategoria', '='. $request->idCategoria)
                ->get();

            foreach($platillos as $platillo){

                $platillo->delete();

            }

            foreach($request->platillos as $platillo){
                
                $menu = MenuCategoria::create([

                    'idCategoria' => $request->idCategoria,
                    'idPlatillo' => $platillo

                ]);

            }

            $datos['exito'] = true;
            $datos['mensaje'] = 'Platillos Agreados a Categoría.';

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MenuCategoria  $menuCategoria
     * @return \Illuminate\Http\Response
     */
    public function show(MenuCategoria $menuCategoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MenuCategoria  $menuCategoria
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuCategoria $menuCategoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MenuCategoria  $menuCategoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuCategoria $menuCategoria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MenuCategoria  $menuCategoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuCategoria $menuCategoria)
    {
        //
    }
}
