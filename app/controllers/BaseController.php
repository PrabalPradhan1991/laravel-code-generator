<?php

class BaseController extends SystemController {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$currentRouteName = Route::currentRouteName();

		$allowedRoutes = array('admin-register', 'admin-register-post', 'admin-login', 'admin-login-post', 'users-register', 'users-confirmation', 'users-login', 'users-logout', 'users-register-post', 'users-login-post', 'admin-logout');
		
		if(in_array($currentRouteName, $allowedRoutes))
		{
			return true;
		}
		
			$message = '';
			$access = false;


			if(Auth::superAdmin()->check())
			{
				$access = true;
			}
			else
			{
				$allowedGroups = DB::table(Permission::getTableName().' AS P')
									->join(ModuleFunction::getTableName().' AS MF', 'MF.id', '=', 'P.module_function_code_id')
									->where('MF.module_function_code', $currentRouteName)
									->where('P.is_active', 1)
									->where('MF.is_active', 1)
									->get(array('allowed_groups'));

				
				if(count($allowedGroups))
				{
					$allowedGroups = HelperController::getAllowedGroups($allowedGroups[0]->allowed_groups);
				 
					foreach($allowedGroups as $allowedGroup)
					{
					 	if($allowedGroup == 0)
					 	{
					 		$access = true;
					 		break;
					 	}

					 	if(Auth::admin()->check() && $allowedGroup == Auth::admin()->user()->group_id )
					 	{
					 		$access = true;
					 		break;
					 	}
					}		
				}
				//checking in temporary permissions table
				else if(Auth::admin()->check() && Auth::admin()->user()->temp_permission == 1)
				{
					$temporaryPermissions = TemporaryPermission::where('admin_id', Auth::admin()->user()->id)
														->where('is_active', 1)
														->firstOrFail();

					if(strtotime($temporaryPermissions->expiry_date) < time())
					{
						Queue::push('ListenersController@temporaryPermissionExpire', array('data' => Auth::admin()->user()->id));
						//trigger an event to delete the permissions and change the temp_permission field to 0 in admin table
						$access = false;
						$message = "All your temporary permissions have expired";

					}

					$allowedRoutes = HelperController::getAllowedGroups($temporaryPermissions->module_function_id);

					$routes = ModuleFunction::whereIn('id', $allowedRoutes)
											->where('is_active', 1)
											->lists('module_function_code');
					
					if(in_array($currentRouteName, $routes))
					{
						$access = true;
					}
					else
					{
						$access = false;
						$message = 'You are not allowed to view this page';
					}
				}
				
			}

			if(!$access)
			{
			 	App::abort(403, $message);
			}
	}

	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
/******************************************************************************************************/

///////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////	
	public function getList($status = 1)
	{
		$model_name = $this->model_name;


		//get table headers here;
		$controller_name = $this->model_name.'Controller';

		$queryString = Input::query();
		
		if(isset($queryString['paginate']))
		{
			$queryString['paginate'] = ($queryString['paginate'] == 0) ? 10 : $queryString['paginate'];	
		}
		else
		{
			$queryString['paginate'] = 10;	
		}

		if(!isset($queryString['status']))
		{
			$queryString['status'] = 1;
		}
		
		

		if($queryString['status'] == 1 || $queryString['status'] == 0)
		{
			$data = $model_name::where('is_active', $status);

			if(isset($queryString['column_name']) && isset($queryString['column_value']))
			{
				$data->where($queryString['column_name'], 'LIKE', '%'.$queryString['column_value'].'%');
			}
				
			$data = $data->paginate($queryString['paginate']);
		}
		else
		{
			if(isset($queryString['column_name']) && isset($queryString['column_value']))
			{
				$data = $model_name::where($queryString['column_name'], 'LIKE', '%'.$queryString['column_value'].'%')->paginate($queryString['paginate']);
			}
			else
			{
				$data = $model_name::paginate($queryString['paginate']);	
			}
			
		}
		

		$count = count($data);
		if($count)
		{
			$arr = array('count' => $count, 'data' => $data);
		}
		else
		{
			$arr = array('count' => $count, 'message' => 'No items found');
		}

		return View::make($this->view.'list')
					->with('arr', $arr)
					->with('status', $status)
					->with('queryString', $queryString);
	}
//////////////////////////////////////////////////////////////////////////////////////////////
	protected function getCreate()
	{
		return View::make($this->view.'create');
	}
///////////////////////////////////////////////////////////////////////////////////////
	protected function postCreate()
	{
		$input_data = Input::all();

			$result = $this->validateInput($this->model_name, $input_data);

		    if($result['status'] == 'error')
		    {
		    	return Redirect::route($this->module_name.'-create')
		    					->with('errors', $result['message']);
		    }
		    else
		    {
		    	$result = $this->storeInDatabase($this->model_name, $input_data);

		    	if(isset($input_data['addNew']) && $input_data['addNew'] == 'y')
		    	{
		    		return Redirect::route($this->module_name.'-create')
		    					->with('global', 'record successfully added');
		    	}
		    	else
		    	{
		    		return Redirect::route($this->module_name.'-list')
		    					->with('global', 'record successfully added');
		    	}
		    	
		    	
		    }

	}

////////////////////////////////////////////////////////////////////////////////////////////////////
	public function view($id)
	{

		$model_name = $this->model_name;
		$data = $model_name::where('is_active', 1)
							->where('id', $id)
							->firstOrFail();

		return View::make($this->view.'view')
					->with('data', $data);

	}
