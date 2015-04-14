<?php
/*Array
(
    'module_name' => 'test'
    'authentication' => 0
    'table_name' => 'test'
    '_field1' => 'field1'
    '_field2' => 'fields2'
    '_field3' => 'fields3'
    'field_name' => 
    '_fillable1' => 'field1'
    '_fillable2' => 'fields2'
    '_fillable3' => 'fields3'
    '_showInList1' => 'field1'
    '_showInList2' => 'fields2'
    '_showInList3' => 'fields3'
    '_showInInputForm1' => 'field1'
    '_showInInputForm2' => 'fields2'
    '_showInInputForm3' => 'fields3'
    '_url1' => 'add'
    '_function1' => 'add'
    '_route1' => 'add'
    'url_name' => 
    'function_name' => 
    'route_name' => 
)*/
class GeneratorController extends Controller
{
	private $module_name;
	private $views;
	private $controller_name;
	private $model_name;
	private $fields;
	private $fillable_fields;
	private $list_fields;
	private $form_fields;
	private $urls;
	private $route_types;
	private $route_names;
	private $function_names;
	private $module_path;
	private $requires_authentication;
	private $routeNameToStoreInDb;
	private $viewFolder_path;
	private $controller_id;

	public function __construct()
	{
		$this->fields = array();
		$this->fillable_fields = array();
		$this->list_fields = array();
		$this->form_fields = array();
		$this->route_types = array();
		$this->route_names = array();
		$this->urls = array();
		$this->function_names = array();
		$this->routeNameToStoreInDb = array();
		$this->controller_id = 0;

	}

	public function getGeneratorForm()
	{
		return View::make('generator.generator');
	}

	public function postGeneratorForm()
	{

		$input = Input::all();
		echo '<pre>';
		print_r($input);
		echo '<br>';

		$this->module_name = $input['module_name'];
		$this->views = $input['module_name'].'.views.';
		$this->model_name = ucfirst($input['module_name']);
		$this->controller_name = $this->model_name.'Controller';
		$this->table_name = $input['table_name'];
		$this->requires_authentication = $input['authentication'];

		$this->extractInput($input);

		$this->createModuleFolder();
		$this->createController(); //sets Controller_id
		$this->createModel();
		$this->createRoute();
		$this->createViewsFolder();

/*********************************************************/
		//$this->storeInListHeaderTable();
/********************************************************/		

/**********************************************************/
		$this->createListView();
		$this->createViewView();
		$this->createEditView();
		$this->createCreateView();
		$this->createScript();
/*************************************************************/
	}

	private function extractInput($input)
	{
		foreach($input as $key => $val)
		{
			if(strpos($key, 'field'))
			{
				$this->fields[] = $val;
			}
			else if(strpos($key, 'fillable'))
			{
				$this->fillable_fields[] = $val;
			}
			else if(strpos($key, 'showInList'))
			{
				$this->list_fields[] = $val;
			}
			else if(strpos($key, 'showInInputForm'))
			{
				$this->form_fields[] = $val;
			}
			else if(strpos($key, 'url'))
			{
				$this->urls[] = $val;
			}
			else if(strpos($key, 'route_type'))
			{
				$this->route_types[] = $val;
			}
			else if(strpos($key, 'route'))
			{
				$this->route_names[] = $val;
			}
			else if(strpos($key, 'function'))
			{
				$this->function_names[] = $val;
			}

		}
	}

	private function createModuleFolder()
	{
		$this->module_path = app_path().'/code_generator/'.$this->module_name;
		if(!file_exists($this->module_path))
		{
			$result = File::makeDirectory($this->module_path, 0777, true);  //returns false
		
			chmod($this->module_path, 0777);
			if(!$result)
			{
				echo 'could not create '.$this->module_name.' folder';
				die();
			}
		}
	}

