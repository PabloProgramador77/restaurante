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
Route::post('/categorias/agregar', [App\Http\Controllers\CategoriaController::class, 'store'])->name('agregar');
Route::post('/categorias/editar', [App\Http\Controllers\CategoriaController::class, 'edit'])->name('editar');
Route::post('/categorias/actualizar', [App\Http\Controllers\CategoriaController::class, 'update'])->name('actualizar');
Route::post('/categorias/eliminar', [App\Http\Controllers\CategoriaController::class, 'destroy'])->name('eliminar');

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
Route::post('/platillos/agregar', [App\Http\Controllers\PlatilloController::class, 'store'])->name('agregar');
Route::post('/platillos/editar', [App\Http\Controllers\PlatilloController::class, 'edit'])->name('editar');
Route::post('/platillos/actualizar', [App\Http\Controllers\PlatilloController::class, 'update'])->name('actualizar');
Route::post('/platillos/eliminar', [App\Http\Controllers\PlatilloController::class, 'destroy'])->name('eliminar');

/**
 * -------------------------------------------------
 * Rutas de ordenes
 * -------------------------------------------------
 */
Route::post('/platillos/orden', [App\Http\Controllers\OrdenController::class, 'store'])->name('orden');
Route::post('/platillos/ordenar', [App\Http\Controllers\OrdenPlatilloController::class, 'store'])->name('ordenar');
Route::post('/orden/ver', [App\Http\Controllers\OrdenController::class, 'show'])->name('ver_orden');
Route::post('/orden/terminar', [App\Http\Controllers\OrdenController::class, 'create'])->name('terminar_orden');
Route::get('/ordenes', [App\Http\Controllers\OrdenController::class, 'index'])->name('ordenes');
Route::post('/orden/consultar', [App\Http\Controllers\OrdenController::class, 'edit'])->name('consultar_orden');
Route::post('/orden/cobrar', [App\Http\Controllers\OrdenController::class, 'cobrar'])->name('cobrar_orden');
Route::post('/orden/eliminar', [App\Http\Controllers\OrdenController::class, 'destroy'])->name('eliminar_orden');
Route::get('/ordenes/historial', [App\Http\Controllers\OrdenController::class, 'historial'])->name('historial');
Route::get('/delivery', [App\Http\Controllers\OrdenController::class, 'delivery'])->name('delivery');
Route::post('/orden/editar', [App\Http\Controllers\OrdenController::class, 'update'])->name('editar_orden');

/**
 * ---------------------------------------------------------------------------
 * Rutas de Mesas
 * -----------------------------------------------------------------------
 */
Route::get('/mesas', [App\Http\Controllers\MesaController::class, 'index'])->name('mesas');
Route::post('/mesas/agregar', [App\Http\Controllers\MesaController::class, 'store'])->name('agregar');
Route::post('/mesas/editar', [App\Http\Controllers\MesaController::class, 'edit'])->name('editar');
Route::post('/mesas/actualizar', [App\Http\Controllers\MesaController::class, 'update'])->name('actualizar');
Route::post('/mesas/eliminar', [App\Http\Controllers\MesaController::class, 'destroy'])->name('eliminar');

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