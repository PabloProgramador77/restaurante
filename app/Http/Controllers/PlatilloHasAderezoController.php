<?php

namespace App\Http\Controllers;

use App\Models\PlatilloHasAderezo;
use Illuminate\Http\Request;
use App\Http\Requests\Aderezos\Assign;

class PlatilloHasAderezoController extends Controller
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
    public function store(Assign $request)
    {
        try {
            
            $platillos = PlatilloHasAderezo::where('idAderezo', '=', $request->aderezo)
                        ->get();

            if( count( $platillos) > 0 ){

                foreach( $platillos as $platillo){

                    $platillo->delete();

                }

                foreach( $request->platillos as $platillo ){

                    $platilloHasAderezo = PlatilloHasAderezo::create([
    
                        'idPlatillo' => $platillo,
                        'idAderezo' => $request->aderezo,
    
                    ]);
    
                }

                $datos['exito'] = true;
                $datos['mensaje'] = 'Aderezo asignado.';

            }else{

                foreach( $request->platillos as $platillo ){

                    $platilloHasAderezo = PlatilloHasAderezo::create([
    
                        'idPlatillo' => $platillo,
                        'idAderezo' => $request->aderezo,
    
                    ]);
    
                }

                $datos['exito'] = true;
                $datos['mensaje'] = 'Aderezo asignado.';

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
     * @param  \App\Models\PlatilloHasAderezo  $platilloHasAderezo
     * @return \Illuminate\Http\Response
     */
    public function show(PlatilloHasAderezo $platilloHasAderezo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PlatilloHasAderezo  $platilloHasAderezo
     * @return \Illuminate\Http\Response
     */
    public function edit(PlatilloHasAderezo $platilloHasAderezo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PlatilloHasAderezo  $platilloHasAderezo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlatilloHasAderezo $platilloHasAderezo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PlatilloHasAderezo  $platilloHasAderezo
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlatilloHasAderezo $platilloHasAderezo)
    {
        //
    }
}
