<?php

Class ListenersController extends Controller
{
	public function temporaryPermissionExpire($job, $admin_id)
	{
		$failCount = 0;
		$success = false;

		do
		{
			try 
			{
	            DB::connection()->getPdo()->beginTransaction();

	            TemporaryPermission::where('admin_id', $admin_id)
	            					->delete();

	            Admin::where('id', $admin_id)
	            		->update(array('temp_permission' => 0));

	         	DB::connection()->getPdo()->commit();
	        } 
	        catch (\PDOException $e)
	    	{
	    		DB::connection()->getPdo()->rollBack();
	    		$failCount++;
	    	}
	    }while(!$success && $failCount < 3)
	    $job->delete();
	}
}