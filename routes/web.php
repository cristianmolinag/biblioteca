<?php

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
    return redirect()->route('home');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('prestamo/mis_prestamos', 'PrestamoController@historial')->name('prestamo.porUsuario');
    Route::get('prestamo/detalle/{id}', 'PrestamoController@show')->name('prestamo.detalle');
    Route::get('prestamo/mis_prestamos_activos', 'PrestamoController@index')->name('prestamo.activos');
    Route::get('usuario/perfil', 'UsuarioController@index')->name('usuario.perfil');
    Route::put('usuario/update/{id}', 'UsuarioController@update')->name('usuario.update');
});

Route::middleware(['auth', 'admin'])->group(function () {

    //Admin
    Route::get('admin', 'AdminController@index')->name('admin.index');
    Route::get('admin/nuevo', 'AdminController@create')->name('admin.nuevo');
    Route::post('admin/store', 'AdminController@store')->name('admin.store');
    Route::get('admin/edit/{id}', 'AdminController@edit')->name('admin.edit');
    Route::put('admin/update/{id}', 'AdminController@update')->name('admin.update');

     //Docente
     Route::get('docente', 'DocenteController@index')->name('docente.index');
     Route::get('docente/nuevo', 'DocenteController@create')->name('docente.nuevo');
     Route::post('docente/store', 'DocenteController@store')->name('docente.store');
     Route::get('docente/edit/{id}', 'DocenteController@edit')->name('docente.edit');
     Route::put('docente/update/{id}', 'DocenteController@update')->name('docente.update');

     //Alumno
     Route::get('alumno', 'AlumnoController@index')->name('alumno.index');
     Route::get('alumno/nuevo', 'AlumnoController@create')->name('alumno.nuevo');
     Route::post('alumno/store', 'AlumnoController@store')->name('alumno.store');
     Route::get('alumno/edit/{id}', 'AlumnoController@edit')->name('alumno.edit');
     Route::put('alumno/update/{id}', 'AlumnoController@update')->name('alumno.update');
     Route::post('alumno/file', 'AlumnoController@file')->name('alumno.file');

      //Autor
      Route::get('autor', 'AutorController@index')->name('autor.index');
      Route::get('autor/nuevo', 'AutorController@create')->name('autor.nuevo');
      Route::post('autor/store', 'AutorController@store')->name('autor.store');
      Route::get('autor/edit/{id}', 'AutorController@edit')->name('autor.edit');
      Route::put('autor/update/{id}', 'AutorController@update')->name('autor.update');

      //Editorial
      Route::get('editorial', 'EditorialController@index')->name('editorial.index');
      Route::get('editorial/nuevo', 'EditorialController@create')->name('editorial.nuevo');
      Route::post('editorial/store', 'EditorialController@store')->name('editorial.store');
      Route::get('editorial/edit/{id}', 'EditorialController@edit')->name('editorial.edit');
      Route::put('editorial/update/{id}', 'EditorialController@update')->name('editorial.update');

      //Categoria
      Route::get('categoria', 'CategoriaController@index')->name('categoria.index');
      Route::get('categoria/nuevo', 'CategoriaController@create')->name('categoria.nuevo');
      Route::post('categoria/store', 'CategoriaController@store')->name('categoria.store');
      Route::get('categoria/edit/{id}', 'CategoriaController@edit')->name('categoria.edit');
      Route::put('categoria/update/{id}', 'CategoriaController@update')->name('categoria.update');

      //Libro
     Route::get('libro', 'LibroController@index')->name('libro.index');
     Route::get('libro/nuevo', 'LibroController@create')->name('libro.nuevo');
     Route::post('libro/store', 'LibroController@store')->name('libro.store');
     Route::get('libro/edit/{id}', 'LibroController@edit')->name('libro.edit');
     Route::put('libro/update/{id}', 'LibroController@update')->name('libro.update');
     Route::post('libro/file', 'LibroController@file')->name('libro.file');

     //Ubicacion
     Route::get('ubicacion', 'UbicacionController@index')->name('ubicacion.index');
     Route::get('ubicacion/nuevo', 'UbicacionController@create')->name('ubicacion.nuevo');
     Route::post('ubicacion/store', 'UbicacionController@store')->name('ubicacion.store');
     Route::get('ubicacion/edit/{id}', 'UbicacionController@edit')->name('ubicacion.edit');
     Route::put('ubicacion/update/{id}', 'UbicacionController@update')->name('ubicacion.update');

     //Ejemplar
     Route::get('ejemplar', 'EjemplarController@index')->name('ejemplar.index');
     Route::get('ejemplar/nuevo', 'EjemplarController@create')->name('ejemplar.nuevo');
     Route::post('ejemplar/store', 'EjemplarController@store')->name('ejemplar.store');
     Route::get('ejemplar/edit/{id}', 'EjemplarController@edit')->name('ejemplar.edit');
     Route::put('ejemplar/update/{id}', 'EjemplarController@update')->name('ejemplar.update');
     Route::post('ejemplar/file', 'EjemplarController@file')->name('ejemplar.file');

     Route::get('prestamo', 'PrestamoController@index')->name('prestamo');
     Route::get('prestamo/nuevo', 'PrestamoController@create')->name('prestamo.nuevo');
     Route::put('prestamo/update/{id}', 'PrestamoController@update')->name('prestamo.update');
     Route::post('prestamo/store', 'PrestamoController@store')->name('prestamo.store');
     Route::get('prestamo/show/{id}', 'PrestamoController@show')->name('prestamo.show');
     Route::get('prestamo/historial', 'PrestamoController@historial')->name('prestamo.historial');
    });
    
