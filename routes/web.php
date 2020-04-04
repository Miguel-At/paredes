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
    return view('store');
});

//rutas referentes a los reportes pdf
Route::resource('productos','InventarioController');
Route::post('reporte.pdf','InventarioController@Exportpdf');
Route::get('mostrar/{id}','InventarioController@show');
Route::get('productos','InventarioController@index');
Route::post('actualizar','InventarioController@actualizar');




//rutas referentes a todo lo del inventario (eliminar, mostrat, actualizar etc.)
Route::get('/product/{id}','Almacen@mostrar');
Route::resource('almacen','Almacen');
Route::post('/almacen','Almacen@index');
Route::post('elegir','Almacen@elegir');
Route::post('/autocomplete', 'Almacen@fetch')->name('autocomplete.fetch');
Route::post('/guardar','Almacen@store');
Route::put('/actualizar/{id}','Almacen@update');
Route::delete('/borrar/{user}', 'Almacen@destroy');
