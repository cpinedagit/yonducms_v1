<?php namespace App\Http\Controllers\CMS;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\RoleRequest;
use App\Models\Role;
use App\Models\Access;
use App\Models\SubAccess;
use App\Models\SubMenu;
use Illuminate\Http\Request;
use Input;
use Redirect;

class RoleController extends Controller {
	
	protected $role;

	public function index()
	{
		$this->regenerateMenuSession('cms.user.index', 'cms.role.index');
		$roles = Role::all();
		return view('cms.roles.index', compact('roles'));
	}

	public function create()
	{
		$this->regenerateMenuSession('cms.user.index', 'cms.role.index');
		return view('cms.roles.create', compact('role'));
	}

	public function store()
	{	
		$this->regenerateMenuSession('cms.user.index', 'cms.role.index');
		$role = new Role;
		$role->role_name = Input::get('role_name');
		$role->role_description = Input::get('role_description');
		$role->role_active = Input::get('role_active');
		$result = Role::saveGetId($role);

		if($result > -1) {
			$module_enabled = "module_enabled";
			$sub_enabled = "sub_enabled";
			$module_log = null;
			$sub_log = null;
			$role_id = $result;

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
		}

		return Redirect::route('cms.role.index');
	}

	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		$this->regenerateMenuSession('cms.user.index', 'cms.role.index');
		$role = Role::where('id', '=', $id)->firstOrFail();
		$access = Access::where('role_id', '=', $id)
					->get(['role_id', 'module_id', 'is_enabled']);
		$subAccess = SubAccess::where('role_id', '=', $id)
					->get(['role_id', 'submenu_id', 'is_enabled']);
		$existing = count($access);
		//add codes for checking if there's existing role access for a specific role

		return view('cms.roles.edit', compact('role', 'access', 'subAccess'));
	}

	public function update($id)
	{
		$role = Role::find($id);
		$role->role_name = Input::get('role_name');
		$role->role_description = Input::get('role_description');
		$role->role_active = Input::get('role_active');

		if($role->save()) {
			$module_enabled = "module_enabled";
			$sub_enabled = "sub_enabled";
			$module_log = null;
			$sub_log = null;
			$role_id = $id;
			$this->destroyAccess($id);

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
		}

		return Redirect::route('cms.role.index');
	}

	public function destroy($id)
	{
		$role = Role::find($id);
		$role->delete();
		$this->destroyAccess($id);
		return Redirect::route('cms.role.index');
	}

	public function destroyAccess($id)
	{
		Access::where('role_id', '=', $id)
				->delete();
		SubAccess::where('role_id', '=', $id)
				->delete();
	}

	public function modifyAccess()
	{
		$id = Input::get('role_id');
		$role = Role::find($id);
		$role->role_name = Input::get('role_name');
		$role->role_description = Input::get('role_description');
		$role->role_active = Input::get('role_active');
		
		if($role->save()) {
			$module_enabled = "module_enabled";
			$sub_enabled = "sub_enabled";
			$module_log = null;
			$sub_log = null;
			$role_id = $id;
			$this->destroyAccess($id);

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
		}

		return Redirect::route('cms.role.index');
	}
}
