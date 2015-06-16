<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Role extends Model {

	protected $table = 'role_details';

	protected $fillable = ['role_id', 'role_name', 'role_description', 'isactive'];

	public static function getActiveRoles()
	{
		return DB::table('role_details')
				->where('role_active', '=', 1)
				->get(['id', 'role_name', 'role_description', 'role_active', 'type']);
	}

	public static function getRoleOf($id)
	{
		return DB::table('role_details')
				->where('id', '=', $id)
				->get(['id', 'role_name']);
	}

	public static function getActiveAllowedRoles()
	{
		return DB::table('role_details')
				->where('role_active', '=', 1)
				->where('type', '=', 0)
				->get(['id', 'role_name', 'role_description', 'role_active', 'type']);
	}

	public static function saveGetId($role)
	{
		return DB::table('role_details')
				->insertGetId(array(
					'role_name' => $role->role_name,
					'role_description' => $role->role_description,
					'role_active' => $role->role_active		
					));
	}

}
