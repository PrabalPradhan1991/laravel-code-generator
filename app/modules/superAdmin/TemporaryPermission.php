<?php

class TemporaryPermission extends Eloquent
{
	protected $table = 'per_admin_temp_permission';

	protected $fillable = ['admin_id', 'controller_id', 'module_function_id', 'expiry_date', 'is_active'];

	public static $createRule = [
									'expiry_date' => 'required|date'
								];

	public static $updateRule = [
									'expiry_date' => 'required|date'
								];
	
	public static function getTableName()
	{
		return with(new static)->getTable();
	}
}