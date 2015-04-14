<?php

Route::group(array('prefix' => 'parentTheatre'), function(){

	Route::get('/list/{status?}',
			['as'	=>	'parentTheatre-list',
			 'uses'	=>	'ParentTheatreController@getList']);

	Route::get('/create',
			['as'	=>	'parentTheatre-create',
			 'uses'	=>	'ParentTheatreController@getCreate']);

	Route::get('/view/{id}',
			['as'	=>	'parentTheatre-view',
			 'uses'	=>	'ParentTheatreController@view']);

	Route::get('/edit/{id}',
			['as'	=>	'parentTheatre-edit',
			 'uses'	=>	'ParentTheatreController@getEdit']);

	Route::group(array('before' => 'csrf'), function(){

		Route::post('/create',
				['as'	=>	'parentTheatre-create-post',
				 'uses'	=>	'ParentTheatreController@postCreate']);

		Route::post('/edit/{id}',
				['as'	=>	'parentTheatre-edit-post',
				 'uses'	=>	'ParentTheatreController@postEdit']);

		Route::post('/delete/{id?}/{status?}',
				['as'	=>	'parentTheatre-delete-post',
				 'uses'	=>	'ParentTheatreController@delete']);

		Route::post('/purge/{id?}',
				['as'	=>	'parentTheatre-purge-post',
				 'uses'	=>	'ParentTheatreController@purge']);

	});
});
