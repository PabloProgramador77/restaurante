<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Models\OrdenPlatillo;
use App\Models\Platillo;
use Illuminate\Http\Request;
use App\Http\Requests\Ordenes\StoreOrden;
use App\Http\Requests\Ordenes\EditOrden;
use App\Http\Requests\Ordenes\CobrarOrden;
use App\Http\Requests\Ordenes\DestroyOrden;
use \Mpdf\Mpdf as PDF;

class OrdenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            
            $ordenes = Orden::select('ordens.id', 'ordens.totalPedido', 'ordens.idMesa')
                ->join('mesa_users', 'ordens.idMesa', '=', 'mesa_users.idMesa')
                ->where('ordens.estadoPedido', '=', 'Abierto')
                ->orderBy('ordens.updated_at', 'desc')
                ->get();

            return view('ordenes/index', compact('ordenes'));

        } catch (\Throwable $th) {
            
            echo "Fatal Error: ".$th->getMessage();

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            
            $orden = Orden::find( session()->get('idOrden') );

            if( $orden->id ){

                $total = 0;

                $platillos = OrdenPlatillo::select('platillos.precioPlatillo', 'orden_platillos.cantidad')
                    ->join('platillos', 'orden_platillos.idPlatillo', '=', 'platillos.id')
                    ->where('orden_platillos.idOrden', '=', $orden->id)
                    ->get();

                foreach($platillos as $platillo){

                    $total += ($platillo->precioPlatillo * $platillo->cantidad);

                }

                $orden->totalPedido = $total;
                $orden->idMesa = $request->mesa;
                $orden->save();

                if( $this->comanda() ){

                    $datos['exito'] = true;
                    $datos['mensaje'] = 'Orden Terminada.';

                }else{

                    $datos['exito'] = false;
                    $datos['mensaje'] = 'Comanda no impresa.';

                }

                session()->forget('idOrden');

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrden $request)
    {
        try {
            
            $orden = Orden::create([

                'totalPedido' => 0,
                'estadoPedido' => 'Abierto',
                'idMesa' => NULL

            ]);

            if ($orden->id){

                $datos['exito'] = true;
                $datos['mensaje'] = 'Orden Nueva Agregada.';

                session()->put('idOrden', $orden->id);

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
     * @param  \App\Models\Orden  $orden
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        try {
            
            $datos = OrdenPlatillo::select('platillos.nombrePlatillo', 'platillos.precioPlatillo', 'orden_platillos.cantidad', 'orden_platillos.nota')
                ->join('platillos', 'orden_platillos.idPlatillo', '=', 'platillos.id')
                ->where('orden_platillos.idOrden', '=', session()->get('idOrden'))
                ->get();

            $datos['exito'] = true;

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Orden  $orden
     * @return \Illuminate\Http\Response
     */
    public function edit(EditOrden $request)
    {
        try {
            
            $datos = OrdenPlatillo::select('platillos.nombrePlatillo', 'platillos.precioPlatillo', 'orden_platillos.cantidad', 'orden_platillos.nota')
                ->join('platillos', 'orden_platillos.idPlatillo', '=', 'platillos.id')
                ->where('orden_platillos.idOrden', '=', $request->id)
                ->get();

            $datos['exito'] = true;

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
     * @param  \App\Models\Orden  $orden
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Orden $orden)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Orden  $orden
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyOrden $request)
    {
        try {
            
            $orden = Orden::find($request->id);

            $orden->delete();

            $datos['exito'] = true;
            $datos['mensaje'] = 'Orden Eliminada.';

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Cobrar orden
     * @param Request $id
     * @return json
     */
    public function cobrar(CobrarOrden $request){
        try {
            
            $orden = Orden::where('id', '=', $request->id)
                ->update([

                    'estadoPedido' => 'Pagado'

                ]);

            if( $this->ticket($request->id) ){

                $datos['exito'] = true;
                $datos['mensaje'] = 'Orden Pagada.';

            }else{

                $datos['exito'] = false;
                $datos['mensaje'] = 'Ticket no impreso.';

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Recopilación de historial
     * @param NULL
     * @return JSON
     */
    public function historial(){
        try {
            
            $ordenes = Orden::select('ordens.id', 'ordens.totalPedido', 'ordens.created_at', 'ordens.idMesa')
                ->join('mesa_users', 'ordens.idMesa', '=', 'mesa_users.idMesa')
                ->where('ordens.estadoPedido', '!=', 'Abierto')
                ->orderBy('ordens.estadoPedido', 'desc')
                ->get();

            return view('ordenes/historial', compact('ordenes'));

        } catch (\Throwable $th) {
            
            echo "Fatal Error: ".$th->getMessage();

        }
    }

    /**
     * Creación de comanda
     * @param SESSION
     * @return PDF
     */
    public function comanda(){

        try {

            $orden = Orden::find(session()->get('idOrden'));
            
            $platillos = Platillo::select('platillos.nombrePlatillo', 'orden_platillos.cantidad', 'orden_platillos.nota')
                ->join('orden_platillos', 'platillos.id', '=', 'orden_platillos.idPlatillo')
                ->where('orden_platillos.idOrden', '=', session()->get('idOrden'))
                ->get();

            $comanda = new \Mpdf\Mpdf([

                'mode' => 'utf-8',
                'format' => [80, 1290],
                'orientation' => 'P',
                'autoPageBreak' => false

            ]);

            $comanda->writeHTML('<h1 style="font-style: bold; font-size: 24px; text-align: center;">Comanda de Cocina</h1>');
            $comanda->writeHTML('<h3 style="font-style: normal; font-size: 11px; text-align: center;">'.$orden->created_at.'</h3>');
            $comanda->writeHTML('<table>');
            $comanda->writeHTML('<thead>');
            $comanda->writeHTML('<tr>');
            $comanda->writeHTML('<th style="text-align: center; font-size: 14px;">#</th>');
            $comanda->writeHTML('<th style="text-align: center; font-size: 14px;">Platillo</th>');
            $comanda->writeHTML('<th style="text-align: center; font-size: 14px;">Preparación</th>');
            $comanda->writeHTML('</tr>');
            $comanda->writeHTML('</thead>');
            $comanda->writeHTML('<tbody>');

            foreach($platillos as $platillo){

                $comanda->writeHTML('<tr>');
                $comanda->writeHTML('<td style="text-align: center; font-size: 12px;">'.$platillo->cantidad.'</td>');
                $comanda->writeHTML('<td style="text-align: center; font-size: 12px;">'.$platillo->nombrePlatillo.'</td>');
                $comanda->writeHTML('<td style="text-align: center; font-size: 12px;">'.$platillo->nota.'</td>');
                $comanda->writeHTML('</tr>');

            }

            $comanda->writeHTML('</tbody>');
            $comanda->writeHTML('</table>');

            $comanda->Output( public_path('storage/pdf/comandas/').'comanda'.$orden->id.'.pdf', \Mpdf\Output\Destination::FILE );

            if( file_exists(public_path('storage/pdf/comandas/').'comanda'.$orden->id).'.pdf' ){

                return true;

            }else{

                return false;

            }

        } catch (\Throwable $th) {
            
            echo "Fatal Error: ".$th->getMessage();

        }

    }

    /**
     * Ticket de Pago
     * 
     */
    public function ticket($idOrden){
        try {
            
            $total = 0;

            $orden = Orden::find($idOrden);
            
            $platillos = Platillo::select('platillos.nombrePlatillo', 'orden_platillos.cantidad', 'platillos.precioPlatillo')
                ->join('orden_platillos', 'platillos.id', '=', 'orden_platillos.idPlatillo')
                ->where('orden_platillos.idOrden', '=', $idOrden)
                ->get();

            $ticket = new \Mpdf\Mpdf([

                'mode' => 'utf-8',
                'format' => [80, 1290],
                'orientation' => 'P',
                'autoPageBreak' => false

            ]);

            $ticket->writeHTML('<h1 style="font-style: bold; font-size: 22px; text-align: center;">Ticket de Pago</h1>');
            $ticket->writeHTML('<h3 style="font-style: normal; font-size: 11px; text-align: center;">'.$orden->updated_at.'</h3>');
            $ticket->writeHTML('<table>');
            $ticket->writeHTML('<thead>');
            $ticket->writeHTML('<tr>');
            $ticket->writeHTML('<th style="text-align: center; font-size: 14px;">#</th>');
            $ticket->writeHTML('<th style="text-align: center; font-size: 14px;">Platillo</th>');
            $ticket->writeHTML('<th style="text-align: center; font-size: 14px;">Monto</th>');
            $ticket->writeHTML('</tr>');
            $ticket->writeHTML('</thead>');
            $ticket->writeHTML('<tbody>');

            foreach($platillos as $platillo){

                $ticket->writeHTML('<tr>');
                $ticket->writeHTML('<td style="text-align: center; font-size: 12px;">'.$platillo->cantidad.'</td>');
                $ticket->writeHTML('<td style="text-align: center; font-size: 12px;">'.$platillo->nombrePlatillo.'</td>');
                $ticket->writeHTML('<td style="text-align: center; font-size: 12px;"> $ '.($platillo->precioPlatillo * $platillo->cantidad).' M.N.</td>');
                $ticket->writeHTML('</tr>');

                $total += ($platillo->cantidad * $platillo->precioPlatillo);

            }

            $ticket->writeHTML('<tr><td colspan="3" style="text-align: center; font-size: 12px;">Total: $ '.$total.' M.N.</td></tr>');
            $ticket->writeHTML('</tbody>');
            $ticket->writeHTML('</table>');

            $ticket->Output( public_path('storage/pdf/tickets/').'ticket'.$orden->id.'.pdf', \Mpdf\Output\Destination::FILE );

            if( file_exists(public_path('storage/pdf/tickets/').'ticket'.$orden->id).'.pdf' ){

                return true;

            }else{

                return false;

            }

        } catch (\Throwable $th) {
            
            echo "Fatal Error: ".$th->getMessage();

        }
    }

    /**
     * Pedidos Delivery
     * @param NULL
     * @return json
     */
    public function delivery(){
        try {
            
            $ordenes = Orden::orderBy('created_at', 'desc')
                ->get();

            return view('ordenes/delivery', compact('ordenes'));

        } catch (\Throwable $th) {
            
            echo "Fatal Error: ".$th->getMessage();

        }
    }
}
