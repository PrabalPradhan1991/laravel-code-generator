<?php

Route::get('/register',
	['as'	=>	'users-register',
	 'uses'	=>	'UsersController@getRegister']);

Route::get('/confirmation/{id}/{code}',
	['as'	=>	'users-confirmation',
	 'uses'	=>	'UsersController@getConfirmation']);

Route::get('/login',
	['as'	=>	'users-login',
	 'uses'	=>	'UsersController@getLogin']);

Route::get('/home', 
	['as'	=>	'users-home',
	 'uses'	=>	'UsersController@home']);


Route::get('/logout',
	['as'	=>	'users-logout',
	 'uses'	=>	'UsersController@logout']);

Route::group(array('before' => 'csrf'), function(){

	Route::post('/register',
		['as'	=>	'users-register-post',
		 'uses'	=>	'UsersController@postRegister']);

	Route::post('/login',
		['as'	=>	'users-login-post',
		 'uses'	=>	'UsersController@postLogin']);

});