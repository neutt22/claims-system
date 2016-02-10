<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

	Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

	Route::post('/new', 'HomeController@post_new_record');
	Route::post('/edit', 'HomeController@post_update_record');

	Route::get('/new', 'HomeController@new_record');
	Route::get('/edit', 'HomeController@update_record');

});