	private function createController()
	{
		$filecontent  = "<?php"."\n\n";
		$filecontent .= "class ".$this->controller_name." extends BaseController"."\n";
		$filecontent .= "{"."\n";
		$filecontent .= "\t"."protected ".'$view'." = '$this->views';\n\n";
		$filecontent .= "\t"."protected ".'$model_name'." = '$this->model_name';\n\n";
		$filecontent .= "\t"."protected ".'$module_name'." = '$this->module_name';\n\n";


		foreach($this->function_names as $function_name)
		{
			$filecontent .= "\t"."public function ".$function_name."()"."\n";
			$filecontent .= "\t"."{"."\n";
			$filecontent .= "\t\t //write your contents"."\n";
			$filecontent .= "\t"."}"."\n";	
		}

		$filecontent .= "}"."\n";

		if(file_put_contents($this->module_path."/".$this->controller_name.".php", $filecontent))
		{
			chmod($this->module_path."/".$this->controller_name.".php", 0777);
			echo "controller $this->controller_name succesfully created".'<br>';	
		}
		else
		{
			echo "controller $this->controller_name not succesfully created".'<br>'; 
			//die();
		}

		//storing in database
		$result = 0;
		try
		{

			$result = Module::firstOrCreate(array('module_name'	=> $this->controller_name,
										   'is_active'		=> 1))->id;
		}
		catch(PDOException $e)
		{
			echo 'could not successfully store in '.Module::getTableName().'<br>';
			$this->controller_id = 0;
		}

		$this->controller_id = $result;
		echo 'successfully stored '.Module::getTableName().'<br>';

		/*$lines=array();
$fp=fopen('file.txt', 'r');
while (!feof($fp))
{
    $line=fgets($fp);

    //process line however you like
    $line=trim($line);

    //add to array
    $lines[]=$line;

}
fclose($fp);*/
	}

