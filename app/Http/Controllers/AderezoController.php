<?php

namespace App\Http\Controllers;

use App\Models\Aderezo;
use App\Models\Platillo;
use Illuminate\Http\Request;
use App\Http\Requests\Aderezos\Create;
use App\Http\Requests\Aderezos\Read;
use App\Http\Requests\Aderezos\Update;
use App\Http\Requests\Aderezos\Delete;

class AderezoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            
            if( auth()->user()->id ){

                if( auth()->user()->hasRole('Gerente') ){

                    $aderezos = Aderezo::where('idUser', '=', auth()->user()->id)
                                ->orderBy('created_at', 'desc')
                                ->get();

                    $platillos = Platillo::select('platillos.id', 'platillos.nombrePlatillo', 'platillos.precioPlatillo')
                                ->join('platillo_users', 'platillos.id', '=', 'platillo_users.idPlatillo')
                                ->where('platillo_users.idUser', '=', auth()->user()->id)
                                ->orderBy('platillos.updated_at', 'desc')
                                ->get();

                }else{

                    $aderezos = Adereoz::where('idUser', '=', session()->get('idGerente'))
                                ->orderBy('created_at', 'desc')
                                ->get();

                    $platillos = Platillo::select('platillos.id', 'platillos.nombrePlatillo', 'platillos.precioPlatillo')
                                ->join('platillo_users', 'platillos.id', '=', 'platillo_users.idPlatillo')
                                ->join('user_empleados', 'platillo_users.idUser', '=', 'user_empleados.idUser')
                                ->where('user_empleados.idEmpleado', '=', auth()->user()->id)
                                ->orderBy('platillos.updated_at', 'desc')
                                ->get();

                }

                return view('aderezos.index', compact('aderezos', 'platillos'));

            }else{

                return redirect('/');

            }

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

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
    public function store(Create $request)
    {
        try {
            
            if( auth()->user()->hasRole('Gerente') ){

                $aderezo = Aderezo::create([

                    'nombre' => $request->aderezo,
                    'descripcion' => $request->descripcion,
                    'idUser' => auth()->user()->id,
    
                ]);

            }else{

                $aderezo = Aderezo::create([

                    'nombre' => $request->aderezo,
                    'descripcion' => $request->descripcion,
                    'idUser' => session()->get('idGerente'),

                ]);

            }
            
            if( $aderezo->id ){

                $datos['exito'] = true;
                $datos['mensaje'] = 'Aderezo registrado';

            }else{

                $datos['exito'] = false;
                $datos['mensaje'] = 'Aderezo no registrado';

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Aderezo  $aderezo
     * @return \Illuminate\Http\Response
     */
    public function show(Read $request)
    {
        try {
            
            $aderezo = Aderezo::find( $request->id );

            if( $aderezo->id ){

                $datos['exito'] = true;
                $datos['aderezo'] = $aderezo->nombre;
                $datos['descripcion']= $aderezo->descripcion;
                $datos['platillos'] = Platillo::select('platillos.id', 'platillos.nombrePlatillo')
                                    ->join('platillo_has_aderezos', 'platillos.id', '=', 'platillo_has_aderezos.idPlatillo')
                                    ->where('platillo_has_aderezos.idAderezo', '=', $aderezo->id)
                                    ->get();

            }else{

                $datos['exito'] = false;
                $datos['mensaje'] = 'Aderezo no encontrado';

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aderezo  $aderezo
     * @return \Illuminate\Http\Response
     */
    public function edit(Aderezo $aderezo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Aderezo  $aderezo
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request)
    {
        try {
            
            $aderezo = Aderezo::where('id', '=', $request->id )
                    ->update([

                        'nombre' => $request->aderezo,
                        'descripcion' => $request->descripcion,

            ]);

            $datos['exito'] = true;
            $datos['mensaje'] = 'Aderezo actualizado';

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aderezo  $aderezo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delete $request)
    {
        try {
            
            $aderezo = Aderezo::find( $request->id );

            if( $aderezo->id ){

                $aderezo->delete();

                $datos['exito'] = true;
                $datos['mensaje'] = 'Aderezo eliminado';

            }else{

                $datos['exito'] = false;
                $datos['mensaje'] = 'Aderezo no encontrado';

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
