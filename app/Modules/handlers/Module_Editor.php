<?php

//Module_Code appends code in String form to selected files in the framework.

require_once('config.php');

class Module_Editor
{
	CONST MODULE_ROUTES = MODULES_HANDLER . "Module_Routes.php";

	//Adds a route.
	function addRoute($url, $controller, $method) {
		$routeString = "\nRoute::resource('" . $url . "', '" . $controller . "@" . "');\n";
		$this->appendString(self::MODULE_ROUTES, $routeString);
	}

	private function appendString($file, $string) {
		try {
			file_put_contents($file, $string, FILE_APPEND | LOCK_EX);
			return TRUE;
		} catch(Exception $e) {
			return FALSE;
		}
	}
}

//Diagnostic message:
// echo "Code injection framework loaded.\n";
