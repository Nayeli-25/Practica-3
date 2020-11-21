<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Middleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|*/

//Activar cuenta
Route::get('confirmarUsuario/{codigo}', 'AuthController@verificar');

//Iniciar sesión
Route::post('login', 'AuthController@logIn');

//Cerrar sesión
Route::middleware('auth:sanctum')->delete('logout', 'AuthController@logOut');

//Ver información del usuario logueado
Route::middleware('auth:sanctum')->get('inicio', 'AuthController@inicio');

//Otorgar y revocar permisos
Route::middleware(['auth:sanctum','checkrole'])->group(function () {
    Route::put('otorgar/{id}', 'PermisosController@otorgarPermisos');
    Route::put('revocar/{id}', 'PermisosController@revocarPermisos');
});

//Rutas Usuarios
Route::post('registarUsuario', 'UsersController@registrarUsuario')->middleware('checkage');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('usuarios/{id?}', 'UsersController@getUsuarios')->middleware('checkrole')->where("id", "[0-9]+");
    Route::put('updateUsuario/{id}', 'UsersController@updateUsuario')->middleware('limituser');
    Route::delete('deleteUsuario/{id}', 'UsersController@deleteUsuario')->middleware('limituser');
    //Subir imagen de perfil
    Route::post('subirImagen', 'Files\FilesController@SubirImagenPerfil');
    });
    
//Rutas Productos
Route::middleware('auth:sanctum')->group(function (){
    Route::get('productos/{id?}', 'ProductosController@getProductos')->where("id", "[0-9]+");
    Route::post('nuevoProducto', 'ProductosController@createProducto');
    Route::put('updateProducto/{id}', 'ProductosController@updateProducto')->middleware('limitproduct');
    Route::delete('deleteproducto/{id}', 'ProductosController@deleteProducto')->middleware('limitproduct');
});

//Rutas Comentarios
Route::middleware('auth:sanctum')->group(function () {
    Route::get('comentarios/{id?}', 'ComentariosController@getComentarios')->where("id", "[0-9]+");
    Route::post('nuevoComentario', 'ComentariosController@createComentario');
    Route::put('updateComentario/{id}', 'ComentariosController@updateComentario')->middleware('limitcommentary');
    Route::delete('deleteComentario/{id}', 'ComentariosController@deleteComentario')->middleware('limitcommentary');
});

//Rutas específicas
Route::middleware('auth:sanctum')->group(function () {
    Route::get('producto/{id}/comentarios', 'ComentariosController@getComentariosPorProducto');
    Route::get('personas/{id}/comentarios', 'ComentariosController@getComentariosPorPersona');
});