	private function createModel()
	{
		$filecontent  = "<?php"."\n\n";
		if($this->requires_authentication == 1)
		{
			$filecontent .= 'use Illuminate\Auth\UserTrait;'."\n";
			$filecontent .= "use Illuminate\Auth\UserInterface;\n";
			$filecontent .= "class $this->model_name extends Eloquent implements UserInterface\n";
			$filecontent .= "{\n";
			$filecontent .= "\tuse UserTrait;\n";
		}
		else
		{
			$filecontent .= "class $this->model_name extends Eloquent\n";
			$filecontent .= "{\n";
		}

		$filecontent .= "\t".'protected $table = '."'".$this->table_name."';\n\n";
		
		$fields = '[';
		$count = count($this->fillable_fields);
		
		for($i = 0; $i < $count; $i++)
		{
				$fields .= "'".$this->fillable_fields[$i]."', ";
		}

		$fields .= "'is_active' ];\n\n";

		$filecontent .= "\tprotected ".'$fillable = '.$fields."\n\n";
		$filecontent .= "\tpublic static ".'$createRule'." = [];\n\n";
		$filecontent .= "\tpublic static ".'$updateRule'." = [];\n\n";

		$filecontent .= "\tpublic static function getTableName()\n";
		$filecontent .= "\t{\n";
		$filecontent .= "\t\treturn with (new static)->getTable();\n";
		$filecontent .= "\t}\n\n";

		if($this->requires_authentication == 1)
		{
			$filecontent .= "\tprotected ".'$hidden'." = array('password', 'remember_token');\n\n";
		}

		$filecontent .= "}";

		if(file_put_contents($this->module_path."/".$this->model_name.".php", $filecontent))
		{
			chmod($this->module_path."/".$this->model_name.".php", 0777);
			echo "model $this->model_name successfully created".'<br>';
		}
		else
		{
			echo "model $this->model_name not successfully created".'<br>';
			die();
		}
	}

/******************************************************************************************************************************/
	private function createRoute()
	{
		$arrs = array();
		$errors = ''; //this incudes info on route-names that could not be stored in database
		
		$getOrPosts = $this->seperateGetAndPost();
		
		foreach($getOrPosts as $getOrPost)
		{
			if(count($getOrPost))
			{
				foreach($getOrPost as $index)
				{
					$temp = array();
					
					$temp['type'] = $this->route_types[$index];
					$temp['url'] = $this->urls[$index];
					$temp['route_name'] = $this->route_names[$index];
					$temp['function_name'] = $this->function_names[$index];

					if($this->controller_id != 0)
					{
						try
						{
								$module_function_code = $temp['type'] == 'get' ? $this->module_name.'-'.$temp['route_name'] : $this->module_name.'-'.$temp['route_name'].'-post';

								ModuleFunction::firstOrCreate(array('module_id'				=> $this->controller_id,
												      		 'module_function_code'		=> $module_function_code,
												      		 'is_active'				=> 1));
						}
						catch(PDOException $e)
						{
							$errors .= $module_function_code.' could not be stored in '.ModuleFunction::getTableName().'<br>';
						}


					}

					$arrs[] = $temp;
				}
			}	
		}

		$filecontent  = '<?php'."\n\n";
		
		$filecontent .= 'Route::group(array'."('prefix' => '$this->module_name'), function(){\n\n";
		
		$filecontent .= "\tRoute::get('/list/{status?}',\n";
		$filecontent .= "\t\t\t['as'\t=>\t'$this->module_name-list',\n";
		$filecontent .= "\t\t\t 'uses'\t=>\t'$this->controller_name@getList']);\n\n";

		$filecontent .= "\tRoute::get('/create',\n";
		$filecontent .= "\t\t\t['as'\t=>\t'$this->module_name-create',\n";
		$filecontent .= "\t\t\t 'uses'\t=>\t'$this->controller_name@getCreate']);\n\n";

		$filecontent .= "\tRoute::get('/view/{id}',\n";
		$filecontent .= "\t\t\t['as'\t=>\t'$this->module_name-view',\n";
		$filecontent .= "\t\t\t 'uses'\t=>\t'$this->controller_name@view']);\n\n";
		
		$filecontent .= "\tRoute::get('/edit/{id}',\n";
		$filecontent .= "\t\t\t['as'\t=>\t'$this->module_name-edit',\n";
		$filecontent .= "\t\t\t 'uses'\t=>\t'$this->controller_name@getEdit']);\n\n";
		
		foreach($arrs as $arr)
		{
			$filecontent .= "\t".'Route::'.$arr['type'].'('."'/".$arr['url']."',\n";
			if($arr['type'] == 'get')
			{
				$this->routeNameToStoreInDb[] = $this->module_name.'-'.$arr['route_name'];
				$filecontent .= "\t\t\t"."['as'"."\t".'=>'."\t'".$this->module_name.'-'.$arr['route_name']."',\n";
			}
			
			$filecontent .= "\t\t\t "."'uses'"."\t".'=>'."\t'".$this->controller_name."@".$arr['function_name']."']);\n\n";	
		}

		$filecontent .= "\tRoute::group(array('before' => 'csrf'), function(){\n\n";

		$filecontent .= "\t\tRoute::post('/create',\n";
		$filecontent .= "\t\t\t\t['as'\t=>\t'$this->module_name-create-post',\n";
		$filecontent .= "\t\t\t\t 'uses'\t=>\t'$this->controller_name@postCreate']);\n\n";

		$filecontent .= "\t\tRoute::post('/edit/{id}',\n";
		$filecontent .= "\t\t\t\t['as'\t=>\t'$this->module_name-edit-post',\n";
		$filecontent .= "\t\t\t\t 'uses'\t=>\t'$this->controller_name@postEdit']);\n\n";

		$filecontent .= "\t\tRoute::post('/delete/{id?}/{status?}',\n";
		$filecontent .= "\t\t\t\t['as'\t=>\t'$this->module_name-delete-post',\n";
		$filecontent .= "\t\t\t\t 'uses'\t=>\t'$this->controller_name@delete']);\n\n";

		$filecontent .= "\t\tRoute::post('/purge/{id?}',\n";
		$filecontent .= "\t\t\t\t['as'\t=>\t'$this->module_name-purge-post',\n";
		$filecontent .= "\t\t\t\t 'uses'\t=>\t'$this->controller_name@purge']);\n\n";

		foreach($arrs as $arr)
		{
			$filecontent .= "\t\tRoute::".$arr['type'].'('."'/".$arr['url']."',\n";
			if($arr['type'] == 'post')
			{
				$this->routeNameToStoreInDb[] = $this->module_name.'-'.$arr['route_name']."-post";
				$filecontent .= "\t\t\t\t"."['as'"."\t".'=>'."\t'".$this->module_name.'-'.$arr['route_name']."-post',\n";
			}
			
			$filecontent .= "\t\t\t\t "."'uses'"."\t".'=>'."\t'".$this->controller_name."@".$arr['function_name']."']);\n\n";	
		}

		$filecontent .= "\t});\n";
		$filecontent .= "});\n";

		if(file_put_contents($this->module_path."/route.php", $filecontent))
		{
			@chmod($this->module_path."/route.php", 0777);
			echo "route file successfully created".'<br>';
		}
		else
		{
			echo "route file not successfully created".'<br>';
			//die();
		}
					if($this->controller_id != 0)
					{
						try
						{
							DB::connection()->getPdo()->beginTransaction();

							$module_function_code = $this->module_name.'-list';

							$data = ModuleFunction::firstOrCreate(array('module_id'					=> $this->controller_id,
												      		 'module_function_code'		=> $module_function_code,
												      		 'is_active'				=> 1))->id;

							Permission::firstOrCreate(array('module_function_code_id'	=>	$data,
													 'allowed_groups'			=>	'::1::;::2::',
													 'is_active'				=>	1));


							DB::connection()->getPdo()->commit();
						}
						catch(PDOException $e)
						{
							DB::connection()->getPdo()->rollBack();
							$errors .= $module_function_code.' could not be stored in '.ModuleFunction::getTableName().'<br>';
						}

						try
						{
							DB::connection()->getPdo()->beginTransaction();

							$module_function_code = $this->module_name.'-create';
							
							$data = ModuleFunction::firstOrCreate(array('module_id'					=> $this->controller_id,
												      		 'module_function_code'		=> $module_function_code,
												      		 'is_active'				=> 1))->id;

							Permission::firstOrCreate(array('module_function_code_id'	=>	$data,
													 'allowed_groups'			=>	'::1::;::2::',
													 'is_active'				=>	1));

							DB::connection()->getPdo()->commit();
						}
						catch(PDOException $e)
						{
							DB::connection()->getPdo()->rollBack();
							$errors .= $module_function_code.' could not be stored in '.ModuleFunction::getTableName().'<br>';
						}

						try
						{
							DB::connection()->getPdo()->beginTransaction();

							$module_function_code = $this->module_name.'-create-post';
							
							$data = ModuleFunction::firstOrCreate(array('module_id'					=> $this->controller_id,
												      		 'module_function_code'		=> $module_function_code,
												      		 'is_active'				=> 1))->id;

							Permission::firstOrCreate(array('module_function_code_id'	=>	$data,
													 'allowed_groups'			=>	'::1::;::2::',
													 'is_active'				=>	1));

							DB::connection()->getPdo()->commit();
						}
						catch(PDOException $e)
						{
							DB::connection()->getPdo()->rollBack();
							$errors .= $module_function_code.' could not be stored in '.ModuleFunction::getTableName().'<br>';
						}

						try
						{
							DB::connection()->getPdo()->beginTransaction();

							$module_function_code = $this->module_name.'-edit';
							
							$data = ModuleFunction::firstOrCreate(array('module_id'					=> $this->controller_id,
												      		 'module_function_code'		=> $module_function_code,
												      		 'is_active'				=> 1))->id;

							Permission::firstOrCreate(array('module_function_code_id'	=>	$data,
													 'allowed_groups'			=>	'::1::;::2::',
													 'is_active'				=>	1));

							DB::connection()->getPdo()->commit();
						}
						catch(PDOException $e)
						{
							DB::connection()->getPdo()->rollBack();
							$errors .= $module_function_code.' could not be stored in '.ModuleFunction::getTableName().'<br>';
						}

						try
						{
							DB::connection()->getPdo()->beginTransaction();

							$module_function_code = $this->module_name.'-edit-post';
							
							$data = ModuleFunction::firstOrCreate(array('module_id'					=> $this->controller_id,
												      		 'module_function_code'		=> $module_function_code,
												      		 'is_active'				=> 1))->id;

							Permission::firstOrCreate(array('module_function_code_id'	=>	$data,
													 'allowed_groups'			=>	'::1::;::2::',
													 'is_active'				=>	1));

							DB::connection()->getPdo()->commit();

						}
						catch(PDOException $e)
						{
							DB::connection()->getPdo()->rollBack();
							$errors .= $module_function_code.' could not be stored in '.ModuleFunction::getTableName().'<br>';
						}

						try
						{
							DB::connection()->getPdo()->beginTransaction();

							$module_function_code = $this->module_name.'-view';
							
							$data = ModuleFunction::firstOrCreate(array('module_id'					=> $this->controller_id,
												      		 'module_function_code'		=> $module_function_code,
												      		 'is_active'				=> 1))->id;

							Permission::firstOrCreate(array('module_function_code_id'	=>	$data,
													 'allowed_groups'			=>	'::1::;::2::',
													 'is_active'				=>	1));

							DB::connection()->getPdo()->commit();
						}
						catch(PDOException $e)
						{
							DB::connection()->getPdo()->rollBack();
							$errors .= $module_function_code.' could not be stored in '.ModuleFunction::getTableName().'<br>';
						}

						try
						{
							DB::connection()->getPdo()->beginTransaction();

							$module_function_code = $this->module_name.'-delete-post';
							
							$data = ModuleFunction::firstOrCreate(array('module_id'					=> $this->controller_id,
												      		 'module_function_code'		=> $module_function_code,
												      		 'is_active'				=> 1))->id;

							Permission::firstOrCreate(array('module_function_code_id'	=>	$data,
													 'allowed_groups'			=>	'::2::',
													 'is_active'				=>	1));

							DB::connection()->getPdo()->commit();

						}
						catch(PDOException $e)
						{
							DB::connection()->getPdo()->rollBack();
							$errors .= $module_function_code.' could not be stored in '.ModuleFunction::getTableName().'<br>';
						}

						try
						{
							DB::connection()->getPdo()->beginTransaction();

							$module_function_code = $this->module_name.'-purge-post';
							
							$data = ModuleFunction::firstOrCreate(array('module_id'					=> $this->controller_id,
												      		 'module_function_code'		=> $module_function_code,
												      		 'is_active'				=> 1))->id;

							Permission::firstOrCreate(array('module_function_code_id'	=>	$data,
													 'allowed_groups'			=>	'::2::',
													 'is_active'				=>	1));

							DB::connection()->getPdo()->commit();

						}
						catch(PDOException $e)
						{
							DB::connection()->getPdo()->rollBack();
							$errors .= $module_function_code.' could not be stored in '.ModuleFunction::getTableName().'<br>';
						}	
					}

		if($errors == '')
		{
			echo 'successfully stored '.ModuleFunction::getTableName().'<br>';
		}
		else
		{
			echo $errors;
		}
	}

