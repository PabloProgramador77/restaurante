<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Permisos\StorePermiso;
use App\Http\Requests\Permisos\EditPermiso;
use App\Http\Requests\Permisos\UpdatePermiso;
use App\Http\Requests\Permisos\DestroyPermiso;

class PermisoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            
            $permisos = Permission::orderBy('name', 'asc')
                ->get();

            return view('permisos/index', compact('permisos'));

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
    public function store(StorePermiso $request)
    {
        try {
            
            $permiso = Permission::create([

                'name' => $request->permiso,
                'guard_name' => 'web'

            ]);

            if( $permiso->id ){

                $datos['exito'] = true;
                $datos['mensaje'] = 'Permiso Registrado.';

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(EditPermiso $request)
    {
        try {
            
            $permiso = Permission::find($request->id);

            if( $permiso->id ){

                $datos['exito'] = true;
                $datos['permiso'] = $permiso->name;

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermiso $request)
    {
        try {
            
            $permiso = Permission::where('id', '=', $request->id)
                ->update([

                    'name' => $request->permiso

                ]);

            $datos['exito'] = true;
            $datos['mensaje'] = 'Permiso Actualizado.';

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyPermiso $request)
    {
        try {
            
            $permiso = Permission::find($request->id);

            if( $permiso->id ){

                $permiso->delete();

                $datos['exito'] = true;
                $datos['mensaje'] = 'Permiso Eliminado.';

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }
}
