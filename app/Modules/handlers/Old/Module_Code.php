<?php

//Module_Code appends code in String form to selected files in the framework.


class Module_Code
{
	CONST MODULE_ROUTES = "Module_Routes.php";
	CONST MODULE_CONTROLLERS = "Controllers/";

	//Adds a route.
	function addRoute($url, $controller, $method) {
		$routeString = "\nRoute::get('" . $url . "', '" . $controller . "@" . $method . "');\n";
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
echo "Code injection framework loaded.\n";
