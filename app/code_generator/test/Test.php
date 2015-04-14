<?php

class Test extends Eloquent
{
	protected $table = 'per_test';

	protected $fillable = ['check_check', 'is_active' ];



	public static $createRule = [];

	public static $updateRule = [];

	public static function getTableName()
	{
		return with (new static)->getTable();
	}

}