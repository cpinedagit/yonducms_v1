<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleManager extends Model {

	function getModules() {
		$script = "SELECT * FROM modules where module_type = 1";
		DB::select($script, array(1));
	}

}
