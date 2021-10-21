<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;

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

/*Route::get('/empleado', function () {
    return view('empleado.index');
});

Route::get('/empleado/create', [Empleado::class, 'create']); */
/*esto lo redirecciono en el metodo create de la clase empleado, por eso aca solo la llamo*/

/*Si quisiera una ruta para todos los metodos de la clase, puedo hacerlo asi, por eso comento lo de arriba*/

Route::resource('empleado', EmpleadoController::class);