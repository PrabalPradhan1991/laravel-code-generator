<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;

class SuperAdmin extends Eloquent implements UserInterface
{
	use UserTrait;

	protected $table = 'per_superadmin';

	protected $fillable = ['name', 'username', 'password', 'contact', 'is_active'];
	
	public static $createRule = array
				  (
					/*'product_name'			=> 	array('required', 'max:100', 'regex:/^[0-9a-zA-Z" "-]+$/'),
					'price'					=>	array('required', 'regex:/^([0-9]+)$|^([0-9]+\.[0-9]{2})$/'),
					'quality'				=>	'required',
					'description'			=> 	'required',
					'delivery_process'		=> 	'required'*/

					'name'	=>	array('required', 'min:1')
				);

	public static $updateRule = [];

	public static function getTableName()
	{
		return with(new static)->getTable();
	}
	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
}

?>