<?php

Route::group(array('prefix' => 'inventory'), function(){

	Route::get('/list/{status?}',
			['as'	=>	'inventory-list',
			 'uses'	=>	'InventoryController@getList']);

	Route::get('/create',
			['as'	=>	'inventory-create',
			 'uses'	=>	'InventoryController@getCreate']);

	Route::get('/view/{id}',
			['as'	=>	'inventory-view',
			 'uses'	=>	'InventoryController@view']);

	Route::get('/edit/{id}',
			['as'	=>	'inventory-edit',
			 'uses'	=>	'InventoryController@getEdit']);

	Route::group(array('before' => 'csrf'), function(){

		Route::post('/create',
				['as'	=>	'inventory-create-post',
				 'uses'	=>	'InventoryController@postCreate']);

		Route::post('/edit/{id}',
				['as'	=>	'inventory-edit-post',
				 'uses'	=>	'InventoryController@postEdit']);

		Route::post('/delete/{id?}/{status?}',
				['as'	=>	'inventory-delete-post',
				 'uses'	=>	'InventoryController@delete']);

		Route::post('/purge/{id?}',
				['as'	=>	'inventory-purge-post',
				 'uses'	=>	'InventoryController@purge']);

	});
});