////////////////////////////////////////////////////////////////////////////////////////////////////
	public function getEdit($id)
	{
		$model_name = $this->model_name;
		$data = $model_name::where('id', $id)
							 ->firstOrFail();

		return View::make($this->view.'edit')
					->with('data', $data);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function postEdit($id)
	{
		$input_data = Input::all();

		$result = $this->validateInput($this->model_name, $input_data, true); //true means this is updatecheck

		    if($result['status'] == 'error')
		    {
		    	return Redirect::route($this->module_name.'-edit')
		    					->with('errors', $result['message']);
		    }
		    else
		    {
		    
		    	$input_data['id'] = $id;
		    	$result = $this->updateInDatabase($this->model_name, $input_data);

		    	return Redirect::route($this->module_name.'-list')
		    					->with('global', 'record successfully updated');	
		    }
	}
///////////////////////////////////////////////////////////////////////////////////////////////////////
	public function delete($id = 0, $status = 1, $model_name = '')
	{

		$arr = array();
		$success = '';
		$error = '';
		$message = '';
		$model_name = ($model_name == '') ? $this->model_name : $model_name;

		if($id == 0)
		{
			$dataToDelete = Input::get('data'); //these are ids that are to be deleted	
			$rowNums = $dataToDelete[1];
			$dataToDelete = $dataToDelete[0];
		}
		else
		{
			$dataToDelete = array($id);
		}
		

		//for single data to delete
		//if(count($dataToDelete == 1))
		if($id != 0)
		{
			try
			{

				$result = $model_name::where('id', $dataToDelete[0])
								   			->first();
				$flag = false;
				if($result->is_active == 0)
				{
					$status = 'error';
					$message = 'already deleted';
					$flag = true;
				}
				else
				{
					$result->is_active = 0;
					$result->save();
				}

				if(!$flag)
				{
					$status = 'success';
					$message = "successfully deleted";
				}
			}
			catch(PDOException $e)
			{
				$status = 'error';
				$message = 'could not be deleted. Please try again';
			}

			if(Request::ajax())
			{
				
				return json_encode(array('status' => $status, 'message' => $message));
			}
			else
			{
				return Redirect::route($this->module_name.'-list', 0)
							->with('global', $message);		
			}
		}
		else
		{
			if($dataToDelete == '' || !preg_match('/(^([0-9]+,)+[0-9]+$)|(^[0-9]+$)/', $dataToDelete))
			{
				$message = 'ids not given or given in invalid format';
				Session::put('global', $message);
				return Redirect::route($this->module_name.'-list', array($status));
			}

			$dataToDelete = explode(',', $dataToDelete);
			$rowNums = explode(',', $rowNums);
			//print_r($dataToDelete);
			//die();
			foreach($dataToDelete as $index => $data)
			{
				try
				{

					$result = $model_name::where('id', $data)
									   			->firstOrFail();
					
					
					if($result->is_active == 0)
					{
						$error .= '<p>'.$result->id.' already deleted</p>';
					}
					else
					{
						$result->is_active = 0;
						$result->save();
						//$success++;
					}
				}
				catch(PDOException $e)
				{
					$error .= '<p>'.$result->id.' could not be deleted</p>';
				}
			}

			if($error == '')
			{
				$message = '<p>All records successfully deleted</p>';
			}
			else
			{
				$message = $error;
			}

			Session::put('global', $message);
			return Redirect::route($this->module_name.'-list', array($status));
								
		}
	}
	//////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function purge($id = 0)
	{
		$arr = array();
		$success = '';
		$error = '';
		$message = '';
		$model_name = $this->model_name;

		if($id == 0)
		{
			$dataToDelete = Input::get('data'); //these are ids that are to be deleted	
			$rowNums = $dataToDelete[1];
			$dataToDelete = $dataToDelete[0];
		}
		else
		{
			$dataToDelete = array($id);
		}
		

		//for single data to delete
		if($id != 0)
		{

			try
			{

				$result = $model_name::where('id', $dataToDelete[0])
								   			->first();
				$flag = false;
				if($result->is_active == 1)
				{
					$status = 'error';
					$message = 'data is live. Please delete it first';
					$flag = true;
				}
				else
				{
					$result = $model_name::where('id', $dataToDelete[0])
											->where('is_active', 0)
								   			->delete();
				}

				if(!$flag)
				{
					$status = 'success';
					$message = "successfully deleted";
				}
			}
			catch(PDOException $e)
			{
				$status = 'error';
				$message = 'could not be deleted. Please try again';
			}

			if(Request::ajax())
			{
				
				return json_encode(array('status' => $status, 'message' => $message));
			}
			else
			{
				return Redirect::route($this->module_name.'-list', 2)
							->with('global', $message);		
			}
		}
		else
		{
			$dataToDelete = explode(',', $dataToDelete);
			$rowNums = explode(',', $rowNums);
			
			foreach($dataToDelete as $index => $data)
			{
				try
				{
					$result = $model_name::where('id', $data)
									   			->first();
					
					if($result->is_active == 1)
					{
						$error .= '<p>'.$result->id.' is live. Please delete it first</p>';
					}
					else
					{
						$result = $model_name::where('id', $data)
									   			->delete();
					}
				}
				catch(PDOException $e)
				{
					$error .= '<p>'.$result->id.' is live. Please delete it first</p>';
				}
			}

			if($error == '')
			{
				$message = '<p>All records successfully deleted</p>';
			}
			else
			{
				$message = $error;
			}

			Session::put('global', $message);
			return Redirect::route($this->module_name.'-list', 2);
		}
		
	}

///////////////////////////////////////////////////////////////////////////////////////////////////////////
/*******************************************************************************************************/

	
}
