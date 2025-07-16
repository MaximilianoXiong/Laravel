<?php

use App\Http\Controllers\controladorPrueba;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ComprasController;
//aqui arriba van los controllers

//aqui van las rutas
//uri es la url
//'welcome' es el archivo .blade.php
//laravel sabe donde esta la vista de forma predefinida

Route::get('/asd', function () {
    return view('welcome');
});

//haciendo pruebas de ajax
Route::post('/ajax', [ProductoController::class, 'pruebasAjax']);
Route::get('/pruebaAjax', [ProductoController::class, 'ajaxIndex']);

///////////////////////////////////////////
Route::get('/todos', [UsuarioController::class, 'index']);
//esto se traduce como "cuando vayamos a esta dir, usaremos el metodo 'index' de la clase UsuarioController"

Route::post('/todos', [UsuarioController::class, 'obtenido']);

//crear
Route::get('/Agregar', [ProductoController::class, 'create']);
Route::post('/Agregar', [ProductoController::class, 'store']);

//mostrar y filtrar
Route::get('/Listar', [ProductoController::class, 'index']);
Route::get('/', [ProductoController::class, 'index']);
Route::post('/', [ProductoController::class, 'filter']);

//modificar
Route::get('/Mod/{id}', [ProductoController::class, 'edit']);
Route::put('/Mod/{id}', [ProductoController::class, 'update']);

Route::delete('/Del/{id}', [ProductoController::class, 'destroy']);

//actualizar inverntario
Route::get('/Actualizar', [ProductoController::class, 'mostrarActualizar']);
Route::post('/Actualizar', [ProductoController::class, 'actualizarInventario']);

//Compras
Route::get('/Comprar', [ProductoController::class, 'mostrarCarrito']);
Route::post('/Comprar', [ProductoController::class, 'manejarCarrito']);
Route::post('/Comprar/compra', [ProductoController::class, 'subirCarrito']);

Route::get('/VerCompras', [ComprasController::class, 'index']);

//asi es como se usa un controlador
//Route::get('/dir', [Controlador::class, 'funcionControlador']);

//para recebir parametros por GET (ademas del usar el resource) se hace con
//Route::get('/{id}', [controladorPrueba::class, 'prueba']);
//y el metodo 'prueba' debe tener un parametro de entrada $id
