<?php

Route::group(array('prefix' => 'superadmin'), function()
{
	Route::get('/register',
		['before' => 'reg-superadmin',
		 'as'	=>	'register-superadmin',
		 'uses'	=>	'SuperAdminController@getRegister']);

/////////////////////////////////////////////////////////////////////////////////////
	Route::get('/login',
		['before' => 'guest-superadmin',
		 'as'	=>	'login-superadmin',
		 'uses'	=>	'SuperAdminController@getLogin']);

////////////////////////////////////////////////////////////////////////////////////////
	Route::get('/create-group',
		['before' => 'reg-superadmin',
		 'as'	=>	'create-group',
		 'uses'	=>	'SuperAdminController@getCreateGroup']);

	Route::get('/list-groups', 
		['before' => 'reg-superadmin', 
		 'as'	=>	'list-groups',
		 'uses'	=>	'SuperAdminController@listGroups']);

	Route::get('/edit-group/{id}',
		['before' => 'reg-superadmin',
		 'as'	=>	'edit-group',
		 'uses'	=>	'SuperAdminController@getEditGroup']);
//////////////////////////////////////////////////////////////////////////////////////

	Route::get('/create-module',
		['before' => 'reg-superadmin',
		 'as'	=>	'create-module',
		 'uses'	=>	'SuperAdminController@getCreateModule']);

	Route::get('/list-modules',
		['before' => 'reg-superadmin',
		 'as'	=>	'list-modules',
		 'uses'	=>	'SuperAdminController@listModules']);
///////////////////////////////////////////////////////////////////////////////////////	
	Route::get('/create-module-function/{controller_id}',
		['before' => 'reg-superadmin',
		 'as'	=>	'create-module-function',
		 'uses'	=>	'SuperAdminController@getCreateModuleFunction']);

	Route::get('/list-module-functions/{controller_name}',
		['before' => 'reg-superadmin',
		 'as'	=>	'list-module-funcitons',
		 'uses'	=>	'SuperAdminController@listModuleFunctions']);
/////////////////////////////////////////////////////////////////////////////////////////
	Route::get('/set-permissions',
		['before' => 'reg-superadmin',
		 'as'	=>	'set-permissions',
		 'uses'	=>	'SuperAdminController@getSetPermissions']);


	Route::get('/edit-permissions/{id}',
		['before' => 'reg-superadmin',
		 'as'	=>	'edit-permissions',
		 'uses'	=>	'SuperAdminController@getEditPermissions']);


	Route::get('/list-permissions/{controller_id}',
		['before' => 'reg-superadmin',
		 'as'	=>	'list-permissions',
		 'uses'	=>	'SuperAdminController@listPermissions']);
/////////////////////////////////////////////////////////////////////////////////////////////

	Route::get('/home', 
		['before' => 'reg-superadmin',
		 'as'	=>	'superadmin-home',
		 'uses'	=>	'SuperAdminController@home']);
/////////////////////////////////////////////////////////////////////////////////////////////
	
	Route::get('/logout',
		['before' => 'reg-superadmin',
		 'as'	=>	'superadmin-logout',
		 'uses'	=>	'SuperAdminController@logout']);
////////////////////////////////////////////////////////////////////////////////////////////////	
	
	Route::get('generate-route', 
	['before' => 'reg-superadmin',
	 'as'	=> 'generate-route-superadmin',
	 'uses'	=> 'SuperAdminController@getGenerateRoute']);
////////////////////////////////////////////////////////////////////////////////////////////////
	
	Route::get('list-admins', 
	['before' => 'reg-superadmin',
	 'as'	=> 'list-admins',
	 'uses'	=> 'SuperAdminController@getAdminList']);

////////////////////////////////////////////////////////////////////////////////////////////////

	Route::get('set-temporary-permissions', 
	['before' => 'reg-superadmin',
	 'as'	=> 'set-temporary-permissions',
	 'uses'	=> 'SuperAdminController@getSetTemporaryPermissions']);

	Route::get('edit-temporary-permissions/{id}', 
				['before' => 'reg-superadmin',
				 'as'	=> 'edit-temporary-permissions',
				 'uses'	=> 'SuperAdminController@getEditTemporaryPermissions']);
			

////////////////////////////////////////////////////////////////////////////////////////////////

	Route::group(array('before' => 'csrf'), function(){

		Route::post('/register',	
		   ['before' => 'reg-superadmin',
		    'as' 	=> 'register-superadmin-post',
			'uses' 	=> 'SuperAdminController@postRegister']);
////////////////////////////////////////////////////////////////////////////////////////////////////
		Route::post('/login', 
			['before' => 'guest-superadmin',
			 'as'	=>	'login-superadmin-post',
			 'uses'	=>	'SuperAdminController@postLogin']);
////////////////////////////////////////////////////////////////////////////////////////////////////
		Route::post('/create-group', 
			['before' => 'reg-superadmin',
			 'as' 	=> 'create-group-post',
			 'uses'	=> 'SuperAdminController@postCreateGroup']);

		Route::post('/edit-group/{id}', 
			['before' => 'reg-superadmin',
			 'as' 	=> 'edit-group-post',
			 'uses'	=> 'SuperAdminController@postEditGroup']);

//////////////////////////////////////////////////////////////////////////////////////////////////////
		Route::post('/create-module',
			['before' => 'reg-superadmin',
			 'as'	=> 'create-module-post',
			 'uses'	=> 'SuperAdminController@postCreateModule']);
/////////////////////////////////////////////////////////////////////////////////////////////////////
		Route::post('/create-module-funciton/{controller_id}',
			['before' => 'reg-superadmin',
			 'as'	=>	'create-module-function-post',
			 'uses'	=>	'SuperAdminController@postCreateModuleFunction']);
////////////////////////////////////////////////////////////////////////////////////////////////////////
		Route::post('/set-permissions',
			['before' => 'reg-superadmin',
			 'as'	=>	'set-permissions-post',
			 'uses'	=>	'SuperAdminController@postSetPermissions']);
////////////////////////////////////////////////////////////////////////////////////////////
		Route::post('/edit-permissions/{id}',
			['before' => 'reg-superadmin',
			 'as'	=>	'edit-permissions-post',
			 'uses'	=>	'SuperAdminController@postEditPermissions']);

		Route::post('/delete-permissions',
			['before' => 'reg-superadmin',
			 'as'	=>	'delete-permissions-post',
			 'uses'	=>	'SuperAdminController@deletePermissions']);	
//////////////////////////////////////////////////////////////////////////////////////////////
		Route::post('/generate-route', 
			['before' => 'reg-superadmin',
			 'as'	=> 'generate-route-superadmin-post',
			 'uses'	=> 'SuperAdminController@postGenerateRoute']);
////////////////////////////////////////////////////////////////////////////////////////////
		
		Route::post('delete-admins', 
				['before' => 'reg-superadmin',
				 'as'	=> 'delete-admins-post',
				 'uses'	=> 'SuperAdminController@postDeleteAdmins']);
///////////////////////////////////////////////////////////////////////////////////////////////

		Route::post('set-temporary-permissions', 
				['before' => 'reg-superadmin',
				 'as'	=> 'set-temporary-permissions-post',
				 'uses'	=> 'SuperAdminController@postSetTemporaryPermissions']);

		Route::post('edit-temporary-permissions/{id}', 
				['before' => 'reg-superadmin',
				 'as'	=> 'edit-temporary-permissions-post',
				 'uses'	=> 'SuperAdminController@postEditTemporaryPermissions']);
	});
///////////////////////////////////////////////////////////////////////////////////////////////
	Route::post('/add-header', 
		['as' => 'add-header',
		'uses' => 'SuperAdminController@postAddTableHeaders']);
});
