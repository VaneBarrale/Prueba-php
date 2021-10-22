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
    return view('auth.login');
});

/*Route::get('/empleado', function () {
    return view('empleado.index');
});

Route::get('/empleado/create', [Empleado::class, 'create']); */
/*esto lo redirecciono en el metodo create de la clase empleado, por eso aca solo la llamo*/

/*Si quisiera una ruta para todos los metodos de la clase, puedo hacerlo asi, por eso comento lo de arriba*/

Route::resource('empleado', EmpleadoController::class)->middleware('auth'); //->middleware('auth') se asegura de que esté logueada, sino me saca al loguin y no me deja entrar a la URL directo
Auth::routes(['register'=>false, 'reset'=>false]); //con esto le digo que cuando estoy en la pagina de loguin no me muestre register y reset

Route::get('/home', [EmpleadoController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', [EmpleadoController::class, 'index'])->name('home');
});