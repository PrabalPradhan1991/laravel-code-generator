<?php

class Theatre extends Eloquent
{
	protected $table = 'per_theatre';

	protected $fillable = ['theatre_name', 'location', 'description', 'is_active' ];



	public static $createRule = [];

	public static $updateRule = [];

	public static function getTableName()
	{
		return with (new static)->getTable();
	}

}