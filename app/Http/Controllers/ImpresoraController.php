<?php

namespace App\Http\Controllers;

use App\Models\Impresora;
use Illuminate\Http\Request;
use App\Http\Requests\Impresora\Create;
use App\Http\Requests\Impresora\Read;
use App\Http\Requests\Impresora\Update;
use App\Http\Requests\Impresora\Delete;

class ImpresoraController extends Controller
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

                $impresoras = Impresora::all();

                return view('impresoras.index', compact('impresoras'));

            }else{

                return redirect('/');

            }

        } catch (\Throwable $th) {
            
            return redirect('/');

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
            
            $impresora = Impresora::create([

                'seriePrint' => $request->impresora,
                'tipoImpresion' => $request->funcion,

            ]);

            $datos['exito'] = true;

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Impresora  $impresora
     * @return \Illuminate\Http\Response
     */
    public function show(Read $request)
    {
        try {
            
            $impresora = Impresora::find( $request->id );

            if( $impresora->id ){

                $datos['exito'] = true;
                $datos['impresora'] = $impresora->seriePrint;
                $datos['funcion'] = $impresora->tipoImpresion;
                $datos['id'] = $impresora->id;

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
     * @param  \App\Models\Impresora  $impresora
     * @return \Illuminate\Http\Response
     */
    public function edit(Impresora $impresora)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Impresora  $impresora
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request)
    {
        try {
            
            $impresora = Impresora::where('id', '=', $request->id )
                        ->update([

                            'seriePrint' => $request->impresora,
                            'tipoImpresion' => $request->funcion,

            ]);
            
            $datos['exito'] = true;

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Impresora  $impresora
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delete $request)
    {
        try {

            $impresora = Impresora::find( $request->id );

            if( $impresora->id ){

                $impresora->delete();

                $datos['exito'] = true;

            }
            
        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
