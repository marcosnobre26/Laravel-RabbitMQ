<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilaController;

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


Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

    Route::group(['prefix'=>'signatures'], function(){
        Route::get('/', 'App\Http\Controllers\SignatureController@index');
        Route::post('/', 'App\Http\Controllers\SignatureController@create');
        Route::delete('/{product_id}', 'App\Http\Controllers\SignatureController@delete');
    });
});

Route::middleware('jwt.auth')->group(function () {
    // Rotas protegidas por JWT
});