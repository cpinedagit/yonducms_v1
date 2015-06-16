<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class SubMenu extends Model {

	protected $table = 'submenus';

	protected $fillable = ['submenu_name', 'submenu_description', 'submenu_path', 'is_active', 'module_id'];

	public static function getActiveSubMenus()
	{
		return DB::table('submenus')
					->where('is_active', '=', '1')
					->get([
						'id', 'submenu_name', 'submenu_description',
						'submenu_path', 'is_active', 'module_id']);		
	}

	public static function getActiveSubMenusCountFor($id)
	{
		return DB::table('submenus')
				->where('module_id', '=', $id)
				->where('is_active', '=', '1')
				->get([
						'id', 'submenu_name', 'submenu_description',
						'submenu_path', 'is_active', 'module_id']);		
	}
}
