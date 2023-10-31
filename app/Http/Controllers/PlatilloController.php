<?php

namespace App\Http\Controllers;

use App\Models\Platillo;
use App\Models\Categoria;
use App\Models\PlatilloUsers;
use Illuminate\Http\Request;
use App\Http\Requests\Platillos\StorePlatillo;
use App\Http\Requests\Platillos\EditPlatillo;
use App\Http\Requests\Platillos\UpdatePlatillo;
use App\Http\Requests\Platillos\DestroyPlatillo;

class PlatilloController extends Controller
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

                $platillos = Platillo::select('platillos.id', 'platillos.nombrePlatillo', 'platillos.precioPlatillo')
                ->join('platillo_users', 'platillos.id', '=', 'platillo_users.idPlatillo')
                ->where('platillo_users.idUser', '=', auth()->user()->id)
                ->orderBy('platillos.updated_at', 'desc')
                ->get();

                $categorias = Categoria::select('categorias.id', 'categorias.nombreCategoria')
                    ->join('categoria_users', 'categorias.id', '=', 'categoria_users.idCategoria')
                    ->where('categoria_users.idUser', '=', auth()->user()->id)
                    ->orderBy('categorias.nombreCategoria', 'asc')
                    ->get();

            }else{

                $platillos = Platillo::select('platillos.id', 'platillos.nombrePlatillo', 'platillos.precioPlatillo')
                    ->join('platillo_users', 'platillos.id', '=', 'platillo_users.idPlatillo')
                    ->join('user_empleados', 'platillo_users.idUser', '=', 'user_empleados.idUser')
                    ->where('user_empleados.idEmpleado', '=', auth()->user()->id)
                    ->orderBy('platillos.updated_at', 'desc')
                    ->get();

                $categorias = Categoria::select('categorias.id', 'categorias.nombreCategoria')
                    ->join('categoria_users', 'categorias.id', '=', 'categoria_users.idCategoria')
                    ->join('user_empleados', 'categoria_users.idUser', '=', 'user_empleados.idUser')
                    ->where('user_empleados.idEmpleado', '=', auth()->user()->id)
                    ->orderBy('categorias.nombreCategoria', 'asc')
                    ->get();

            }

            return view('platillos/index', compact('platillos', 'categorias'));

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
    public function store(StorePlatillo $request)
    {
        try {
            
            $platillo = Platillo::create([

                'nombrePlatillo' => $request->platillo,
                'precioPlatillo' => $request->precio

            ]);

            if( $platillo->id ){

                $platilloUser = PlatilloUsers::create([

                    'idPlatillo' => $platillo->id,
                    'idUser' => auth()->user()->id

                ]);

                if( $platilloUser->id ){

                    $datos['exito'] = true;
                    $datos['mensaje'] = 'Platillo Agregado.';

                }else{

                    $platillo->delete();

                    $datos['exito'] = false;
                    $datos['mensaje'] = 'Registro interrumpido. Intenta de nuevo.';

                }

            }else{

                $datos['exito'] = false;
                $datos['mensaje'] = 'Registro interrumpido. Intenta de nuevo.';

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
     * @param  \App\Models\Platillo  $platillo
     * @return \Illuminate\Http\Response
     */
    public function show(Platillo $platillo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Platillo  $platillo
     * @return \Illuminate\Http\Response
     */
    public function edit(EditPlatillo $request)
    {
        try {
            
            $platillo = Platillo::find($request->id);

            if( $platillo->id ){

                $datos['exito'] = true;
                $datos['nombre'] = $platillo->nombrePlatillo;
                $datos['precio'] = $platillo->precioPlatillo;

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
     * @param  \App\Models\Platillo  $platillo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlatillo $request)
    {
        try {
            
            $platillo = Platillo::where('id', '=', $request->id)
                ->update([

                    'nombrePlatillo' => $request->platillo,
                    'precioPlatillo' => $request->precio

                ]);

            $datos['exito'] = true;
            $datos['mensaje'] = 'Platillo Actualizado.';

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Platillo  $platillo
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyPlatillo $request)
    {
        try {
            
            $platillo = Platillo::find($request->id);

            $platillo->delete();

            $datos['exito'] = true;
            $datos['mensaje'] = 'Platillo Eliminado.';

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }
}
