<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Platillo;
use Illuminate\Http\Request;
use App\Http\Requests\Categorias\StoreCategoria;
use App\Http\Requests\Categorias\EditCategoria;
use App\Http\Requests\Categorias\UpdateCategoria;
use App\Http\Requests\Categorias\DestroyCategoria;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            
            $categorias = Categoria::select('*')
                ->orderBy('updated_at', 'desc')
                ->get();

            $platillos = Platillo::select('*')
                ->orderBy('nombrePlatillo', 'asc')
                ->get();

            return view('categorias/index', compact('categorias', 'platillos'));

        } catch (\Throwable $th) {

            echo "Fatal Error: ".$th->getMessage();

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoria $request)
    {
        try {
            
            $categoria = Categoria::create([

                'nombreCategoria' => $request->categoria

            ]);

            if( $categoria->id ){

                $datos = Categoria::select('*')
                    ->orderBy('updated_at', 'desc')
                    ->get();

                $datos['exito'] = true;
                $datos['mensaje'] = 'Categoría Agregada.';

            }

        } catch (\Throwable $th) {

            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit(EditCategoria $request)
    {
        try {
            
            $categoria = Categoria::where('id', '=', $request->id)->first();

            if( $categoria->id ){

                $datos['exito'] = true;
                $datos['mensaje']  = $categoria->nombreCategoria;

            }

        } catch (\Throwable $th) {

            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoria $request)
    {
        try {
            
            $categoria = Categoria::where('id', '=', $request->id)
                ->update([

                    'nombreCategoria' => $request->categoria

                ]);

            $datos['exito'] = true;
            $datos['mensaje'] = 'Categoría Actualizada.';

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyCategoria $request)
    {
        try {
            
            $categoria = Categoria::find($request->id);

            $categoria->delete();

            $datos['exito'] = true;
            $datos['mensaje'] = 'Categoría Eliminada.';

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }
}
