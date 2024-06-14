<?php

namespace App\Http\Controllers;

use App\Models\Sabor;
use App\Models\Platillo;
use Illuminate\Http\Request;
use App\Http\Requests\Sabores\Create;
use App\Http\Requests\Sabores\Read;
use App\Http\Requests\Sabores\Update;
use App\Http\Requests\Sabores\Delete;

class SaborController extends Controller
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

                    $sabores = Sabor::where('idUser', '=', auth()->user()->id)
                                ->orderBy('created_at', 'desc')
                                ->get();

                    $platillos = Platillo::select('platillos.id', 'platillos.nombrePlatillo', 'platillos.precioPlatillo')
                                ->join('platillo_users', 'platillos.id', '=', 'platillo_users.idPlatillo')
                                ->where('platillo_users.idUser', '=', auth()->user()->id)
                                ->orderBy('platillos.updated_at', 'desc')
                                ->get();

                }else{

                    $sabores = Sabor::where('idUser', '=', session()->get('idGerente'))
                                ->orderBy('created_at', 'desc')
                                ->get();

                    $platillos = Platillo::select('platillos.id', 'platillos.nombrePlatillo', 'platillos.precioPlatillo')
                                ->join('platillo_users', 'platillos.id', '=', 'platillo_users.idPlatillo')
                                ->join('user_empleados', 'platillo_users.idUser', '=', 'user_empleados.idUser')
                                ->where('user_empleados.idEmpleado', '=', auth()->user()->id)
                                ->orderBy('platillos.updated_at', 'desc')
                                ->get();

                }

                return view('sabores.index', compact('sabores', 'platillos'));

            }else{

                return redirect('/');

            }

        } catch (\Throwable $th) {
            
            echo $th-> getMessage();

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

                $sabor = Sabor::create([

                    'nombre' => $request->sabor,
                    'descripcion' => $request->descripcion,
                    'idUser' => auth()->user()->id,
    
                ]);

            }else{

                $sabor = Sabor::create([

                    'nombre' => $request->sabor,
                    'descripcion' => $request->descripcion,
                    'idUser' => session()->get('idGerente'),

                ]);

            }
            
            if( $sabor->id ){

                $datos['exito'] = true;
                $datos['mensaje'] = 'Sabor registrado';

            }else{

                $datos['exito'] = false;
                $datos['mensaje'] = 'Sabor no registrado';

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
     * @param  \App\Models\Sabor  $sabor
     * @return \Illuminate\Http\Response
     */
    public function show(Read $request)
    {
        try {
            
            $sabor = Sabor::find( $request->id );

            if( $sabor->id ){

                $datos['exito'] = true;
                $datos['sabor'] = $sabor->nombre;
                $datos['descripcion']= $sabor->descripcion;

            }else{

                $datos['exito'] = false;
                $datos['mensaje'] = 'Sabor no encontrado';

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
     * @param  \App\Models\Sabor  $sabor
     * @return \Illuminate\Http\Response
     */
    public function edit(Sabor $sabor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sabor  $sabor
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request)
    {
        try {
            
            $sabor = Sabor::where('id', '=', $request->id )
                    ->update([

                        'nombre' => $request->sabor,
                        'descripcion' => $request->descripcion,

            ]);

            $datos['exito'] = true;
            $datos['mensaje'] = 'Sabor actualizado';

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sabor  $sabor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delete $request)
    {
        try {
            
            $sabor = Sabor::find( $request->id );

            if( $sabor->id ){

                $sabor->delete();

                $datos['exito'] = true;
                $datos['mensaje'] = 'Sabor eliminado';

            }else{

                $datos['exito'] = false;
                $datos['mensaje'] = 'Sabor no encontrado';

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
