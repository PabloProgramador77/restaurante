<?php

namespace App\Http\Controllers;

use App\Models\PlatilloHasSabores;
use Illuminate\Http\Request;
use App\Http\Requests\PlatilloHasSabores\Create;

class PlatilloHasSaboresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store( Create $request )
    {
        try {
            
            $platillos = PlatilloHasSabores::where('idSabor', '=', $request->sabor)
                        ->get();

            if( count( $platillos) > 0 ){

                foreach( $platillos as $platillo){

                    $platillo->delete();

                }

                foreach( $request->platillos as $platillo ){

                    $platilloHasSabores = PlatilloHasSabores::create([
    
                        'idPlatillo' => $platillo,
                        'idSabor' => $request->sabor,
    
                    ]);
    
                }

                $datos['exito'] = true;
                $datos['mensaje'] = 'Sabor asignado.';

            }else{

                foreach( $request->platillos as $platillo ){

                    $platilloHasSabores = PlatilloHasSabores::create([
    
                        'idPlatillo' => $platillo,
                        'idSabor' => $request->sabor,
    
                    ]);
    
                }

                $datos['exito'] = true;
                $datos['mensaje'] = 'Sabor asignado.';

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
     * @param  \App\Models\PlatilloHasSabores  $platilloHasSabores
     * @return \Illuminate\Http\Response
     */
    public function show(PlatilloHasSabores $platilloHasSabores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PlatilloHasSabores  $platilloHasSabores
     * @return \Illuminate\Http\Response
     */
    public function edit(PlatilloHasSabores $platilloHasSabores)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PlatilloHasSabores  $platilloHasSabores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlatilloHasSabores $platilloHasSabores)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PlatilloHasSabores  $platilloHasSabores
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlatilloHasSabores $platilloHasSabores)
    {
        //
    }
}
