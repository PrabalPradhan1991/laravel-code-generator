<?php

class AdminController extends BaseController
{
	protected $view = 'admin.views.';
	protected $model_name = 'Admin';

	public function getRegister()
	{
		return View::make($this->view.'register');
	}

	public function postRegister()
	{
		$input_data = Input::all();

		$modelName = $this->model_name;

		$result = $this->validateInput($modelName, $input_data);

	    if($result['status'] == 'error')
	    {
	    	return Redirect::route('admin-register')
	    					->with('errors', $result['message']);
	    }
	    else
	    {
	    	unset($input_data['confirm_password']);
	    	$input_data['password'] = Hash::make($input_data['password']);

	    	//store in database
	    	$result = $this->storeInDatabase($modelName, $input_data);

	    	return Redirect::route('admin-register')
	    					->with('global', 'successfully created account.');
	    }
	}

	public function getLogin()
	{
		return View::make($this->view.'login');
	}

	public function postLogin()
	{
		$input_data = Input::all();

		if(isset($data['remember']))
		{
			$remember = true;
		}
		else
		{
			$remember = false;
		}

		if(Auth::admin()->attempt(array('username' => $input_data['username'], 'password' => $input_data['password'], 'is_active' => 1), $remember))
		{
			return Redirect::route('admin-home');
		}
		else
		{
			return Redirect::route('admin-login')
							->withInput()
							->with('error', 'Invalid username-password combination or user not active');
		}
	}

	public function logout()
	{
		Auth::admin()->logout();
		if(Auth::admin()->check())
		{
			Session::put('global', 'Something went wrong. Please try again!');
			return Redirect::route('admin-home');
		}
		else
		{
			Session::put('global', 'Successfully logged out!');
			return Redirect::route('admin-login');	
		}
		
	}



}

?>