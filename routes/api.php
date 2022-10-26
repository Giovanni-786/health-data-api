<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



//ROTA DE FUNCIONÁRIOS
Route::post('funcionarios', 'FuncionarioController@store');
Route::get('funcionarios/{id}', 'FuncionarioController@indexById');
Route::get('funcionarios', 'FuncionarioController@indexAll');

//ROTA DE PACIENTES
Route::post('pacientes', 'PacienteController@store');
Route::get('pacientes', 'PacienteController@indexAll');
Route::get('pacientes/{id}', 'PacienteController@indexById');

//PATOLOGIAS
Route::post('patologias', 'PatologiasController@store');
Route::get('patologias', 'PatologiasController@indexAll');

//ALERGIAS
Route::post('alergias', 'AlergiasController@store');

