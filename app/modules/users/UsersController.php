<?php

class UsersController extends BaseController
{
	protected $view = 'users.views.';

	public function getRegister()
	{
		return View::make($this->view.'register');
	}

	public function postRegister()
	{
		$input_data = Input::all();

		$modelName = 'Users';

		//dd($input_data);

		$result = $this->validateInput($modelName, $input_data);

	   // dd($result);
	    if($result['status'] == 'error')
	    {
	    	return Redirect::route('uesrs-register')
	    					->with('errors', $result['message']);
	    }
	    else
	    {
	    	unset($input_data['confirm_password']);


	    	//generate-confirmation
	    	$input_data['confirmation'] = str_random(60);
	    	$input_data['password'] = Hash::make($input_data['password']);
	    	//store in database
	    	$result = $this->storeInDatabase($modelName, $input_data);

	    	if($result['status'] == 'success')
	    	{
	    		//send email.
	    		$view = $this->view.'emails.confirmation';
	    		//link //id //code
	    		$confirmationLink = URL::route('users-confirmation', array($result['data'], $input_data['confirmation']));
	    		$parameters = array('link' => $confirmationLink, 'name' => $input_data['fname']);
	    		$mailDetails = array('email' => $input_data['email'], 'firstname' => $input_data['fname'] );
	    		$subject = 'confirmation';
	    		$result = $this->sendMailFunction($view, $parameters, $mailDetails, $subject);

	    		return Redirect::route('users-login')
	    					->with('global', 'successfully created account. Please check your email for confirmation. click here to resend confirmation');
	    	}
	    }

	}

	public function getConfirmation($id, $code)
	{
		$unConfirmedUser = Users::where('id', $id)
								->where('confirmation', '!=', '')
								->get();

		if(count($unConfirmedUser) == 1)
		{
			$modelName = 'Users';
			
			$data['confirmation'] = '1';
			$data['id'] = $id;

			$result = $this->updateInDatabase($modelName, $data);

			Session::put('global', $result['message']);

			if($result['status'] == 'success')
			{
				return Redirect::route('users-login');
				//log in user directly
			}
			else
			{
				return Redirect::route('users-login');
			}
		}
	}

	public function getLogin()
	{
		return View::make($this->view.'login');
	}

	public function postLogin()
	{
		$data = Input::all();
		//dd($data);
		if(isset($data['remember']))
		{
			$remember = true;
		}
		else
		{
			$remember = false;
		}

		if(Auth::user()->attempt(array('email' => $data['email'], 'password' => $data['password'], 'confirmation' => '1', 'is_active' => 1), $remember))
		{
			Session::put('global', 'successfully logged in');
			return Redirect::route('users-home');
		}
		else
		{
			Session::put('global', 'not logged in successfully');
			return Redirect::route('users-login')
							->with('error', 'Invalid username-password combination or email has not been confirmed')
							->withInput();
		}
	}

	public function logout()
	{
		Auth::user()->logout();

		Session::put('global', 'Successfully logged out!');
		return Redirect::route('users-login');
	}
}