<?php

class ListHeaderTable extends Eloquent
{
	protected $table = "per_list_table_headers";
	protected $fillable = ['is_active', 'controller_id', 'headers', 'column_width', 'sort_order'];

	public static $createRule = [];
	public static $updateRule = [];

	public static function getTableName()
	{
		return with(new static)->getTable();
	}	

}