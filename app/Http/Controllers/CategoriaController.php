<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Platillo;
use App\Models\CategoriaUser;
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
            
            if( auth()->user()->role() == 'Gerente' ){

                $categorias = Categoria::select('categorias.id', 'categorias.nombreCategoria')
                    ->join('categoria_users', 'categorias.id', '=', 'categoria_users.idCategoria')
                    ->where('categoria_users.idUser', '=', auth()->user()->id)
                    ->get();

                $platillos = Platillo::select('platillos.id', 'platillos.nombrePlatillo')
                    ->join('platillo_users', 'platillos.id', '=', 'platillo_users.idPlatillo')
                    ->where('platillo_users.idUser', '=', auth()->user()->id)
                    ->orderBy('platillos.nombrePlatillo', 'asc')
                    ->get();

            }else{

                $categorias = Categoria::select('categorias.id', 'categorias.nombreCategoria')
                    ->join('categoria_users', 'categorias.id', '=', 'categoria_users.idCategoria')
                    ->join('user_empleados', 'categoria_users.idUser', '=', 'user_empleados.idUser')
                    ->where('user_empleados.idEmpleado', '=', auth()->user()->id)
                    ->get();

                $platillos = Platillo::select('platillos.id', 'platillos.nombrePlatillo')
                    ->join('platillo_users', 'platillos.id', '=', 'platillo_users.idPlatillo')
                    ->join('user_empleados', 'platillo_users.idUser', '=', 'user_empleados.idUser')
                    ->where('user_empleados.idEmpleado', '=', auth()->user()->id)
                    ->orderBy('platillos.nombrePlatillo', 'asc')
                    ->get();

            }

            return view('categorias/index', compact('categorias', 'platillos'));

        }catch(QueryException $qe){

            echo "Fatal Error: ".$th->getMessage();

        }catch (\Throwable $th) {

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

                $categoriaUser = CategoriaUser::create([

                    'idCategoria' => $categoria->id,
                    'idUser' => auth()->user()->id

                ]);

                if( $categoriaUser->id ){

                    $datos['exito'] = true;
                    $datos['mensaje'] = 'Categoría Agregada.';
                    
                }

            }else{

                $datos['exito'] = false;
                
            }

        } catch (QueryException $qe) {

            $datos['exito'] = false;
            $datos['mensaje'] = $qe->getMessage();

        }catch(\Throwable $th){

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
        
        }catch(QueryException $qe){

            $datos['exito'] = false;
            $datos['mensaje'] = $qe->getMessage();

        }catch (\Throwable $th) {

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
        
        }catch(QueryException $qe){

            $datos['exito'] = false;
            $datos['mensaje'] = $qe->getMessage();

        }catch (\Throwable $th) {
            
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
            
        }catch(QueryException $qe){

            $datos['exito'] = false;
            $datos['mensaje'] = $qe->getMessage();

        }catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }
}
