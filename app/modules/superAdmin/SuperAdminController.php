<?php

class SuperAdminController extends SystemController
{
	protected $view = 'superAdmin.views.';
	protected $model_name = 'SuperAdmin';
	

	public function __construct()
	{
		$allowedRoutes = array('login-superadmin', 'login-superadmin-post');
		
		if(in_array(Route::currentRouteName(), $allowedRoutes))
		{
			return true;
		}

		if(Auth::superAdmin()->guest())
		{
			App::abort(403, 'Only superadmins can view this page');
		}
	}

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
	    	return Redirect::route('register-superadmin')
	    					->with('errors', $result['message']);
	    }
	    else
	    {
	    	unset($input_data['confirm_password']);
	    	$input_data['password'] = Hash::make($input_data['password']);

	    	//store in database
	    	$result = $this->storeInDatabase($modelName, $input_data);

	    	return Redirect::route('register-superadmin')
	    					->with('global', 'successfully created account.');
	    	
	    }

	    
	}
//////////////////////////////////////////////////////////////////////////////
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

		if(Auth::superAdmin()->attempt(array('username' => $input_data['username'], 'password' => $input_data['password'], 'is_active' => 1), $remember))
		{
			return Redirect::route('superadmin-home');
		}
		else
		{
			return Redirect::route('login-superadmin')
							->withInput()
							->with('error', 'Invalid username-password combination or user not active');
		}
	}
////////////////////////////////////////////////////////////////////////////////
	public function getCreateGroup()
	{
		return View::make($this->view.'create-group');
	}

	public function postCreateGroup()
	{

		$input_data = Input::all();
		$modelName = 'Group';
		
		$result = $this->storeInDatabase($modelName, $input_data);
		
		Session::put('global', $result['message']);

		return Redirect::route('list-groups');
	}
////////////////////////////////////////////////////////////////////////////////
	public function listGroups()
	{
		$queryString = Input::query();

		$status = isset($queryString['status']) ? $queryString['status'] : 1;

		if($status == 0 | $status == 1)
		{
			$data =  Group::where('is_active', $status)->get();	
		}
		else
		{
			$data = Group::all();
		}
		
			

		if(count($data))
		{
			$arr = array('count' => true, 'data' => $data);
		}
		else
		{
			$arr = array('count' => false, 'message' => 'No items to dispaly');
		}

		return View::make($this->view.'list-groups')
					->with('arr', $arr);
	}
////////////////////////////////////////////////////////////////////////////////////
	public function getEditGroup($group_id)
	{
		$group = Group::findOrFail($group_id);

		return View::make($this->view.'edit-group')
					->with('group', $group);
	}

	public function postEditGroup($id)
	{
		$input_data = Input::all();
		$modelName = 'Group';
		$result = $this->updateInDatabase($modelName, $input_data);

		Session::put('global', $result['message']);

		return Redirect::route('list-groups');
	}

	public function deleteGroup($id)
	{

	}
///////////////////////////////////////////////////////////////////////////////////////
//no need of this funciton	
	public function getSetPermissions()
	{
		return View::make($this->view.'set-permissions');
	}

//no need of this funciton
	public function postSetPermissions()
	{
		
		
		

	}
//////////////////////////////////////////////////////////////////////////////////////////////

