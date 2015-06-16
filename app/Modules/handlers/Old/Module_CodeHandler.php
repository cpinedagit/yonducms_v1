<?php

//Module_Code appends code in String form to selected files in the framework.


class Module_CodeHandler
{
	CONST MODULE_ROUTES = "Module_Routes.php";
	CONST MODULE_CONTROLLERS = "Controllers/";

	function writeCode($jsonPath) {
		//Check if the input file is a JSON file.
		if(is_file($jsonPath)) {
			$fileDetails = pathinfo($jsonPath);
			if($fileDetails['extension'] = ='json') {
				//Read the JSON file provided in the input.
				$jsonData = fread(fopen($jsonPath, 'r'), filesize($jsonPath)) or die("problem");
				$jsonArray = json_decode($jsonData);
				//Decode the JSON array based on... stuff.
				echo "<pre>";
				print_r($jsonArray);
				echo "</pre>";				
			}
		}
	}

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

$a = new Module_CodeHandler();
echo "HERE";
$a->writeCode('composer.json');