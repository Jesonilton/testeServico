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

Route::post('/importar-dados','ExcelController@import');
Route::get('/listar-todos','HistoricoMunicipiosController@listarTodos');
Route::get('/nome-municipios','HistoricoMunicipiosController@buscarNomeMunicipios');
Route::get('/filtrar-municipio','HistoricoMunicipiosController@filtrarPorMunicipio');
Route::get('/filtrar-municipio-data','HistoricoMunicipiosController@filtrarPorMunicipioData');






