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

Route::get('i/salas', 'API\InventoryController@getAllRooms');
Route::get('i/salas/{sala}/unidades', 'API\InventoryController@getRoomInventory');
Route::put('i/salas/{sala}/unidades/{codigo}/mover', 'API\InventoryController@moveInventory');
Route::put('i/salas/{sala}/unidades/mover', 'API\InventoryController@bulkMoveInventory');
Route::get('i/unidades', 'API\InventoryController@getUnits');

Route::get('c/cacifos/', 'API\CacifosController@listAllCacifos');
Route::get('c/cacifos/{id}', 'API\CacifosController@updateCacifo');
Route::get('c/alunos/', 'API\CacifosController@filteredAlunos');
Route::get('c/estados/', 'API\CacifosController@getAllStates');
Route::get('c/topologias/', 'API\CacifosController@getAllTypologies');
Route::get('c/locais/', 'API\CacifosController@getAllAreas');
Route::put('c/cacifos/{id}/atribuir', 'API\CacifosController@updateStudents');

Route::get('s/consumiveis', 'API\ConsumiveisController@listAllConsumiveis');
Route::put('s/consumiveis/{id}/update', 'API\ConsumiveisController@updateConsumivel');
Route::get('s/categorias', 'API\ConsumiveisController@getAllCategories');

Route::get('stats/baixasconsumiveis', 'API\StatsController@baixasConsumiveis');
Route::get('stats/baixasinventario', 'API\StatsController@baixasInventario');
Route::get('stats/baixasinventariolocais', 'API\StatsController@baixasInventarioLocais');
Route::get('stats/registos', 'API\StatsController@listarLogs');
