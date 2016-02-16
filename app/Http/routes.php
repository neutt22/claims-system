<?php

Route::group(['middleware' => ['web']], function () {

	Route::auth();

	Route::get('/test', 'HomeController@getDeadLine');

	Route::get('/new', 'HomeController@new_record');
	Route::get('/edit', 'HomeController@update_record');

	Route::post('/new', 'HomeController@post_new_record');
	Route::post('/edit', 'HomeController@post_update_record');

	Route::get('/logout', 'HomeController@getLogout');

	Route::get('/', function(){
		return redirect('/encoded/desc');
	});
	Route::get('/{column?}/{type?}', ['as' => 'home', 'uses' => 'HomeController@index']);
});

