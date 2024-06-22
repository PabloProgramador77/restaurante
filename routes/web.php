<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/videos', [App\http\Controllers\HomeController::class, 'create'])->name('videos');

/**
 * --------------------------------------------------------------
 * Rutas de Categorías de Menú
 * --------------------------------------------------------------
 */
Route::get('/categorias', [App\Http\Controllers\CategoriaController::class, 'index'])->name('categorias');
Route::post('/categorias/agregar', [App\Http\Controllers\CategoriaController::class, 'store'])->name('agregar-categoria');
Route::post('/categorias/editar', [App\Http\Controllers\CategoriaController::class, 'edit'])->name('editar-categoria');
Route::post('/categorias/actualizar', [App\Http\Controllers\CategoriaController::class, 'update'])->name('actualizar-categoria');
Route::post('/categorias/eliminar', [App\Http\Controllers\CategoriaController::class, 'destroy'])->name('eliminar-categoria');

/**
 * Rutas de Menu de Categorias
 */
Route::post('/categorias/menu', [App\Http\Controllers\MenuCategoriaController::class, 'store'])->name('menu');
Route::get('/menu', [App\Http\Controllers\MenuCategoriaController::class, 'index'])->name('menu_restaurante');
Route::get('/menu/{idCategoria}', [App\Http\Controllers\MenuCategoriaController::class, 'create'])->name('menu_categoria');

/**
 * ----------------------------------------------------
 * Rutas de platillos
 * ----------------------------------------------------
 */
Route::get('/platillos', [App\Http\Controllers\PlatilloController::class, 'index'])->name('platillos');
Route::post('/platillos/agregar', [App\Http\Controllers\PlatilloController::class, 'store'])->name('agregar-platillo');
Route::post('/platillos/editar', [App\Http\Controllers\PlatilloController::class, 'edit'])->name('editar-platillo');
Route::post('/platillos/actualizar', [App\Http\Controllers\PlatilloController::class, 'update'])->name('actualizar-platillo');
Route::post('/platillos/eliminar', [App\Http\Controllers\PlatilloController::class, 'destroy'])->name('eliminar-platillo');

/**
 * -------------------------------------------------
 * Rutas de ordenes
 * -------------------------------------------------
 */
Route::post('/platillos/orden', [App\Http\Controllers\OrdenController::class, 'store'])->name('orden');
Route::post('/platillos/ordenar', [App\Http\Controllers\OrdenPlatilloController::class, 'store'])->name('ordenar');
Route::get('/orden/platillo/borrar/{id}', [App\Http\Controllers\OrdenPlatilloController::class, 'destroy'])->name('borrar-platillo');
Route::post('/orden/ver', [App\Http\Controllers\OrdenController::class, 'show'])->name('ver_orden');
Route::post('/orden/terminar', [App\Http\Controllers\OrdenController::class, 'create'])->name('terminar_orden');
Route::get('/ordenes', [App\Http\Controllers\OrdenController::class, 'index'])->name('ordenes');
Route::post('/orden/consultar', [App\Http\Controllers\OrdenController::class, 'edit'])->name('consultar_orden');
Route::post('/orden/cobrar', [App\Http\Controllers\OrdenController::class, 'cobrar'])->name('cobrar_orden');
Route::post('/orden/eliminar', [App\Http\Controllers\OrdenController::class, 'destroy'])->name('eliminar_orden');
Route::get('/ordenes/historial', [App\Http\Controllers\OrdenController::class, 'historial'])->name('historial');
Route::get('/delivery', [App\Http\Controllers\OrdenController::class, 'delivery'])->name('delivery');
Route::post('/orden/editar', [App\Http\Controllers\OrdenController::class, 'update'])->name('editar_orden');
Route::get('/orden/comanda/{id}', [App\Http\Controllers\OrdenController::class, 'download'])->name('descargar-comanda');
Route::get('/orden/ticket/{id}', [App\Http\Controllers\OrdenController::class, 'descarga'])->name('descargar-ticket');

/**
 * ---------------------------------------------------------------------------
 * Rutas de Mesas
 * -----------------------------------------------------------------------
 */
Route::get('/mesas', [App\Http\Controllers\MesaController::class, 'index'])->name('mesas');
Route::post('/mesas/agregar', [App\Http\Controllers\MesaController::class, 'store'])->name('agregar-mesa');
Route::post('/mesas/editar', [App\Http\Controllers\MesaController::class, 'edit'])->name('editar-mesa');
Route::post('/mesas/actualizar', [App\Http\Controllers\MesaController::class, 'update'])->name('actualizar-mesa');
Route::post('/mesas/eliminar', [App\Http\Controllers\MesaController::class, 'destroy'])->name('eliminar-mesa');

/**
 * -----------------------------------------------
 * Rutas de Caja & Cortes
 * ----------------------------------------------------------------------
 */
