<?php

Route::group(array('prefix' => 'admin'), function()
{
	
	Route::get('/register',
		['as'	=>	'admin-register',
		 'uses'	=>	'AdminController@getRegister']);

	Route::get('/login',
		['as'	=>	'admin-login',
		 'uses'	=>	'AdminController@getLogin']);

	Route::get('/home', 
		['as'	=>	'admin-home',
		 'uses'	=>	'AdminController@home']);

	Route::get('/logout',
		['as'	=>	'admin-logout',
		 'uses'	=>	'AdminController@logout']);
///////////////////////////////////////////////////////////////////////////////////////////
	Route::group(array('before' => 'csrf'), function(){

		Route::post('/register',
			['as'	=>	'admin-register-post',
			 'uses'	=>	'AdminController@postRegister']);

		Route::post('/login',
			['as'	=>	'admin-login-post',
			 'uses'	=>	'AdminController@postLogin']);

	});
});