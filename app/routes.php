<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
/*chmod(app_path().'/controllers/test.php', 0777);
$lines = file(app_path().'/controllers/BaseController.php');

foreach($lines as $line)
{
    echo($line).'<br>';
    file_put_contents(app_path().'/controllers/test.php', $line, FILE_APPEND | LOCK_EX);
}
chmod(app_path().'/controllers/test.php', 0777);
die();
*/

include_once('constants.php');		


////////////////////////
/////THESE ARE SYSTEM Routes
////////////////////////////////
Route::post('/remove-global', array(
	'as'	=>	'remove-global',
	'uses'	=>	'SystemController@removeGlobal'));


/*************** This is test controller **********************************/
Route::get('/debug1', //array(
	//'as' => 'debug1',
	//'uses' => 'DebugController@index'));
	function(){
		return View::make('superAdmin.views.dashboard');
	});

Route::post('/debug2', array(
	'as' => 'debug2',
	'uses' => 'DebugController@check'));
/****************************************************************************/

Route::get('/generate', 'GeneratorController@getGeneratorForm');
Route::post('/generate-post', 'GeneratorController@postGeneratorForm');

/*************** These are required in all apps ****************************/
require_once(app_path().'/modules/superAdmin/route.php');
require_once(app_path().'/modules/admin/route.php');
require_once(app_path().'/modules/users/route.php');

/****************************************************************************/

//include_once(app_path().'/modules/moduleOne/route.php');
include_once(app_path().'/modules/inventory/route.php');
/************* Basic system routes ************************/

Route::post('/delete-session-data/{session_name}', 
		['as'	=>	'delete-session-data-post',
		 'uses'	=>	'SystemController@deleteSessionData']);

/***********************************************************/

Route::get('/', function()
{
	return View::make('moduleOne.views.hello');
});


/**************************************************************/
//////////// for error handling ///////////////////////////////
include_once('errors.php');
/****************************************************************/