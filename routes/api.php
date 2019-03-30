<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix'=> 'auth'], function(){
    Route::post('login', 'AppController@login');

    Route::group(['middleware' => 'auth:api'], function() {
        
        //Usuario
        Route::get('logout', 'AppController@logout');
        Route::get('usuario', 'AppController@getUsuario');

        //Reservas
        Route::get('misReservas', 'AppController@getMisReservas');

        //Prestamos

        Route::get('misPrestamos', 'AppController@getMisPrestamos');

        Route::post('reservar', 'AppController@reservar');

        Route::post('busqueda', 'AppController@busqueda');
        

    });
});
