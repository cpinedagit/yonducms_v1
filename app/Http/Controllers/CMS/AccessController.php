<?php namespace App\Http\Controllers\CMS;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Access;
use App\Models\SubAccess;
use App\Models\SubMenu;
use App\Models\Role;
use Input;

use Illuminate\Http\Request;

class AccessController extends Controller {

	protected $accesses;

	public function index()
	{
		$this->regenerateMenuSession('cms.user.index', 'cms.role.index');			
	}

	public function create()
	{
		//
	}

	public function store(RoleController $role)
	{
		$module_enabled = "module_enabled";
		$sub_enabled = "sub_enabled";
		$module_log = null;
		$sub_log = null;
		$role_id = Input::get('role');

		foreach(modules() as $module):
			$module_name = $module_enabled . $module->id;
			$access = new Access;
			$access->role_id = $role_id;
			$access->module_id = $module->id;
			$access->is_enabled = (Input::get($module_name) != null && Input::get($module_name) != '') ? Input::get($module_name) : 0;
			$access->save();
		endforeach;

		foreach(submenus() as $menu):
			$sub_name = $sub_enabled . $menu->id;
			$subAccess = new SubAccess;
			$subAccess->role_id = $role_id;
			$subAccess->submenu_id = $menu->id;
			$subAccess->is_enabled = (Input::get($sub_name) != null && Input::get($sub_name) != '') ? Input::get($sub_name) : 0;
			$subAccess->save();
		endforeach;
		
		return $role->index();

	}

	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		$this->regenerateMenuSession('cms.user.index', 'cms.role.index');
		$access = Access::where('role_id', '=', $id)
					->get(['role_id', 'module_id', 'is_enabled']);
		$subAccess = SubAccess::where('role_id', '=', $id)
					->get(['role_id', 'submenu_id', 'is_enabled']);
		$role = Role::getRoleOf($id);
		$existing = count($access);
		
		if($existing > 0) {			
			return view('cms.accesses.edit', compact('access', 'subAccess', 'role'));
		} else {			
			return view('cms.accesses.create', compact('access', 'role'));
		}

	}

	public function update($id)
	{
		//
	}

	public function destroy($id)
	{
		Access::where('role_id', '=', $id)
				->delete();
		SubAccess::where('role_id', '=', $id)
				->delete();
	}

	public function modifyAccess(RoleController $role)
	{
		$module_enabled = "module_enabled";
		$sub_enabled = "sub_enabled";
		$module_log = null;
		$sub_log = null;
		$role_id = Input::get('role');		
		$this->destroy($role_id);

		foreach(modules() as $module):			
			$module_name = $module_enabled . $module->id;
			$access = new Access;
			$access->role_id = $role_id;
			$access->module_id = $module->id;
			$access->is_enabled = (Input::get($module_name) != null && Input::get($module_name) != '') ? Input::get($module_name) : 0;
			$access->save();
		endforeach;

		foreach(submenus() as $menu):
			$sub_name = $sub_enabled . $menu->id;
			$subAccess = new SubAccess;
			$subAccess->role_id = $role_id;
			$subAccess->submenu_id = $menu->id;
			$subAccess->is_enabled = (Input::get($sub_name) != null && Input::get($sub_name) != '') ? Input::get($sub_name) : 0;
			$subAccess->save();
		endforeach;

		return $role->index();
	}

}