Route::get('/cortes', [App\Http\Controllers\CorteController::class, 'index'])->name('cortes');
Route::post('/cortes/calcular', [App\Http\Controllers\CorteController::class, 'create'])->name('calcular-corte');
Route::post('/cortes/agregar', [App\Http\Controllers\CorteController::class, 'store'])->name('nuevo-corte');
Route::post('/cortes/corte', [App\Http\Controllers\CorteController::class, 'show'])->name('ver-corte');
Route::post('/cortes/imprimir', [App\Http\Controllers\CorteController::class, 'edit'])->name('imprimir-corte');
Route::get('/corte/imprimir/{id}', [App\Http\Controllers\CorteController::class, 'download'])->name('descargar-corte');

/**
 * ---------------------------------------------------------------
 * Rutas de Roles
 * ----------------------------------------------------------------------
 */
Route::get('/roles', [App\Http\Controllers\RolController::class, 'index'])->name('roles');
Route::post('/roles/agregar', [App\Http\Controllers\RolController::class, 'store'])->name('agregar-rol');
Route::post('/roles/editar', [App\Http\Controllers\RolController::class, 'edit'])->name('editar-rol');
Route::post('/roles/actualizar', [App\Http\Controllers\RolController::class, 'update'])->name('actualizar-rol');
Route::post('/roles/eliminar', [App\Http\Controllers\RolController::class, 'destroy'])->name('eliminar-rol');
Route::post('/roles/permisos', [App\Http\Controllers\RolController::class, 'create'])->name('permisos-rol');

/**
 * -------------------------------------------------------------
 * Rutas de Permisos
 * ---------------------------------------------------------------
 */
Route::get('/permisos', [App\Http\Controllers\PermisoController::class, 'index'])->name('permisos');
Route::post('/permisos/agregar', [App\Http\Controllers\PermisoController::class, 'store'])->name('agregar-permiso');
Route::post('/permisos/editar', [App\Http\Controllers\PermisoController::class, 'edit'])->name('editar-permiso');
Route::post('/permisos/actualizar', [App\Http\Controllers\PermisoController::class, 'update'])->name('actualizar-permiso');
Route::post('/permisos/eliminar', [App\Http\Controllers\PermisoController::class, 'destroy'])->name('eliminar-permiso');

/**
 * --------------------------------------------------------------
 * Rutas de Empleados
 * -------------------------------------------------------------
 */
Route::get('/empleados', [App\Http\Controllers\EmpleadoController::class, 'index'])->name('empleados');
Route::post('/empleados/agregar', [App\Http\Controllers\EmpleadoController::class, 'store'])->name('agregar-empleado');
Route::post('/empleados/editar', [App\Http\Controllers\EmpleadoController::class, 'edit'])->name('editar-empleado');
Route::post('/empleados/actualizar', [App\Http\Controllers\EmpleadoController::class, 'update'])->name('actualizar-empleado');
Route::post('/empleados/eliminar', [App\Http\Controllers\EmpleadoController::class, 'destroy'])->name('eliminar-empleado');
Route::post('/empleados/role', [App\Http\Controllers\EmpleadoController::class, 'update_rol'])->name('actualizar-rol-empleado');

/**
 * --------------------------------------------------------------------------
 * Rutas de Impresoras
 * --------------------------------------------------
 */
Route::get('/impresoras', [App\Http\Controllers\ImpresoraController::class, 'index'])->name('impresoras');
Route::post('/impresoras/agregar', [App\Http\Controllers\ImpresoraController::class, 'store'])->name('agregar-impresora');
Route::post('/impresoras/editar', [App\Http\Controllers\ImpresoraController::class, 'show'])->name('editar-impresora');
Route::post('/impresoras/actualizar', [App\Http\Controllers\ImpresoraController::class, 'update'])->name('actualizar-impresora');
Route::post('/impresoras/eliminar', [App\Http\Controllers\ImpresoraController::class, 'destroy'])->name('eliminar-impresora');
Route::post('/impresoras/prueba', [App\Http\Controllers\ImpresoraController::class, 'create'])->name('prueba-impresora');
Route::get('/impresoras/descargar', [App\Http\Controllers\ImpresoraController::class, 'printNode'])->name('printNode-descargar');

/**
 * -----------------------------------------------------------
 * *Rutas de Sabores
 * -----------------------------------------------------------
 */
Route::get('/sabores', [App\Http\Controllers\SaborController::class, 'index'])->name('sabores');
Route::post('/sabores/agregar', [App\Http\Controllers\SaborController::class, 'store'])->name('agregar-sabor');
Route::post('/sabores/editar', [App\Http\Controllers\SaborController::class, 'show'])->name('editar-sabor');
Route::post('/sabores/actualizar', [App\Http\Controllers\SaborController::class, 'update'])->name('actualizar-sabor');
Route::post('/sabores/eliminar', [App\Http\Controllers\SaborController::class, 'destroy'])->name('eliminar-sabor');
Route::post('/sabor/platillos', [App\Http\Controllers\PlatilloHasSaboresController::class, 'store'])->name('sabor-platillos');