<?php

class Inventory extends Eloquent
{
	protected $table = 'per_inventory';

	protected $fillable = ['inventory_name', 'inventory_price', 'inventory_stock', 'is_active' ];



	public static $createRule = [];

	public static $updateRule = [];

	public static function getTableName()
	{
		return with (new static)->getTable();
	}

}