//no need of this funciton
	public function getEditPermissions($controller_id)
	{
		return View::make($this->view.'edit-permissions');
	}


	public function postEditPermissions($controller_id)
	{
		
		$input = Input::all();
		if(isset($input['_token']))
		{
			unset($input['_token']);
		}

		//empty the permissions table
		//DB::statement("SET foreign_key_checks=0");
		//Permission::truncate();

		//echo '<pre>';
		//print_r($input);
		//die();

		$errors = '';

		$route_names = array();

		foreach($input as $in => $val)
		{
			if(strpos($in, 'route'))
			{
				preg_match('/[0-9]+/', $in, $matches);
				
				$route_names[$matches[0]] = '';
			}
			else
			{
				$data = explode('-', $in);
			
				if(isset($route_names[$data[0]]))
				{
					$route_names[$data[0]] .= '::'.$data[1].'::;';
				}
			}		
		}


			foreach($route_names as $index => $val)
			{
				try
				{
					$dataToStore = Permission::firstOrCreate(array('module_function_code_id' => $index));
					$dataToStore->allowed_groups = $val;
					$dataToStore->is_active = 1;
					$dataToStore->save();		
				}
				catch(PDOException $e)
				{
					$errors .= $val.' not successfully updated/created<br>';
				}
			}

			if($errors == '')
			{
				$message = 'permissions successfully updated in database';
			}
			else
			{
				$message = $errors;
			}

		Session::put('global', $message);

		return Redirect::route('list-permissions', $controller_id);
	}

	public function listPermissions($controller_id)
	{
		$permissions = ModuleFunction::with('permissions')->with('modulecontroller')
									 ->where('module_id', $controller_id)
									 ->where('is_active', 1)
									 ->get();

		$controller_name = $permissions[0]->modulecontroller->module_name;
		

		$groups = Group::where('is_active', 1)
						->lists('group_name', 'id');
		
		if(count($permissions))
		{
			$arr = array('count' => true, 'data' => $permissions);
		}
		else
		{
			$arr = array('count' => false, 'message' => 'No data to display');
		}

		return View::make($this->view.'list-permissions')
					->with('arr', $arr)
					->with('groups', $groups)
					->with('controller_id', $controller_id)
					->with('controller_name', $controller_name);
	}
	
//////////////////////////////////////////////////////////////////////////////////////////////////
	public function deletePermissions()
	{
		Route::currentRouteName(Request::url());
		die();
	}
///////////////////////////////////////////////////////////////////////////////////////////////////
	public function getCreateModule()
	{
		return View::make($this->view.'create-module');
	}

	public function postCreateModule()
	{
		$input_data = Input::all();
		$input_data['module_name'] = ucfirst($input_data['model_name']).'Controller';
		$modelName = 'Module';



		$result = $this->validateInput($modelName, $input_data);
		
		if($result['status'] == 'error')
	    {
	    	return Redirect::route('create-module')
	    					->with('errors', $result['message']);
	    }
	    else
	    {
	    	$result = $this->storeInDatabase($modelName, $input_data);

	    	return Redirect::route('create-module')
	    					->with('global', 'successfully created Model.');
	    	
	    }

	}
/////////////////////////////////////////////////////////////////////////////////////////////////
	public function listModules() //modules are controllers
	{
		$modules = Module::all();
		
		$count = count($modules);
		
		if($count)
		{
			$arr = array('count' => $count, 'data' => $modules);
		}
		else
		{
			$arr = array('count' => $count, 'message' => 'No modules to display');
		}
		
		
		return View::make($this->view.'list-module')
					->with('arr', $arr);
	}

