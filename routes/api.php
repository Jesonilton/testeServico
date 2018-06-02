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

Route::post('/importar-convenios','ExcelController@import');

Route::get('/nome-municipios','ConveniosMunicipioController@buscarNomeMunicipios');
Route::get('/filtrar/{cod_municipio?}/{ano?}','ConveniosMunicipioController@filtrar');






