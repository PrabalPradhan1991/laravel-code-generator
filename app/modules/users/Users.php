<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;

class Users extends Eloquent implements UserInterface
{
	use UserTrait;

	protected $table = 'per_users';

	protected $fillable = ['name', 'fname', 'mname', 'lname', 'email', 'password', 'confirmation', 'contact', 'address', 'is_active'];
	
	public static $createRule = [
								'fname'	=>	array('required', 'min:1'),

							];
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