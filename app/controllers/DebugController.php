<?php

class DebugController extends Controller
{
	public function index()
	{
		
		return View::make('debug.debug');
	}

	public function check()
	{
		print_r(Input::all());
		die();
	}
}

?>