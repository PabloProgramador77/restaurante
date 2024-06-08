<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use App\Models\MesaUsers;
use Illuminate\Http\Request;
use App\Http\Requests\Mesas\StoreMesa;
use App\Http\Requests\Mesas\EditMesa;
use App\Http\Requests\Mesas\UpdateMesa;
use App\Http\Requests\Mesas\DestroyMesa;

class MesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            
            if( auth()->user()->hasRole('Gerente') || auth()->user()->hasRole('Supervisor') ){

                $mesas = Mesa::select('mesas.id', 'mesas.nombreMesa')
                    ->join('mesa_users', 'mesas.id', '=', 'mesa_users.idMesa')
                    ->where('mesa_users.idUser', '=', auth()->user()->id)
                    ->orderBy('mesas.updated_at', 'desc')
                    ->get();

            }else{

                $mesas = Mesa::select('mesas.id', 'mesas.nombreMesa')
                    ->join('mesa_users', 'mesas.id', '=', 'mesa_users.idMesa')
                    ->join('user_empleados', 'mesa_users.idUser', '=', 'user_empleados.idUser')
                    ->where('user_empleados.idEmpleado', '=', auth()->user()->id)
                    ->orderBy('mesas.updated_at', 'desc')
                    ->get();

            }

            return view('mesas/index', compact('mesas'));

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
    public function store(StoreMesa $request)
    {
        try {
            
            $mesa = Mesa::create([

                'nombreMesa' => $request->mesa,
                'estadoMesa' => 'Disponible'

            ]);

            if( $mesa->id ){

                $mesaUser = MesaUsers::create([

                    'idMesa' => $mesa->id,
                    'idUser' => auth()->user()->id

                ]);

                if( $mesaUser->id ){

                    $datos['exito'] = true;
                    $datos['mensaje'] = 'Mesa Agregada.';

                }else{

                    $mesa->delete();

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
     * @param  \App\Models\Mesa  $mesa
     * @return \Illuminate\Http\Response
     */
    public function show(Mesa $mesa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mesa  $mesa
     * @return \Illuminate\Http\Response
     */
    public function edit(EditMesa $request)
    {
        try {
            
            $mesa = Mesa::where('id', '=', $request->id)->first();

            if( $mesa->id ){

                $datos['exito'] = true;
                $datos['mensaje']  = $mesa->nombreMesa;

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
     * @param  \App\Models\Mesa  $mesa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMesa $request)
    {
        try {
            
            $mesa = Mesa::where('id', '=', $request->id)
                ->update([

                    'nombreMesa' => $request->mesa

                ]);

            $datos['exito'] = true;
            $datos['mensaje'] = 'Mesa Actualizada.';

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mesa  $mesa
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyMesa $request)
    {
        try {
            
            $mesa = Mesa::find($request->id);

            $mesa->delete();

            $datos['exito'] = true;
            $datos['mensaje'] = 'Mesa Eliminada.';

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }
}
