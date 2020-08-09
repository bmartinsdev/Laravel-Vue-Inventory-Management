<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/creditos','HomeController@creditos');

Route::middleware(['auth', 'is_admin'])->group(function () {
	Route::get('/definicoes', 'AdminController@definicoes')->name('definicoes');
	Route::get('/definicoes/estatisticas', 'AdminController@estatisticas')->name('estatisticas');
	Route::resource('/definicoes/i/inventarios', 'InventoryController');
	Route::post('/definicoes/i/inventarios/{inventoryID}/unidades', 'InventoryController@adicionarUnidades');
	Route::delete('/definicoes/i/inventarios/{inventoryID}/unidades/{unidadeID}', 'InventoryController@apagarUnidade');
	Route::resource('/definicoes/i/salas', 'RoomController');
	Route::resource('/definicoes/c/cacifos', 'LockerController');
	Route::resource('/definicoes/c/locais', 'AreaController');
	Route::resource('/definicoes/c/formandos', 'StudentController');
	Route::resource('/definicoes/c/turmas', 'CourseController');
	Route::resource('/definicoes/c/topologias', 'TypologyController');
	Route::resource('/definicoes/s/produtos', 'ProductController');
	Route::resource('/definicoes/s/categorias', 'ProductCategoryController');
	Route::resource('/definicoes/utilizadores', 'UserController');
});

Route::middleware('auth')->group(function () {
	Route::get('/', 'HomeController@index')->name('home');
	Route::get('/perfil', 'HomeController@perfil');
	Route::delete('/perfil', 'HomeController@apagarPerfil');
	Route::put('/perfil', 'HomeController@editarPerfil');
	//Redirect refreshed pages in vue
	Route::get('{path}', 'HomeController@vuerouter')->where('path', '([A-z\d-\/_.]+)?');
});


