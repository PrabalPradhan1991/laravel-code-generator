<?php

class Group extends Eloquent
{
	protected $table = 'per_groups';

	protected $fillable = ['group_name', 'is_active'];

	public static function 	getTableName()
	{
		return with(new static)->getTable();
	}

	public function check()
	{
		echo 'hello';
	}
}

?>