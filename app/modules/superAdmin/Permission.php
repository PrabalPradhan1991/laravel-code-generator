<?php

class Permission extends Eloquent
{
	protected $table = 'per_permissions';

	public $timestamps = false;

	protected $fillable = ['allowed_groups', 'module_function_code_id', 'is_active'];

	public static function getTableName()
	{
		return with(new static)->getTable();
	}

	public function getUpdateRules($id)
	{
		return array
				(
					'module_function_code_id' => 'required|unique:'.ModuleFunction::getTableName().',module_function_code_id,'.$id,
				);
	}
}

?>