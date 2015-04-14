<?php

Route::group(array('prefix' => 'theatre'), function(){

	Route::get('/list/{status?}',
			['as'	=>	'theatre-list',
			 'uses'	=>	'TheatreController@getList']);

	Route::get('/create',
			['as'	=>	'theatre-create',
			 'uses'	=>	'TheatreController@getCreate']);

	Route::get('/view/{id}',
			['as'	=>	'theatre-view',
			 'uses'	=>	'TheatreController@view']);

	Route::get('/edit/{id}',
			['as'	=>	'theatre-edit',
			 'uses'	=>	'TheatreController@getEdit']);

	Route::group(array('before' => 'csrf'), function(){

		Route::post('/create',
				['as'	=>	'theatre-create-post',
				 'uses'	=>	'TheatreController@postCreate']);

		Route::post('/edit/{id}',
				['as'	=>	'theatre-edit-post',
				 'uses'	=>	'TheatreController@postEdit']);

		Route::post('/delete/{id?}/{status?}',
				['as'	=>	'theatre-delete-post',
				 'uses'	=>	'TheatreController@delete']);

		Route::post('/purge/{id?}',
				['as'	=>	'theatre-purge-post',
				 'uses'	=>	'TheatreController@purge']);

	});
});
