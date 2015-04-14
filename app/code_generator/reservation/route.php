<?php

Route::group(array('prefix' => 'reservation'), function(){

	Route::get('/list/{status?}',
			['as'	=>	'reservation-list',
			 'uses'	=>	'ReservationController@getList']);

	Route::get('/create',
			['as'	=>	'reservation-create',
			 'uses'	=>	'ReservationController@getCreate']);

	Route::get('/view/{id}',
			['as'	=>	'reservation-view',
			 'uses'	=>	'ReservationController@view']);

	Route::get('/edit/{id}',
			['as'	=>	'reservation-edit',
			 'uses'	=>	'ReservationController@getEdit']);

	Route::group(array('before' => 'csrf'), function(){

		Route::post('/create',
				['as'	=>	'reservation-create-post',
				 'uses'	=>	'ReservationController@postCreate']);

		Route::post('/edit/{id}',
				['as'	=>	'reservation-edit-post',
				 'uses'	=>	'ReservationController@postEdit']);

		Route::post('/delete/{id?}/{status?}',
				['as'	=>	'reservation-delete-post',
				 'uses'	=>	'ReservationController@delete']);

		Route::post('/purge/{id?}',
				['as'	=>	'reservation-purge-post',
				 'uses'	=>	'ReservationController@purge']);

	});
});
