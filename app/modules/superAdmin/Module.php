<?php

class Module extends Eloquent
{
	protected $table = 'per_modules';

	protected $fillable = ['module_name', 'is_active'];

	public static $createRule = array
								(
									'module_name'	=>	'required|unique:per_modules,module_name'
								);

	public function getUpdateRules($id)
	{
		return array
				(
					'module_name'	=>	'required|unique:'.$this->table.',module_name,'.$id
				);
	}

	public static function getTableName()
	{
		return with(new static)->getTable();
	}

	public $timestamps = false;

	public function permissions()
    {
        return $this->hasManyThrough('Permission', 'ModuleFunction', 'module_id', 'module_function_code_id');
        //return $this->hasManyThrough('BucketTravelagents', 'BucketTravelagentsServices', 'service_id', 'travel_agent_id');
    }

    public function modulefunction()
    {
    	return $this->hasMany('ModuleFunction', 'module_id', 'id');
    }
}

?>