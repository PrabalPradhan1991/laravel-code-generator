<?php

class Reservation extends Eloquent
{
	protected $table = 'per_reservation';

	protected $fillable = ['reservation_name', 'reservation_type', 'reservation_location', 'is_active' ];



	public static $createRule = [];

	public static $updateRule = [];

	public static function getTableName()
	{
		return with (new static)->getTable();
	}

}