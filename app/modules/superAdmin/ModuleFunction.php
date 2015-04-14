<?php

class ModuleFunction extends Eloquent
{
	protected $table = 'per_modules_functions';

	protected $fillable = ['module_id', 'module_function_code', 'is_active'];

	public static function getTableName()
	{
		return with(new static)->getTable();
	}

	public $timestamps = false;

	public function permissions()
	{
		return $this->hasMany('Permission', 'module_function_code_id', 'id');
	}

	public function modulecontroller()
	{
		return $this->belongsTo('Module', 'module_id', 'id');
	} 
}

?>