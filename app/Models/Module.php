<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Module extends Model {

	protected $table = 'modules';

	protected $fillable = ['module_name', 'module_description'];

	public static function getActiveModules()
	{
		$modules = DB::table('modules')
					->where('enabled', '=', '1')
					->get([
						'id', 'module_name', 'module_path',
						'module_icon', 'is_selected']);
		return $modules;
	}

	public static function getInstalledModules()
	{
		$modules = DB::table('modules')
					->where('enabled', '=', '1')
					->where('module_type', '=', '1')
					->get([
						'id', 'module_name', 'module_path',
						'module_icon', 'is_selected']);
		return $modules;
	}

	public static function saveGetId($module)
	{
		return DB::table('modules')
				->insertGetId(array(
					'module_name' => $module->module_name,
					'module_description' => $module->module_description,
					'module_path' => $module->module_path,
					'module_icon' => $module->module_icon,
					'module_type' => $module->module_type
					));
	}

}