/////////////////////////////////////////////////////////////////////////////////////////////////
	public function getCreateModuleFunction($controller_id)
	{
		$data = Module::where('id', $controller_id)
						->where('is_active', 1)
						->firstOrFail();

		$indexOfController = strpos($data->module_name, 'Controller');
		
		
		if($indexOfController)
		{
			$module_name = lcfirst(substr($data->module_name, 0, $indexOfController));

			return View::make($this->view.'create-module-function')
					->with('controller_id', $controller_id)
					->with('controller_name', $data->module_name)
					->with('module_name', $module_name);
		}
		else
		{
			echo 'invalid controllername. Must be in the format ModulenameController';
			die();
		}

		
	}

	public function postCreateModuleFunction($controller_id)
	{
		$store_in_db = true;
		$errors = '';
		$filecontent = '';

		$input_data = Input::all();
		
		$module_name = Input::get('module_name');
		$controller_name = Input::get('controller_name');
		
		//echo '<pre>';
		//print_r($input_data);
		//die();
		
		/////////////////////////////////////////////////////////////////////////////////
		////////////////////////// Getting input in required format ////////////////////
		////////////////////////////////////////////////////////////////////////////////
		foreach($input_data as $key => $val)
		{
			if(strpos($key, 'route_type'))
			{
				$route_types[] = $val;
			}
			else if(strpos($key, 'route'))
			{
				$route_names[] = $val;
			}
			else if(strpos($key, 'function'))
			{
				$function_names[] = $val;
			}
			else if(strpos($key, 'url'))
			{
				$urls[] = $val;
			}	
		}
		//////////////////////////////////////////////////////////////////////////////
		//////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////
		

		/////////////////////////////////////////////////////////////////////////////////////
		//////////////////// only do further actions if user has given routes /////////////////
		///////////////////////////////////////////////////////////////////////////////////////
		if(isset($route_types) && count($route_types))
		{
			$getOrPosts = $this->seperateGetOrPost($route_types);

			//Helper::checkDuplicateNameInDatabase($model_name, $column_name, $text_to_check);
			foreach($getOrPosts as $getOrPost)
			{
				if(count($getOrPost))
				{
					foreach($getOrPost as $index)
					{
						$temp = array();
						
						$temp['type'] = $route_types[$index];
						$temp['url'] = $urls[$index];
						$temp['route_name'] = $route_names[$index];
						$temp['function_name'] = $function_names[$index];

						//////////////////////////////////////////////////////////
						///////// this is for testing purpose only ///////////////
						///////////////////////////////////////////////////////////
						if($store_in_db)
						{
							if($controller_id != 0)
							{
								try
								{
										$module_function_code = $temp['type'] == 'get' ? $module_name.'-'.$temp['route_name'] : $module_name.'-'.$temp['route_name'].'-post';

										$result = HelperController::checkDuplicateNameInDatabase('ModuleFunction', 'module_function_code', $module_function_code);
										if($result['status'] == 'success')
										{
											DB::connection()->getPdo()->beginTransaction();

											$id = ModuleFunction::Create(array('module_id'				=> $controller_id,
														      		 'module_function_code'		=> $module_function_code,
														      		 'is_active'				=> 1))->id;

											Permission::firstOrCreate(array('module_function_code_id'	=>	$id,
													 'allowed_groups'			=>	'::1::;::2::',
													 'is_active'				=>	1));	

											DB::connection()->getPdo()->commit();
										}
										else
										{
											$errors .= '<p>'.$result['message'].'</p>';
										}
										
								}
								catch(PDOException $e)
								{
									DB::connection()->getPdo()->rollBack();

									$errors .= '<p>'.$module_function_code.' could not be stored in '.ModuleFunction::getTableName().'</p>';
								}
							}	
						}
						
						$arrs[] = $temp;
					}
				}
			}

			

			///////////////////////////////////////////////////////////////////////////////////
			////////////////////// generate file /////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////////
			
			////////////////////////// Routes ////////////////////////////////////////////////////
			$filecontent .= "<?php\n\n";
			$filecontent .= '////////////////////////////// Add these in route.php ///////////////////////////////'."\n\n";
			foreach($arrs as $arr)
			{
				if($arr['type'] == 'get')
				{
					$filecontent .= "\t".'Route::'.$arr['type'].'('."'/".$arr['url']."',\n";
				
					//$this->routeNameToStoreInDb[] = $module_name.'-'.$arr['route_name'];
					$filecontent .= "\t\t\t"."['as'"."\t".'=>'."\t'".$module_name.'-'.$arr['route_name']."',\n";
					$filecontent .= "\t\t\t "."'uses'"."\t".'=>'."\t'".$controller_name."@".$arr['function_name']."']);\n\n";	
				}
					
				
			}

			$filecontent .= "\tRoute::group(array('before' => 'csrf'), function(){\n\n";

			/*echo '<pre>';
			print_r($arrs);
			die();*/

			foreach($arrs as $arr)
			{
				if($arr['type'] == 'post')
				{
					$filecontent .= "\t\tRoute::".$arr['type'].'('."'/".$arr['url']."',\n";
				
					//$this->routeNameToStoreInDb[] = $module_name.'-'.$arr['route_name']."-post";
					$filecontent .= "\t\t\t\t"."['as'"."\t".'=>'."\t'".$module_name.'-'.$arr['route_name']."-post',\n";
					$filecontent .= "\t\t\t\t "."'uses'"."\t".'=>'."\t'".$controller_name."@".$arr['function_name']."']);\n\n";	
				}
								
			}

			$filecontent .= "\t});\n";
			
			$filecontent .= "//////////////////////////////////////////////////////////////////////////////////////////\n\n";
			////////////////////////////////////////////////////////////////////////////////////////////////

			/////////////////////////////////////// Controllers /////////////////////////////////////////////////////
			$filecontent .= "\//////////////////////////////////////////////// Add these in your controller //////////////////////////////////////////////////////////////////////////////////////////\n\n";
				
			foreach($arrs as $arr)
			{
					
				$filecontent .= "public function ".$arr['function_name']."()\n";
				$filecontent .= "{\n\n";
				$filecontent .= "\t\t //add your code here\n\n";
				$filecontent .= "}\n\n";
			
			}

			$filecontent .= "//////////////////////////////////////////////////////////////////////////////////////////\n\n";

			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			if(file_put_contents(app_path()."/code_generator/routeandfunctions.php", $filecontent))
			{
				@chmod(app_path()."/code_generator/routeandfunctions.php", 0777);
				//echo "route file successfully created".'<br>';
			}
			else
			{
				$errors .= '<p>could not generate the files</p>';
			}		
		}

		$errors = ($errors == '') ? '<p>Successfully stored in database. Successfully file created</p>' : $errors;

		Session::put('global', $errors);
		return Redirect::route('create-module-function', $controller_id);
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////
	public function listModuleFunctions($controller_id)
	{
		/*$moduleFunctions = DB::table(Permission::getTableName().' as P')
										  ->join(ModuleFunction::getTableName().' as MF', 'MF.id', '=', 'P.module_function_code_id')
										  ->join(Module::getTableName().' as M', 'M.id', '=', 'MF.module_id')
										  ->where('M.id', $controller_id)
										  //->where('is_active', 1)
										  ->get();*/
		$moduleFunctions = Module::with('permissions')->get()->toJson();

		echo '<pre>';
		print_r(json_decode($moduleFunctions));
		die();

		//get 
	}

	public function getGenerateRoute()
	{
		return View::make('generator.generate-route');
	}

	public function postGenerateRoute()
	{
		//make routes
		//make functions
	}

	public function getAddTableHeaders()
	{

	}

	public function postAddTableHeaders()
	{
		$controller_id = (int) Input::get('controller_id');
		//echo $controller_id;
		//die();
		$headers = Input::get('header');

		if($headers == '' || $controller_id == 0)
		{
			$arr = array('status' => 'error', 'message' => 'header or controller_id not given');
		}
		else
		{
			if(preg_match('/^([a-zA-Z_]+;)+[a-zA-Z_]+$/', $headers) && $controller_id > 0)
			{
				try
				{

					$data = ListHeaderTable::firstOrCreate(array('controller_id' => $controller_id));
					$data->is_active = 1;
					$data->headers = $headers;
					$data->save();

					$headers = explode(';', $data->headers);

					$arr = array('status' => 'success', 'data' => $headers);

				}
				catch(PDOException $e)
				{
					$arr = array('status'=>'error', 'message' => 'Something went wrong', 'reason' => $e->getMessage());
				}	
			}
			else
			{
				$arr = array('status' => 'error', 'message' => 'header not in correct format');
			}
		}

		return json_encode($arr);
	}

	public function getAdminList()
	{
		$model_name = 'Admin';


		//get table headers here;
		$controller_name = $this->model_name.'Controller';
		//$tableHeader = $this->getTableHeaders($controller_name);

		$queryString = Input::query();
		
		if(isset($queryString['paginate']))
		{
			$queryString['paginate'] = ($queryString['paginate'] == 0) ? 10 : $queryString['paginate'];	
		}
		else
		{
			$queryString['paginate'] = 10;	
		}

		
			$status = isset($queryString['status']) ? $queryString['status'] : 1;
			$queryString['status'] = $status; 

			if(isset($queryString['column_name']))
			{
				if($queryString['column_name'] == 'id' || $queryString['column_name'] == 'is_active')
				{
					$queryString['column_name'] = $model_name::getTableName().'.'.$queryString['column_name'];
				}
			}

		$data = $model_name::join(Group::getTableName().' as G', 'G.id', '=', 'group_id')
							->select($model_name::getTableName().'.*', 'G.group_name');

		if($status == 1 || $status == 0)
		{
			
			$data->where($model_name::getTableName().'.is_active', $status);

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
				$data = $data->where($queryString['column_name'], 'LIKE', '%'.$queryString['column_value'].'%')->paginate($queryString['paginate']);
			}
			else
			{
				$data = $data->paginate($queryString['paginate']);	
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

		return View::make($this->view.'list-admins')
					->with('arr', $arr)
					->with('status', $status)
					//->with('tableHeader', $tableHeader)
					->with('queryString', $queryString);
	}

	public function postDeleteAdmins()
	{
		$arr = array();
		$success = '';
		$error = '';
		$message = '';
		$model_name = 'Admin';

		//if($id == 0)
		//{
			$dataToDelete = Input::get('data'); //these are ids that are to be deleted	
			$rowNums = $dataToDelete[1];
			$dataToDelete = $dataToDelete[0];
		//}
		if($dataToDelete == '' || !preg_match('/(^([0-9]+,)+[0-9]+$)|(^[0-9]+$)/', $dataToDelete))
		{
			$message = 'ids not given or given in invalid format';
			Session::put('global', $message);
			return Redirect::route('list-admins');
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
		return Redirect::route('list-admins');
	}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////// These are for temporary permissions /////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
	public function getSetTemporaryPermissions()
	{
		
		$default_admin_id = Input::get('admin_id');

		/*
		$checkingIfAlreadyPermissionGiven = TemporaryPermission::where('admin_id', $default_admin_id)
																->where('is_active', 1)
																->first();

		if($checkingIfAlreadyPermissionGiven)
		{
			Session::put('global', 'Permission already set for this the user.');
			return Redirect::route('list-admins');
		}
		*/

		//get first module
		$id = Module::where('is_active', 1)->firstOrFail();
		$id = $id->id;

		$default_controller_id = (int) Input::get('controller_id') ? (int) Input::get('controller_id') : $id; 

		$module_functions = ModuleFunction::join(Module::getTableName().' as M', 'M.id', '=', 'module_id')
											->where(ModuleFunction::getTableName().'.is_active', '=', 1)
											->where(ModuleFunction::getTableName().'.module_id', '=', $default_controller_id)
											->where('M.is_active', 1)
											->select(ModuleFunction::getTableName().'.*')
											->get();


		return View::make($this->view.'set-temporary-permissions')
					->with('default_admin_id', $default_admin_id)
					->with('default_controller_id', $default_controller_id)
					->with('module_functions', $module_functions);

	}

	public function postSetTemporaryPermissions()
	{
		$count = 0;
		$dataToStore = array();
		$input_data = Input::all();
		
		$dataToStore['admin_id'] = $input_data['admin_id'];
		$dataToStore['expiry_date'] = $input_data['expiry_date'];
		$dataToStore['module_function_id'] = '';
		$dataToStore['is_active'] = 1;
		//$dataToStore['controller_id'] = $input_data['controller_name'];

		foreach($input_data as $index => $data)
		{
			if(strpos($index, 'checkbox'))
			{
				$dataToStore['module_function_id'] .= '::'.$data.'::;';
				$count++;
			}
		}
		
		if($count)
		{
			$modelName = 'TemporaryPermission';

			$result = $this->validateInput($modelName, $dataToStore);


		    if($result['status'] == 'error')
		    {
		    	return Redirect::route('set-temporary-permissions')
								->with('errors', $result['message'])
								->withInput();
		    }
		    
		    $message = '';
		    
		    try
		    {
		    	DB::getPdo()->beginTransaction();

		    	////////////////////////// select a row with given admin id ////////////////////////////
		    	////////////////////////// if not create the row with funcitons
		    	////////////////////////// update the permissions //////////////////////////////////////
		    	$temp_permission = TemporaryPermission::where('admin_id', $dataToStore['admin_id'])
		    										   ->first();

		    	if($temp_permission)
		    	{
		    		$temp_permission->module_function_id .= $dataToStore['module_function_id'];
		    		$temp_permission->save();
		    	}
		    	else
		    	{
		    		TemporaryPermission::create($dataToStore);
		    	}

		    	$admin = Admin::where('id', $dataToStore['admin_id'])
		    		 //->where('is_active', 1)
		    		 //->where('temp_permission', 0)
		    		 ->firstOrFail();

		    	$admin->temp_permission = 1;
		    	$admin->save();

		    	DB::getPdo()->commit();

		    	$message = 'Permissions successfully updated';
		    		
		    }
		    catch(PDOException $e)
		    {
		    	DB::getPdo()->rollBack();

		    	$message = $e->getMessage();
		    }

		    Session::put('global', '<p>'.$message.'</p>');
			return Redirect::route('list-admins');
		}
		else
		{
			Session::put('global', '<p>No data added because no permission selected</p>');
			return Redirect::route('set-temporary-permissions')
							->withInput();
		}
		
	}

	public function getEditTemporaryPermissions($admin_id)
	{
		$module_functions = array();

		$data = TemporaryPermission::join(Admin::getTableName().' as A', 'A.id', '=', 'admin_id')
									->select(TemporaryPermission::getTableName().'.*', 'A.username')
									->where('admin_id', $admin_id)
									//->where(TemporaryPermission::getTableName().'.is_active', 1)
									->where('A.is_active', 1)
									->first();

		if($data)
		{
			$allowedPermissions = HelperController::getAllowedGroups($data->module_function_id);

			$module_functions = ModuleFunction::where('is_active', 1)
												->whereIn('id', $allowedPermissions)
												->lists('module_function_code', 'id');

			
			$count = true;
					//->with('default_controller_id', $default_controller_id)
					//->with('module_functions', $module_functions);	
		}
		else
		{
			$count = false;
		}

		return View::make($this->view.'edit-temporary-permissions')
					->with('data', $data)
					->with('count', $count)
					->with('module_functions', $module_functions);
		

		//$default_controller_id = (int) Input::get('controller_id') ? (int) Input::get('controller_id') : $data->controller_id; 
		/*echo '<pre>';
		print_r($allowedPermissions);
		die();*/
		/*$module_functions = ModuleFunction::join(Module::getTableName().' as M', 'M.id', '=', 'module_id')
											->where(ModuleFunction::getTableName().'.is_active', '=', 1)
											->where(ModuleFunction::getTableName().'.module_id', '=', $default_controller_id)
											->where('M.is_active', 1)
											->select(ModuleFunction::getTableName().'.*')
											->get();*/

		
	}

	public function postEditTemporaryPermissions($admin_id)
	{
		$count = 0;
		$dataToStore = array();
		$input_data = Input::all();

		$dataToStore['expiry_date'] = $input_data['expiry_date'];
		$dataToStore['module_function_id'] = '';
		$dataToStore['is_active'] = $input_data['is_active'];

		foreach($input_data as $index => $data)
		{
			if(strpos($index, 'checkbox'))
			{
				$dataToStore['module_function_id'] .= '::'.$data.'::;';
				$count++;
			}
		}
		
		if($count)
		{
			$modelName = 'TemporaryPermission';

			$result = $this->validateInput($modelName, $dataToStore, true);

		    if($result['status'] == 'error')
		    {
		    	return Redirect::route('edit-temporary-permissions')
								->with('errors', $result['message'])
								->withInput();
		    }
		    
		    $message = '';
		    
		    try
		    {

		    	TemporaryPermission::where('admin_id', $admin_id)
		    						->update($dataToStore);


		    	$message = 'Permissions successfully updated';
		    		
		    }
		    catch(PDOException $e)
		    {

		    	$message = $e->getMessage();
		    }
		    

		    Session::put('global', '<p>'.$message.'</p>');
			return Redirect::route('list-admins');
		}
		else
		{
			Session::put('global', '<p>No data added because no permission selected</p>');
			return Redirect::route('edit-temporary-permissions', $admin_id)
							->withInput();
		}

		//$default_controller_id = (int) Input::get('controller_id') ? (int) Input::get('controller_id') : $id; 
	}

	public function deleteTemporaryPermission($admin_id)
	{
		$data = TemporaryPermission::where('admin_id', $admin_id)->firstOrFail();

		try
		{
			DB::getPdo()->beginTransaction();

			$data->delete();

			$admin =Admin::where('id', $admin_id);
							

		}
		catch(PDOException $e)
		{

		}
	}


///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////// These are for temporary permissions /////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function logout()
	{
		if(Auth::superAdmin()->logout())
		{
			Session::put('global', 'Successfully logged out!');
			return Redirect::route('login-superadmin');	
		}
		else
		{
			Session::put('global', 'Log Out failed! Please try again');
			return Redirect::route('superadmin-home');	
		}
	}	


//////////////////////////////////////////////////////////////////////////////////////////////////////////
/************************************** These are helper functions  *****************************************/

	private function seperateGetOrPost($route_types)
	{
		$get = array();
		$post = array();

		foreach($route_types as $index => $val)
		{
			if($val == 'get')
			{
				$get[] = $index;
			}
			else if($val == 'post')
			{
				$post[] = $index;
			}
		}

		return array($get, $post);
	} 

}
