<?php

//Module_Code appends code in String form to selected files in the framework.

require_once('config.php');
// define('MDLRTS', 'app/Modules/Module_Routes.php');
class Module_CodeHandler
{
	CONST CUSTOM_CODE_INDEX = 'custom-appends';
	CONST NEW_ROUTE_INDEX = 'routes-appends';

	function writeCode($jsonPath) {
		//Check if the input file is a JSON file.
		if(is_file($jsonPath)) {
			$fileDetails = pathinfo($jsonPath); 
			if($fileDetails['extension'] == 'json') {
				//Read the JSON file provided in the input.
				$jsonData = fread(fopen($jsonPath, 'r'), filesize($jsonPath)) or die("problem");
				$jsonArray = json_decode($jsonData, TRUE);
				//Decode the JSON array.
				if(is_array($jsonArray[self::CUSTOM_CODE_INDEX])) {
					$codeArray = $jsonArray[self::CUSTOM_CODE_INDEX];
					foreach($codeArray as $filepath => $code) {
						$this->appendString(base_path() . '/' . $filepath, $code);
					}
				} else { //WARNING: No custom code index in JSON file.
				}
				if(is_array($jsonArray[self::NEW_ROUTE_INDEX])) {
					$newRoutes = $jsonArray[self::NEW_ROUTE_INDEX];
					foreach($newRoutes as $newRoute) {
						if(is_array($newRoute)) {
							// print_r($newRoute);
							$this->addRoute($newRoute['url'], $newRoute['controller'], $newRoute['method']);
						} else { //WARNING: New route is not an array. 
						}
					}	
				} else { //WARNING: No new routes indicated in JSON file.
				}
			} else { //ERROR: Wrong file extension
			}
		} else { //ERROR: Not a file. 
		}
	}

	//Adds a route.
	private function addRoute($url, $controller, $method) {
		$module_routes = app_path() . '/Modules/Module_Routes.php';
		$routeString = "Route::get('" . $url . "', '" . $controller . "@" . $method . "');";
		$this->appendString($module_routes, $routeString);
	}

	private function appendString($file, $string) {

		$string = "\n" . $string . "\n";
		try {
			file_put_contents($file, $string, FILE_APPEND | LOCK_EX);
			return TRUE;
		} catch(Exception $e) {
			return FALSE;
		}
	}
}
// $test = new Module_CodeHandler('../../../');
// $test->writeCode('TEST.json');
