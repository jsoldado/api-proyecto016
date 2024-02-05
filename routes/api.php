<?php

use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas de pruebas 

Route::get('/test', function () {
    return 'prueba get';
});

Route::post('/test', function(){
    return 'prueba post';
});

Route::delete('/test', function () {
    return 'prueba delete';
}); 

//////////////////////////

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

//Route::get('/me', [AuthController::class, 'me']);

Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');

/////////////////////////////

Route::resource('/articulos', ArticuloController::class); 


/* Route::group(['middleware' => ['cors']], function () {
    //Rutas a las que se permitirá acceso
    Route::resource('/articulos', 'ArticuloController'); 
});
 */