<?php

use App\Http\Controllers\Auth\Api\LoginController;
use App\Http\Controllers\Auth\Api\RegisterController;
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

Route::middleware(['auth:sanctum', 'check.role'])->get('/user', function (Request $request) {
    return $request->user();

});

Route::middleware(['auth:sanctum', 'check.role'])->group(function () {
    //ROTA DE PACIENTES
    Route::get('pacientes', 'PacienteController@indexAll');
    Route::post('pacientes', 'PacienteController@store');
    Route::put('pacientes/{id}', 'PacienteController@update');
    Route::get('pacientes/{id}', 'PacienteController@indexById');

    //ROTA DE UNIDADES
    Route::post('unidades', 'UnidadeController@store');
    Route::put('unidades/{id}', 'UnidadeController@update');
    Route::get('unidades/{id}', 'UnidadeController@indexById');
    Route::get('unidades', 'UnidadeController@indexAll');

    //ROTA DE MEDICOS
    Route::post('medicos', 'MedicoController@store');
    Route::put('medicos/{id}', 'MedicoController@update');
    Route::get('medicos', 'MedicoController@indexAll');
    Route::get('medicos/{id}', 'MedicoController@indexById');

    //PATOLOGIAS
    Route::post('patologias', 'PatologiasController@store');
    Route::put('patologias/{id}', 'PatologiasController@update');
    Route::get('patologias', 'PatologiasController@indexAll');
    Route::get('patologias/{id}', 'PatologiasController@indexById');

    //ALERGIAS
    Route::post('alergias', 'AlergiasController@store');
    Route::put('alergias/{id}', 'AlergiasController@update');
    Route::get('alergias', 'AlergiasController@indexAll');
    Route::get('alergias/{id}', 'AlergiasController@indexById');
    Route::delete('alergias/{id}', 'AlergiasController@delete');

    //ROTA DE MEDICAMENTOS
    Route::post('medicamentos', 'MedicamentosController@store');
    Route::put('medicamentos/{id}', 'MedicamentosController@update');
    Route::get('medicamentos', 'MedicamentosController@indexAll');
    Route::get('medicamentos/{id}', 'MedicamentosController@indexById');

    //ROTA DE ESPECIALIDADES
    Route::post('especialidades', 'EspecialidadeController@store');
    Route::put('especialidades/{id}', 'EspecialidadeController@update');
    Route::get('especialidades', 'EspecialidadeController@indexAll');
    Route::get('especialidades/{id}', 'EspecialidadeController@indexById');

    //ROTA DE CONSULTAS
    Route::post('consultas', 'ConsultaController@store')->middleware('check.consulta');
    Route::put('consultas/{id}', 'ConsultaController@update');
    Route::get('consultas', 'ConsultaController@indexAll');
    Route::get('consultas/{id}', 'ConsultaController@indexById');
    Route::delete('consultas/{id}', 'ConsultaController@delete');
});

Route::prefix('auth')->group(function(){
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('register', [RegisterController::class, 'register']);
});

