<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;
use App\Http\Requests\Roles\StoreRol;
use App\Http\Requests\Roles\EditRol;
use App\Http\Requests\Roles\UpdateRol;
use App\Http\Requests\Roles\DestroyRol;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            
            $roles = Rol::orderBy('name', 'asc')
                ->get();

            return view('roles/index', compact('roles'));

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
    public function store(StoreRol $request)
    {
        try {
            
            $rol = Rol::create([

                'name' => $request->rol,
                'guard_name' => 'web'

            ]);

            if( $rol->id ){

                $datos['exito'] = true;
                $datos['mensaje'] = 'Rol Agregado.';

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
     * @param  \App\Models\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function show(EditRol $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function edit(EditRol $request)
    {
        try {
            
            $rol = Rol::find($request->id);

            if( $rol->id ){

                $datos['exito'] = true;
                $datos['rol'] = $rol->name;

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
     * @param  \App\Models\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRol $request)
    {
        try {
            
            $rol = Rol::where('id', '=', $request->id)
                ->update([

                    'name' => $request->rol

                ]);

            $datos['exito'] = true;
            $datos['mensaje'] = 'Rol Actualizado.';

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rol  $rol
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyRol $request)
    {
        try {
            
            $rol = Rol::find($request->id);

            if( $rol->id ){

                $rol->delete();

                $datos['exito'] = true;
                $datos['mensaje'] = 'Rol Eliminado.';

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }
}
