<?php

////////////////////////////// Add these in route.php ///////////////////////////////

	Route::get('/fuckthisshit',
			['as'	=>	'inventory-fuckthisshit',
			 'uses'	=>	'InventoryController@fuckthisshit']);

	Route::group(array('before' => 'csrf'), function(){

	});
//////////////////////////////////////////////////////////////////////////////////////////

\//////////////////////////////////////////////// Add these in your controller //////////////////////////////////////////////////////////////////////////////////////////

public function fuckthisshit()
{

		 //add your code here

}

//////////////////////////////////////////////////////////////////////////////////////////

