<?php

class ParentTheatre extends Eloquent
{
	protected $table = 'db_parent_theatre';

	protected $fillable = ['parent_name', 'parent_image', 'is_active' ];



	public static $createRule = [];

	public static $updateRule = [];

	public static function getTableName()
	{
		return with (new static)->getTable();
	}

}