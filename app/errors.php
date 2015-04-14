<?php


// for no record found in database
App::error(function(Illuminate\Database\Eloquent\ModelNotFoundException $exception){

    // Log the error
    Log::error($exception);

   
    // Redirect to error route with any message
    return View::make('errors.record-not-found');
});

App::missing(function($exception)
{
    return View::make('errors.route-not-found')
    			->with('check', 'check');
});

App::error(function(Symfony\Component\HttpKernel\Exception\HttpException $e, $code, $message){
	//echo $e->getMessage();
	//die();
	return View::make('errors.not-allowed');
});