<?php

namespace App\Http\Controllers;

use App\Models\Impresora;
use Illuminate\Http\Request;
use App\Http\Requests\Impresora\Create;
use App\Http\Requests\Impresora\Read;
use App\Http\Requests\Impresora\Update;
use App\Http\Requests\Impresora\Delete;
use App\Http\Requests\Impresora\Test;
use GuzzleHttp\Client;

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

                if( auth()->user()->hasRole('Gerente') ){

                    $impresoras = Impresora::where('idUser', '=', auth()->user()->id)->get();

                }else{

                    $impresoras = Impresora::select('impresoras.id', 'impresoras.seriePrint', 'impresoras.tipoImpresion')
                                ->join('user_empleados', 'impresoras.idUser', '=', 'user_empleados.idUser')
                                ->where('user_empleados.idEmpleado', '=', auth()->user()->id)
                                ->where('impresoras.tipoImpresion', 'LIKE', '%Comandas%')
                                ->get();

                }
                
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
    public function create(Test $request)
    {
        try {
            
            $apiKey = '75cbiK9DOGjsvmTXwckENT_Z-6FFVlss8AiPrNWa5jA';
            $client = new Client();
            $impresora = Impresora::find( $request->id );

            if( $impresora->id ){

                $response = $client->post( 'https://api.printnode.com/printjobs', [

                    'auth' => [$apiKey, ''],
                    'json' => [

                        'printer' => $impresora->seriePrint,
                        'title' => 'Testing Printer',
                        'contentType' => 'pdf_base64',
                        'content' => base64_encode( file_get_contents( public_path('media/').'test.pdf' ) ),
                        'source' => 'Foodify',

                    ]

                ]);

                if( $response->getBody() == true ){

                    $datos['exito'] = true;

                }

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
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
                'idUser' => auth()->user()->id,

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

    /**
     * Descarga de software cliente PrintNode
     * ! Se retorna el exe del path publico
     */
    public function printNode(){
        try {
            
            if( file_exists(public_path().'/PrintNode-4.28.0.exe' ) ){

                return response()->download( public_path().'/PrintNode-4.28.0.exe' );

            }

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }
    }
}
