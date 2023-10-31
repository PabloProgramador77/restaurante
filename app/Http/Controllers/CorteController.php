<?php

namespace App\Http\Controllers;

use App\Models\Corte;
use App\Models\Platillo;
use App\Models\Orden;
use App\Models\CortePlatillo;
use App\Models\CorteUsers;
use Illuminate\Http\Request;
use App\Http\Requests\Cortes\StoreCorte;
use App\Http\Requests\Cortes\ShowCorte;
use App\Http\Requests\Cortes\PrintCorte;
use Mpdf\Mpdf as PDF;

class CorteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            
            if( auth()->user()->role() == 'Gerente' ){

                $cortes = Corte::select('cortes.id', 'cortes.totalCorte', 'cortes.created_at')
                    ->join('corte_users', 'cortes.id', '=', 'corte_users.idCorte')
                    ->where('corte_users.idUser', '=', auth()->user()->id)
                    ->orderBy('cortes.created_at', 'desc')
                    ->get();

            }else{

                $cortes = Corte::select('cortes.id', 'cortes.totalCorte', 'cortes.created_at')
                    ->join('corte_users', 'cortes.id', '=', 'corte_users.idCorte')
                    ->join('user_empleados', 'corte_users.idUser', '=', 'user_empleados.idUser')
                    ->where('user_empleados.idEmpleado', '=', auth()->user()->id)
                    ->orderBy('cortes.created_at', 'desc')
                    ->get();

            }

            return view('cortes/index', compact('cortes'));

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
        try {
            
            $datos = Platillo::select('platillos.nombrePlatillo', 'platillos.precioPlatillo', 'orden_platillos.cantidad')
                ->join('orden_platillos', 'platillos.id', '=', 'orden_platillos.idPlatillo')
                ->join('ordens', 'orden_platillos.idOrden', '=', 'ordens.id')
                ->where('ordens.estadoPedido', '=', 'Pagado')
                ->orderBy('platillos.nombrePlatillo', 'asc')
                ->get();

            $datos['exito'] = true;


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
    public function store(StoreCorte $request)
    {
        try {
            
            $corte = Corte::create([
                
                'totalCorte' => $request->total

            ]);

            if( $corte->id ){

                $corteUser = CorteUsers::create([

                    'idCorte' => $corte->id,
                    'idUser' => auth()->user()->id

                ]);

                if( $corteUser->id ){

                    $this->update($corte);

                    $datos['exito'] = true;
                    $datos['mensaje'] = 'Corte Agregado.';

                }else{

                    $corte->delete();

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
     * @param  \App\Models\Corte  $corte
     * @return \Illuminate\Http\Response
     */
    public function show(ShowCorte $request)
    {
        try {
            
            $corte = Corte::find($request->id);

            $datos = Platillo::select('platillos.nombrePlatillo', 'platillos.precioPlatillo', 'orden_platillos.cantidad')
                ->join('orden_platillos', 'platillos.id', '=', 'orden_platillos.idPlatillo')
                ->join('corte_platillos', 'orden_platillos.idOrden', '=', 'corte_platillos.idPedido')
                ->where('corte_platillos.idCorte', '=', $corte->id)
                ->orderBy('platillos.nombrePlatillo', 'asc')
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
     * @param  \App\Models\Corte  $corte
     * @return \Illuminate\Http\Response
     */
    public function edit(PrintCorte $request)
    {
        try {
            
            $total = 0;
            $corte = Corte::find($request->id);

            $platillos = Platillo::select('platillos.nombrePlatillo', 'platillos.precioPlatillo', 'orden_platillos.cantidad')
                ->join('orden_platillos', 'platillos.id', '=', 'orden_platillos.idPlatillo')
                ->join('ordens', 'orden_platillos.idOrden', '=', 'ordens.id')
                ->where('ordens.created_at', '<=', $corte->created_at)
                ->where('ordens.estadoPedido', '=', 'Corte')
                ->orderBy('platillos.nombrePlatillo', 'asc')
                ->get();

            $reporte = new \Mpdf\Mpdf([

                'mode' => 'utf-8',
                'format' => [80, 1290],
                'orientation' => 'P',
                'autoPageBreak' => false

            ]);

            $reporte->writeHTML('<h1 style="font-style: bold; text-align: center; font-size: 26px;">Corte de Caja</h1>');
            $reporte->writeHTML('<h3 style="font-style: normal; text-align: center; font-size: 18px;">Fecha de Corte: '.$corte->created_at.'</h3>');
            $reporte->writeHTML('<p style="font-style: normal; font-size: 14px;">A continuación, los datos del corte:</p>');
            $reporte->writeHTML('<table style="margin: auto;">');
            $reporte->writeHTML('<thead>');
            $reporte->writeHTML('<tr>');
            $reporte->writeHTML('<th>#</th>');
            $reporte->writeHTML('<th>Platillo</th>');
            $reporte->writeHTML('<th>Importe</th>');
            $reporte->writeHTML('</tr>');
            $reporte->writeHTML('</thead>');
            $reporte->writeHTML('<tbody style="margin: auto;">');
            
            foreach( $platillos as $platillo ){

                $reporte->writeHTML('<tr style="border: bottom;">');
                $reporte->writeHTML('<td style="text-align: center; font-size: 14px;">'.$platillo->cantidad.'</td>');
                $reporte->writeHTML('<td style="text-align: center; font-size: 14px;">'.$platillo->nombrePlatillo.'</td>');
                $reporte->writeHTML('<td style="text-align: center; font-size: 14px;">$ '.($platillo->precioPlatillo * $platillo->cantidad).' M.N.</td>');
                $reporte->writeHTML('</tr>');

                $total += ($platillo->precioPlatillo * $platillo->cantidad);

            }

            $reporte->writeHTML('<tr><td colspan="3" style="text-align: center; font-style: bold;">Total de Corte: $ '.$total.' M.N.</td></tr>');
            $reporte->writeHTML('</tbody>');
            $reporte->writeHTML('</table>');

            $reporte->Output(public_path('storage/pdf/cortes/').'corte'.$corte->id.'.pdf', \Mpdf\Output\Destination::FILE);

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
     * @param  \App\Models\Corte  $corte
     * @return \Illuminate\Http\Response
     */
    public function update(Corte $corte)
    {
        try {
            
            $ordenes = Orden::select('ordens.id')
                ->join('mesa_users', 'ordens.idMesa', '=', 'mesa_users.idMesa')
                ->where('ordens.estadoPedido', '=', 'Pagado')
                ->where('ordens.created_at', '<=', $corte->created_at)
                ->get();

            foreach($ordenes as $orden){

                $orden->estadoPedido = 'Corte';
                $orden->save();

                $cortePlatillo = CortePlatillo::create([

                    'idCorte' => $corte->id,
                    'idPedido' => $orden->id

                ]);

            }

            return true;

        } catch (\Throwable $th) {
            
            echo "Fatal Error: ".$th->getMessage();

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Corte  $corte
     * @return \Illuminate\Http\Response
     */
    public function destroy(Corte $corte)
    {
        //
    }
}
