<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrdenController;

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

Route::get('/listaOrden', [OrdenController::class, 'index'])->name('listaOrden');
Route::get('/obtenerDetalleOrden', [OrdenController::class, 'obtenerDetalleOrden'])->name('obtenerDetalleOrden');
Route::post('/guardarOrden', [OrdenController::class, 'store'])->name('guardarOrden');
Route::post('/editarOrden', [OrdenController::class, 'update'])->name('editarOrden');
Route::post('/eliminarOrden', [OrdenController::class, 'destroy'])->name('eliminarOrden');