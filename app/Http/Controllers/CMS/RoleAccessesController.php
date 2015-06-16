<?php namespace App\Http\Controllers\CMS;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\CMS\RoleAccessesRequest;
use App\Models\Module;
use App\Models\Role;
use App\Models\RoleAccesses;
use Illuminate\Http\Request;

class RoleAccessesController extends Controller {
	
	protected $roleAccesses;

	public function index()
	{
		$this->regenerateMenuSession('cms.user.index', 'cms.role.index');
		$roleAccesses = RoleAccesses::all();
		return view('cms.roleaccesses.index', compact('roleAccesses'));
	}

	public function create()
	{
		$this->regenerateMenuSession('cms.user.index', 'cms.role.index');
		$roles = Role::where('role_active', '=', '1')->get(['role_name', 'id']);
		$modules = Module::all();

		$data = (object) array('roles' => $roles, 'modules' => $modules);
		return view('cms.roleaccesses.create', compact('data'));
	}	

	public function store(RoleAccessesRequest $request, RoleController $role)
	{
		$count = 0;
		$add = "add";
		$edit = "edit";
		$delete = "delete";
		$view = "isactive";
		$log = (object) array('addflag' => null, 'deleteflag' => null, 'editflag' => null, 'isactive');

		$modules = Module::all();

		foreach($modules as $module):
			$add_name = $add . $module->id;
			$edit_name = $edit . $module->id;
			$delete_name = $delete . $module->id;
			$view_name = $view . $module->id;

			RoleAccesses::create(array(
				'role_id' => $request->input('role'),
				'module_id' => $module->id,
				'addflag' => ($request->input($add_name) != null && $request->input($add_name) != '') ? $request->input($add_name) : 0,
				'editflag' => ($request->input($edit_name) != null && $request->input($edit_name) != '') ? $request->input($edit_name) : 0,
				'deleteflag' => ($request->input($delete_name) != null && $request->input($delete_name) != '') ? $request->input($delete_name) : 0,
				'isactive' => ($request->input($view_name) != null && $request->input($view_name) != '') ? $request->input($view_name) : 0
				));			
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
		$roleAccesses = RoleAccesses::where('role_id', '=', $id)
					->get(['role_id', 'module_id', 
							'addflag', 'editflag', 
							'deleteflag', 'isactive']);

		$existing = count($roleAccesses);			

		$modules = Module::where('enabled', '=', '1')
					->get(['id', 'module_name']);

		$role = Role::where('id', '=', $id)
				->get(['id','role_name']);

		$data = (object) array('role' => $role, 
						'modules' => $modules,
						'roleAccesses' => $roleAccesses);
		
		if($existing > 0) {
			return view('cms.roleaccesses.edit', compact('data'));
		} else {
			return view('cms.roleaccesses.create', compact('data'));
		}
		//return view('cms.roleaccesses.edit', compact('data'));
	}

	public function update($id)
	{
		echo $id;
	}

	public function destroy($id, RoleController $role)
	{
		RoleAccesses::where('role_id', '=', $request->input('role'))
					->delete();
		return $role->index();
	}

	public function modifyAccess(RoleAccessesRequest $request, RoleController $role)
	{

		RoleAccesses::where('role_id', '=', $request->input('role'))
					->delete();

		$count = 0;
		$add = "add";
		$edit = "edit";
		$delete = "delete";
		$view = "isactive";
		$log = (object) array('addflag' => null, 'deleteflag' => null, 'editflag' => null, 'isactive');

		$modules = Module::all();

		foreach($modules as $module):
			$add_name = $add . $module->id;
			$edit_name = $edit . $module->id;
			$delete_name = $delete . $module->id;
			$view_name = $view . $module->id;

			RoleAccesses::create(array(
				'role_id' => $request->input('role'),
				'module_id' => $module->id,
				'addflag' => ($request->input($add_name) != null && $request->input($add_name) != '') ? $request->input($add_name) : 0,
				'editflag' => ($request->input($edit_name) != null && $request->input($edit_name) != '') ? $request->input($edit_name) : 0,
				'deleteflag' => ($request->input($delete_name) != null && $request->input($delete_name) != '') ? $request->input($delete_name) : 0,
				'isactive' => ($request->input($view_name) != null && $request->input($view_name) != '') ? $request->input($view_name) : 0
				));			
		endforeach;

		return $role->index();

	}

}
