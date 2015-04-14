<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;

class Admin extends Eloquent implements UserInterface
{
	use UserTrait;

	protected $table = 'per_admins';

	protected $fillable = ['name', 'username', 'password', 'email', 'contact', 'address', 'group_id', 'is_active'];
	
	public static $createRule = [];
	public static $updateRule = [];

	public static function getTableName()
	{
		return with (new static)->getTable();
	}
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
}

?>