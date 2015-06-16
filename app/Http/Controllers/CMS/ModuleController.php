<?php namespace App\Http\Controllers\CMS;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller {
	
	protected $modules;

	public function __construct(Module $module)
	{
		$this->modules = $module;
	}

	public function index()
	{

	}

	public function create()
	{

	}
	
	public function store()
	{
		//
	}
	
	public function show($id)
	{
		//
	}

	public function edit($id)
	{
		//
	}
	
	public function update($id)
	{
		//
	}

	public function destroy($id)
	{
		//
	}

}
