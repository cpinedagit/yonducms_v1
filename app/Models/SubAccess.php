<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class SubAccess extends Model {

	protected $table = 'sub_accesses';

	protected $fillable = ['role_id', 'submenu_id', 'is_enabled',  'updated_at', 'created_at'];

	public static function getSubAccessFor($id)
	{
		return DB::table('sub_accesses')
				->where('role_id', '=', $id)
				->get(['role_id', 'submenu_id', 'is_enabled']);
	}

}
