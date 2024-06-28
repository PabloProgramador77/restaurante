<?php

namespace App\Http\Controllers;

use App\Models\OrdenPlatillo;
use Illuminate\Http\Request;
use App\Http\Requests\OrdenPlatillo\StoreOrdenPlatillo;
use App\Http\Requests\OrdenPlatillo\Delete;

class OrdenPlatilloController extends Controller
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
    public function store(StoreOrdenPlatillo $request)
    {
        try {

            $nota = '';

            if( is_array( $request->sabores ) && count( $request->sabores ) > 0 ){

                foreach( $request->sabores as $sabor){

                    $nota .= $sabor.', ';

                }

            }
            
            $platillo = OrdenPlatillo::create([

                'idOrden' => session()->get('idOrden'),
                'idPlatillo' => $request->idPlatillo,
                'cantidad' => $request->cantidad,
                'nota' => $request->nota.', '.$nota,

            ]);

            if( $platillo->id ){

                $datos['exito'] = true;
                $datos['mensaje'] = 'Platillo Agregado a Orden.';

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
     * @param  \App\Models\OrdenPlatillo  $ordenPlatillo
     * @return \Illuminate\Http\Response
     */
    public function show(OrdenPlatillo $ordenPlatillo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrdenPlatillo  $ordenPlatillo
     * @return \Illuminate\Http\Response
     */
    public function edit(OrdenPlatillo $ordenPlatillo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrdenPlatillo  $ordenPlatillo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrdenPlatillo $ordenPlatillo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrdenPlatillo  $ordenPlatillo
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        try {
            
            $ordenPlatillo = OrdenPlatillo::find( $id );

            if( $ordenPlatillo->id ){

                $ordenPlatillo->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }

        return redirect('/menu');

    }
}
