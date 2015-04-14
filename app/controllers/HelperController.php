<?php

class HelperController extends Controller
{
	public static function getAllowedGroups($allowed_groups_string = '')
	{
		$groups = array();
		
		preg_match_all('/[0-9]+/', $allowed_groups_string, $matches);
		
		return $matches[0];
	}

	public static function checkDuplicateNameInDatabase($model_name, $column_name, $text_to_check)
	{
		$status = "error";
		
		if(trim($model_name) == '' || trim($column_name) == '' || trim($text_to_check) == '')
		{
			$message = "model name and/or column name and/or text to check not given";
		}
		else
		{
			try
			{
				$data = $model_name::where($column_name, $text_to_check)
									->get();

				if(count($data) == 0)
				{
					$status = 'success';
					$message = 'you can add this name';
				}
				else
				{
					$message = 'A record already exists with name '.$text_to_check;
				}

			}
			catch(PDOException $e)
			{
				$message = $e->getMessage();
			}

			return array('status' => $status, 'message' => $message);
		}
	}

	public static function generateSelectList($modelname, $name, $value, $field_name, $selected = '', $condition = array())
	{
		
		$columns = $modelname::where('is_active', 1)
							   ->where('id', '!=', 0);

		$count = count($condition);
		
		if($count && $count%3 == 0)
		{
			$i = 1;
			$whereParameters = array();

			foreach($condition as $c)
			{
				$whereParameters[$i-1] = $c;
				if($i == 3)
				{
					$columns->where($whereParameters[0], $whereParameters[1], $whereParameters[2]);
				}
				$i++;
				
			}
			//array('', '', '')
		}

		$columns->distinct();
		$columns = $columns->get(array($name, $value));
		
		$select = '<select id = '.$field_name.' name = '.$field_name.' >'."\n";

		foreach($columns as $col)
		{
			if($col->$value == $selected)
				$sel = 'selected';
			else
				$sel = '';
			$select .= '<option value = '.$col->$value.' '.$sel.'>'.$col->$name.'</option>'."\n";
		}
		
		$select .= '</select>';	
		
		echo $select;
	}

	public static function getUser()
	{
		if(Auth::user()->check())
		{
			$user = Auth::user()->username;
			$id = Auth::user()->id;
			$group = 'user';
		}
		else if(Auth::superAdmin()->check())
		{
			$user = Auth::superAdmin()->username;
			$id = Auth::superAdmin()->id;
			$group = 'superadmin';
		}
		else if(Auth::admin()->check())
		{
			$user = Auth::admin()->username;
			$id = Auth::admin()->id;
			$group = 'admin';
		}
		else
		{
			$user = 'unsubscribed';
			$id = 0;
			$group = 'unsubscribed';
		}

		return array('user' => $user, 'id' => $id, 'group' => $group);
	}

	public static function underscoreToSpace($word)
	{
		$words = explode('_', $word);

		$temp = '';
		if(count($words))
		{
			foreach($words as $word)
			{
				$temp .= ucfirst($word).' ';
			}
		}

		$temp = $temp == '' ? ucfirst($word) : trim($temp);

		return $temp; 
	}
}

?>