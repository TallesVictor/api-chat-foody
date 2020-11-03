<?php

use Illuminate\Support\Facades\Route;
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

Route::get('cnpj/{cnpj}', 'APIController@cnpj');


Route::group([
    'prefix' => 'auth'
], function () {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});

Route::group([
    'prefix' => 'cardapio'
], function () {
    Route::get('/{restaurante}/{codigo}/{cardapio}', 'CardapioController@search');

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('/{cnpj}', 'CardapioController@list');
        Route::put('/salvar', 'CardapioController@insert');
        Route::post('/alterar', 'CardapioController@alterar');
        Route::delete('/apagar/{codigo}', 'CardapioController@apagar');
    });
});
Route::group([
    'prefix' => 'prato'
], function () {
    Route::get('/{id}', 'PratoController@list');
    Route::get('listItens/{id}', 'PratoController@listItens');


    Route::post('create', 'PratoController@create');
    Route::delete('deleteIngrediente/{prato}/{ingrediente}', 'PratoController@deleteIngrediente');
    Route::delete('/{id}', 'PratoController@del');

});

Route::group([
    'prefix' => 'restaurante'
], function () {

    Route::post('/salvar', 'RestauranteController@insert');

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('/', 'RestauranteController@list');
        Route::delete('/{codigo}', 'RestauranteController@apagar');
        Route::get('/buscar/{parametro}', 'RestauranteController@search');
        Route::put('/alterar', 'RestauranteController@alterar');
        });
  });
