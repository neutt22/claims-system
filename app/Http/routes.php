<?php

Route::group(['middleware' => ['web']], function () {

	Route::auth();

	Route::get('email', 'ReportController@getEmail');

	Route::get('qr', 'ReportController@getQuickReport');

	Route::get('/new', 'HomeController@new_record');
	Route::get('/edit', 'HomeController@update_record');

	Route::post('/new', 'HomeController@post_new_record');
	Route::post('/edit', 'HomeController@post_update_record');

	Route::get('/reports', 'ReportController@getReport');

	Route::get('/logout', 'HomeController@getLogout');

	Route::get('/', function(){
		return redirect('/encoded/desc');
	});
	Route::get('/{column?}/{type?}', ['as' => 'home', 'uses' => 'HomeController@index'])->middleware('report-check');
});