	private function seperateGetAndPost()
	{
		$get = array();
		$post = array();

		foreach($this->route_types as $index => $val)
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
/********************************************************************************************************************************************/
	private function createViewsFolder()
	{
		$this->viewFolder_path = $this->module_path.'/views';
		if(!file_exists($this->viewFolder_path))
		{
			$result = File::makeDirectory($this->viewFolder_path, 0777);  //returns false		
			if($result)
			{
				echo 'views folder succesfully created'.'<br>';
			}
			else
			{
				echo 'views folder not succesfully created'.'<br>';
				die();
			}
		}

		$include = $this->module_path.'/views/include';
		if(!file_exists($include))
		{
			$result = File::makeDirectory($include, 0777);  //returns false		
			if($result)
			{
				echo 'views/include folder succesfully created'.'<br>';
			}
			else
			{
				echo 'views/include folder not succesfully created'.'<br>';
				die();
			}
		}

	}
/***********************************************************************************************************/

	private function createViewMenu()
	{

	}

/**********************************************************************************************************************/
	private function createListView()
	{
		$filecontent = "@extends('layouts.main')\n\n";
		$filecontent .= "@section('custom')\n\n";
		$filecontent .= '<script src = "{{ asset('."'backend-js/deleteOrPurge.js') }}".'"'.' type = "text/javascript"></script>'."\n\n";
		$filecontent .= '<script src = "{{ asset('."'backend-js/tableSearch.js') }}".'"'.' type = "text/javascript"></script>'."\n\n";
		$filecontent .= "@stop\n\n";
		$filecontent .= "@section('content')\n\n";

		$filecontent .= "<div class = 'container'>\n";
		$filecontent .= "\t<span><a class = 'btn btn-default' href = '{{URL::route('".$this->module_name."-create')}}'>Create New</a></span><span><a class = 'btn btn-default' href = '{{URL::route('".$this->module_name."-delete-post')}}' id = 'delete_selected'>Delete</a></span><span><a href = '{{URL::route('".$this->module_name."-purge-post')}}' class = 'btn btn-default'  id = 'purge_selected'>Purge</a></span>\n";	
		$filecontent .= "</div>\n\n";
		$filecontent .= "{{-- this block is for hidden values --}}\n";
		$filecontent .= "<input type = 'hidden' id = 'url' value = '{{URL::current()}}'>\n\n";
		$filecontent .= "<input type = 'hidden' value = '{{URL::current()}}' class = 'url'>\n\n";

		$filecontent .= "<div class = 'container'>\n";
		$filecontent .= "<span>Show :<a class = 'paginate_limit' href = '{{URL::current()}}?paginate=10'>10</a> / <a class = 'paginate_limit' href = '{{URL::current()}}?paginate=20'>20</a> / <a class = 'paginate_limit' href = '{{URL::current()}}?paginate=30'>30</a>\n";
		$filecontent .= "</div>\n\n";

		$filecontent .= "@include('include.modal')\n\n";
		$filecontent .= "@include('include.modal-selected')\n\n";
		$filecontent .= "<div class = 'container'>\n\n";
		
		$filecontent .= "<div style = 'overflow-x : auto'>\n";
		$filecontent .= "\t<table class = 'table table-striped table-hover table-bordered'>\n";
		$filecontent .= "\t\t<thead>\n";
		
		$filecontent .= "\t\t\t<tr>\n";
		$filecontent .= "\t\t\t\t<th>id</th>\n";
		foreach($this->list_fields as $field)
		{
			$filecontent .= "\t\t\t\t<th>$field</th>\n";
		}
			$filecontent .= "\t\t\t\t<th>Is Active</th>\n";
			$filecontent .= "\t\t\t\t<th colspan = 4>Actions</th>\n";
		$filecontent .= "\t\t\t</tr>\n";

		$filecontent .= "\t\t</thead>\n\n";
		
		$filecontent .= "\t\t<tbody class = 'search-table'>\n";
		$filecontent .= "\t\t@if(".'$arr['."'count'])\n";
		$filecontent .= "\t\t\t<?php ".'$i = 1; ?>'."\n";
		$filecontent .= "\t\t\t\t<tr>\n";
		
		$i = 0;
		
		$filecontent .= "\t\t\t\t\t<td><input type = 'text' class = 'search_column'  id = '".++$i."'><input type = 'hidden' class = 'field_name' value = 'id'></td>\n";

		foreach($this->list_fields as $field)
		{
			$filecontent .= "\t\t\t\t\t<td><input type = 'text' class = 'search_column'  id = '".++$i."'><input type = 'hidden' class = 'field_name' value = '".$field."'></td>\n";
		}
			
			$filecontent .= "\t\t\t\t\t<td><input type = 'text' class = 'search_column'  id = '".++$i."'><input type = 'hidden' class = 'field_name' value = 'is_active'></td>\n";
			
			$filecontent .= "\t\t\t\t\t<td colspan = 4></td>\n";
			
		$filecontent .= "\t\t\t\t</tr>\n";

		$filecontent .= "\t\t\t\t@foreach(".'$arr['."'data'] as ".'$data)'."\n";
		$filecontent .= "\t\t\t\t\t<tr>\n";
		$filecontent .= "\t\t\t\t\t\t<td><input type = 'checkbox' class = 'checkbox_id' value = '{{".'$data->id'."}}'>{{".'$i'."}}</td>\n";
		foreach($this->list_fields as $field)
		{
			$filecontent .= "\t\t\t\t\t\t<td>{{".'$data->'.$field."}}</td>\n";
		}
			$filecontent .= "\t\t\t\t\t\t<td>{{".'$data->is_active'."}}</td>\n";

		$filecontent .= "\t\t\t\t\t\t<td><a href = ".'"{{URL::route('."'$this->module_name-view', ".'$data->id'.')}}">view</a></td>'."\n";
		$filecontent .= "\t\t\t\t\t\t<td><a href = ".'"{{URL::route('."'$this->module_name-edit', ".'$data->id'.')}}">edit</a></td>'."\n";
		$filecontent .= "\t\t\t\t\t\t<td><a class = 'delete"."' href = ".'"{{URL::route('."'$this->module_name-delete-post', array(".'$data->id, $status'.'))}}">delete</a></td>'."\n";
		$filecontent .= "\t\t\t\t\t\t<td><a class = 'purge"."' href = ".'"{{URL::route('."'$this->module_name-purge-post', ".'$data->id'.')}}">purge</a></td>'."\n";
		$filecontent .= "\t\t\t\t\t</tr>\n";
		$filecontent .= "\t\t\t\t\t<?php ".'$i++; ?>'."\n";
		$filecontent .= "\t\t\t\t@endforeach"."\n";
		$filecontent .= "\t\t@else\n";
		$filecontent .= "\t\t\t\t\t<tr>\n";
		$filecontent .= "\t\t\t\t\t\t<td>".'{{$arr['."'message']}}</td>\n";
		$filecontent .= "\t\t\t\t\t</tr>\n";
		$filecontent .= "\t\t@endif\n";
		$filecontent .= "\t\t</tbody>\n";
		$filecontent .= "\t</table>\n\n";
		$filecontent .= "</div>\n";
		$filecontent .= "\t{{Form::token()}}\n\n";
		$filecontent .= "\t<div class = 'paginate'>\n";
		$filecontent .= "\t\t@if(".'$arr['."'count'])\n";
		$filecontent .= "\t\t\t{{".'$arr['."'data']->".'appends($queryString)'."->links()}}\n";
		$filecontent .= "\t\t@endif\n";
		$filecontent .= "\t</div>\n\n";
		$filecontent .= "</div>\n\n";
		$filecontent .= "@stop\n";

		if(file_put_contents($this->module_path."/views/list.blade.php", $filecontent))
		{
			chmod($this->module_path."/views/list.blade.php", 0777);
			echo "list file successfully created".'<br>';
		}
		else
		{
			echo "list file not successfully created".'<br>';
			die();
		}
	}

	private function createEditView()
	{

		$filecontent = "@extends('layouts.main')\n\n";
		$filecontent .= "@section('content')\n\n";
		$filecontent .= "<div class = 'container'>\n";
		$filecontent .= "\t".'<form method = "post" action = "{{URL::route('."'$this->module_name-edit-post', ".'$data->id)}}'.'"></td>'."\n";

		$filecontent .= "\t".'<table class = "table table-striped table-hover table-bordered">'."\n";
		$filecontent .= "\t\t<tbody>\n";
		
		foreach($this->form_fields as $field)
		{
			$filecontent .= "\t\t<tr>\n";
			$filecontent .= "\t\t\t<th>$field</th>\n";

			$filecontent .= "\t\t\t<td><input type = 'text' name = '$field' value = '{{".'$data->'."$field}}'><span class = 'form-error'>@if(".'$errors->has'."('$field')) {{ ".'$errors->first'."('$field') }} @endif</span></td>\n";
			$filecontent .= "\t\t</tr>\n";						
		}			
		
		$filecontent .= "\t\t<tr>\n";
		$filecontent .= "\t\t\t<th>Is Active</th>\n";
		$filecontent .= "\t\t\t<td><span><input type = 'radio' name = 'is_active' value = '1' @if(".'$data->is_active == 1)'." {{'checked'}} @endif>Yes</span><span><input type = 'radio' name = 'is_active' value = '0' @if(".'$data->is_active == 0)'." {{'checked'}} @endif>No</span>\n";
		$filecontent .= "\t\t</tr>\n";						

		$filecontent .= "\t\t<tr>\n";
		$filecontent .= "\t\t\t".'<td>{{Form::token()}}<input type = "submit" class = "btn btn-info" value = "edit"></td><td><a href = "{{URL::route(\''.$this->module_name.'-list\')}}" class = "btn btn-default">Cancel</a></td>'."\n";
		$filecontent .= "\t\t</tr>\n";
		$filecontent .= "\t\t</body>\n";
		$filecontent .= "\t</table>\n";
		$filecontent .= "\t</form>\n";
		$filecontent .= "</div>\n\n";
		$filecontent .= "@stop\n\n";
		
		if(file_put_contents($this->module_path."/views/edit.blade.php", $filecontent))
		{
			chmod($this->module_path."/views/edit.blade.php", 0777);
			echo "edit file successfully created".'<br>';
		}
		else
		{
			echo "edit file not successfully created".'<br>';
			die();
		}				
	}

	private function createViewView()
	{
		$filecontent = "@extends('layouts.main')\n\n";
		$filecontent .= "@section('content')\n\n";
		$filecontent .= "<div class = 'container'>\n";

		$filecontent .= "\t".'<table class = "table table-striped table-hover table-bordered">'."\n";
		$filecontent .= "\t\t<tbody>\n";
		
		foreach($this->form_fields as $field)
		{
			$filecontent .= "\t\t<tr>\n";
			$filecontent .= "\t\t\t<th>".HelperController::underscoreToSpace($field)." :</th>\n";
			$filecontent .= "\t\t\t<td>{{".'$data->'."$field}}</td>\n";
			$filecontent .= "\t\t</tr>\n";						
		}

			$filecontent .= "\t\t<tr>\n";
			$filecontent .= "\t\t\t<th>Is Actvie:</th>\n";
			$filecontent .= "\t\t\t<td>{{".'$data->'."is_active}}</td>\n";
			$filecontent .= "\t\t</tr>\n";			

		$filecontent .= "\t\t<tr>\n";
		$filecontent .= "\t\t\t<td colspan = '2'><a href = \"{{URL::route('".$this->module_name.'-list'.'\')}}" class = "btn btn-default">Go Back To List</a></td>'."\n";
		$filecontent .= "\t\t</tr>\n";
		$filecontent .= "\t\t</body>\n";
		$filecontent .= "\t</table>\n";
		$filecontent .= "</div>\n\n";
		$filecontent .= "@stop\n\n";
		
		if(file_put_contents($this->module_path."/views/view.blade.php", $filecontent))
		{
			chmod($this->module_path."/views/view.blade.php", 0777);
			echo "view file successfully created".'<br>';
		}
		else
		{
			echo "view file not successfully created".'<br>';
			die();
		}	
	}

	private function createCreateView()
	{
		$filecontent = "@extends('layouts.main')\n\n";
		$filecontent .= "@section('custom')\n";
		$filecontent .= '<script src = "{{ asset(\'backend-js/validation.js\') }}" type = "javascript/text"></script>'."\n";
		$filecontent .= "@stop\n\n";

		$filecontent .= "@section('content')\n\n";
		$filecontent .= "@include('$this->module_name.views."."script')\n\n";
		$filecontent .= "<div class = 'container'>\n";
		$filecontent .= "\t".'<form method = "post" action = "{{URL::route('."'$this->module_name-create-post')}}".'"  class = "form-horizontal">'."\n";
		$filecontent .= "\t<input type = \"hidden\" id = \"url\" value = \"{{URL::route('$this->module_name-create-post')}}\">\n";
		foreach($this->form_fields as $field)
		{
			$filecontent .= "\t\t<div class = 'form-group @if(".'$errors->has("'.$field.'")) {{"has-error"}}'." @endif'>\n";
			$filecontent .= "\t\t\t<label for = '$field'  class = 'control-label col-xs-2'>".HelperController::underscoreToSpace($field)." :</label>\n";
			$filecontent .= "\t\t\t\t<div class = 'col-xs-10'>\n";
			$filecontent .= "\t\t\t<input type = 'text' name = '$field' value".'='." '"."{{ (Input::old('$field')) ? (Input::old('$field')) : '' }}"."' class = 'form-control'><span class = 'help-block'>@if(".'$errors'."->has('$field')) {{".'$errors'."->first('$field')}} @endif</span>\n";
			$filecontent .= "\t\t\t\t</div>\n";
			$filecontent .= "\t\t</div>\n";
		}

		$filecontent .= "\t\t<input type = 'hidden' name = 'is_active' value = '1'>\n";
		
		$filecontent .= "\t\t<div class = 'form-row'>\n";
		$filecontent .= "\t\t\t<div class='col-xs-offset-2 col-xs-10'>\n";
		$filecontent .= "\t\t\t{{Form::token()}}\n";
		$filecontent .= "\t\t\t\t<span><input type = 'submit' value = 'create' class = 'btn btn-default'></span><span><input type = 'submit' class = 'addNew btn btn-default' value = 'Create & Add New'></span><span><a href = '{{URL::route('".$this->module_name."-list')}}' class = 'btn btn-default'>Cancel</a></span>\n";
		$filecontent .= "\t\t\t</div>\n";
		$filecontent .= "\t\t</div>\n";
		$filecontent .= "\t</form>\n";
		$filecontent .= "</div>\n\n";
		$filecontent .= "@stop\n";

		if(file_put_contents($this->module_path."/views/create.blade.php", $filecontent))
		{
			chmod($this->module_path."/views/create.blade.php", 0777);
			echo "create file successfully created".'<br>';
		}
		else
		{
			echo "create file not successfully created".'<br>';
			die();
		}
	}

	private function createScript()
	{
		$filecontent = '';
		$filecontent .= "<?php\n\n";

		$filecontent .= "echo '\n";
		$filecontent .= "<script src=\"'.VENDOR_PATH.'text-editor/ckeditor/ckeditor.js'.'\"></script>\n";
		$filecontent .= "<script>\n";
		$filecontent .= "\t\t$(document).ready(function()\n";
		$filecontent .= "\t\t{\n";
		$filecontent .= "\t\t\tvar roxyFileman = \"'.VENDOR_PATH.'text-editor/fileman?integration=ckeditor\";\n";
		$filecontent .= "\t\t\t$(function()\n";
		$filecontent .= "\t\t\t{\n";
		$filecontent .= "\t\t\t\tCKEDITOR.replace( \"editor1\",{filebrowserBrowseUrl:roxyFileman,\n";
		$filecontent .= "\t\t\t\t\t\t\t\t\tfilebrowserImageBrowseUrl:roxyFileman+\"&type=image\",\n";
		$filecontent .= "\t\t\t\t\t\t\t\t\tremoveDialogTabs: \"link:upload;image:upload\"});\n";
		$filecontent .= "\t\t\t});\n";
		
		$filecontent .= "\t\t\t$(\".addNew\").click(function()\n";
		$filecontent .= "\t\t\t{\n";
		$filecontent .= "\t\t\t\tvar url = $(\"#url\").val() + \"?addNew=y\";\n";
		$filecontent .= "\t\t\t\t$(\"form\").attr(\"action\", url);\n";
		$filecontent .= "\t\t\t});\n";

		$filecontent .= "\t\t});\n";
		$filecontent .= "</script>';";

		if(file_put_contents($this->module_path."/views/script.php", $filecontent))
		{
			chmod($this->module_path."/views/script.php", 0777);
			echo "create file successfully created".'<br>';
		}
		else
		{
			echo "create file not successfully created".'<br>';
			die();
		}
	}
}

?>