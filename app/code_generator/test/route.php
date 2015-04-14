<?php

Route::group(array('prefix' => 'test'), function(){

	Route::get('/list/{status?}',
			['as'	=>	'test-list',
			 'uses'	=>	'TestController@getList']);

	Route::get('/create',
			['as'	=>	'test-create',
			 'uses'	=>	'TestController@getCreate']);

	Route::get('/view/{id}',
			['as'	=>	'test-view',
			 'uses'	=>	'TestController@view']);

	Route::get('/edit/{id}',
			['as'	=>	'test-edit',
			 'uses'	=>	'TestController@getEdit']);

	Route::group(array('before' => 'csrf'), function(){

		Route::post('/create',
				['as'	=>	'test-create-post',
				 'uses'	=>	'TestController@postCreate']);

		Route::post('/edit/{id}',
				['as'	=>	'test-edit-post',
				 'uses'	=>	'TestController@postEdit']);

		Route::post('/delete/{id?}/{status?}',
				['as'	=>	'test-delete-post',
				 'uses'	=>	'TestController@delete']);

		Route::post('/purge/{id?}',
				['as'	=>	'test-purge-post',
				 'uses'	=>	'TestController@purge']);

	});
});
