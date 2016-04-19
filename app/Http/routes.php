<?php

/*
|--------------------------------------------------------------------------
| Rutas publicas y de logueo
|--------------------------------------------------------------------------
|
| Aqui se definen las rutas publicas y el acceso al sistema
|
*/

Route::group(['middleware' => ['web']], function () {
    
	Route::get('/', 'IndexController@index');

	Route::post('fichaje', 'RegistroController@fichaje');

	Route::post('auth/login', 'Auth\AuthController@postLogin');

	Route::get('auth/logout', 'Auth\AuthController@getLogout');
    
});

/*
|--------------------------------------------------------------------------
| Rutas privadas
|--------------------------------------------------------------------------
|
| Aqui se definen las rutas cuyo acceso solo es posible identificado
|
*/

Route::group(['middleware' => 'web'], function () {

    Route::auth();

    Route::get('/backend', 'BackendController@backend');

    Route::get('/crear_usuario', ['middleware' => 'permisos' , function(){

    	return view('crear_usuario');
    }]);

    Route::post('/register_user','BackendController@crear_usuario');

    Route::delete('/backend/quitar/{id}', 'BackendController@destroy');

    Route::post('/backend/agregar', 'BackendController@agregar');

    Route::post('/backend/emergencia', 'BackendController@emergencia');

	Route::post('/backend/agregarPersona', 'BackendController@agregarPersona');

	Route::post('/backend/quitar/{id}', 'BackendController@destroy');
});
