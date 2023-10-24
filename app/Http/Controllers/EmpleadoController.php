<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserEmpleado;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Empleados\StoreEmpleado;
use App\Http\Requests\Empleados\EditEmpleado;
use App\Http\Requests\Empleados\UpdateEmpleado;
use App\Http\Requests\Empleados\DestroyEmpleado;
use Illuminate\Support\Facades\Hash;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $empleados = User::select('users.id', 'users.name', 'users.email', 'users.created_at')
                ->join('user_empleados', 'users.id', '=', 'user_empleados.idEmpleado')
                ->where('user_empleados.idUser', '=', auth()->user()->id)
                ->orderBy('users.created_at', 'desc')
                ->get();

            $roles = Role::all();

            return view('empleados.index', compact('empleados', 'roles'));

        } catch (\Throwable $th) {

            echo "Fatal Error: ".$th->getMessage().'. Por favor contacta al administrador de la plataforma.';
            
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
    public function store(StoreEmpleado $request)
    {
        try {
            
            $empleado = User::create([

                'name' => $request->nombre,
                'email' => $request->email,
                'password' => Hash::make($request->password)

            ]);

            if( $empleado->id ){

                $userEmpleado = UserEmpleado::create([

                    'idUser' => auth()->user()->id,
                    'idEmpleado' => $empleado->id

                ]);

                if( $userEmpleado->id ){

                    $empleado->assignRole($request->rol);
                    
                    $datos['exito'] = true;
                    $datos['mensaje'] = 'Empleado Registrado.';

                }else{

                    $empleado->delete();

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
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit(EditEmpleado $request)
    {
        try {
            
            $empleado = User::where('id', '=', $request->id)->first();

            if( $empleado->id ){

                $datos['exito'] = true;
                $datos['mensaje'] = $empleado->name;
                $datos['email'] = $empleado->email;

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
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmpleado $request)
    {
        try {
            
            $empleado = User::where('id', '=', $request->id)
                ->update([

                    'name' => $request->nombre,
                    'email' => $request->email

                ]);

            $datos['exito'] = true;
            $datos['mensaje'] = 'Empleado Actualizado.';

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyEmpleado $request)
    {
        try {
            
            $empleado = User::find($request->id);

            $empleado->delete();

            $datos['exito'] = true;
            $datos['mensaje'] = 'Empleado Eliminado.';

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
        
    }
}
