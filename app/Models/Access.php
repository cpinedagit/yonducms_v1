<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Access extends Model {

	protected $table = 'accesses';

	protected $fillable = ['role_id', 'module_id', 'is_enabled', 'updated_at', 'created_at'];

	public static function getAccessFor($id)
	{
		return DB::table('accesses')
				->where('role_id', '=', $id)
				->get(['role_id', 'module_id', 'is_enabled']);
	}

	//Check if user has an access to a module
	//Receives Role ID & Module ID
	public static function checkAccess($role_id, $module_id)
	{
		return DB::table('accesses')
						->where('role_id', '=', $role_id)
						->where('module_id', '=', $module_id)
						->where('is_enabled', '=', 1)
						->count();
	}
	
}
