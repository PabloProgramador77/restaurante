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
        $categorias = Categoria::all();

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

        $mesas = Mesa::all();

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
