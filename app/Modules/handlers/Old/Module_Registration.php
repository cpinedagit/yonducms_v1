<?php

class Module_Registration {

	var $connection;
	var $module_data;

	CONST INSERT_CONTENT_DETAILS = 'INSERT INTO `content_details` (content_name, content_table) VALUES';
	CONST INSERT_MODULE_DETAILS = 'INSERT INTO `modules` (module_name, module_description, module_path, module_icon, module_type) VALUES';
	CONST INSERT_MODULE_TABLES = 'INSERT INTO `module_tables` (table_name, module_id) VALUES';

	function __construct($module_data = NULL) {
		//Securitify this first.
		$this->connection = new PDO('mysql:host=localhost;dbname=yws_dev_mods', 'root', 'root');
		$this->module_data = $module_data;
	}

	function prepareInsertContents($contentArray) {
		$output = "(";
		$i = 0;
		foreach($contentArray as $index => $content) {
			$output .= "'";
			$output .= $content;
			$output .= "'";
			if(++$i != count($contentArray) ) { $output .= ","; }
		}
		$output .= ")";
		return $output;
	}

	function prepareInsertValues($index) {
		$values = '';
		$insert_data = $this->module_data[$index];
		$i = 0;
		foreach($insert_data as $index => $content) {
			$values .= $this->prepareInsertContents($content);
			if(++$i != count($insert_data) ) { $values .= ","; }
		}
		return $values;
	}


	function go() {
		$indexStatements = array(
			'content_details' => 'INSERT_CONTENT_DETAILS',
			'modules' => 'INSERT_MODULE_DETAILS',
			'module_tables' => 'INSERT_MODULE_TABLES'
			);

		foreach($indexStatements as $index => $statement) {
			$baseQuery = constant('self::' . $statement);
			$values = $this->prepareInsertValues($index);
			$statement = $baseQuery . $values;
			echo $statement;			
			try{
				$affected_rows = $this->connection->exec($statement);
				echo $affected_rows . "were affected.";
			} catch( PDOException $exception ) {
				echo "Whoah exception!";
			}
		}
	}

	function getModuleID() {}

}

$testArray = array(
	'content_details' => array(
			array(
				'content_name' 	=> 'Test Unique Module Content',
				'content_table' => 'content_json'
			), 		
			array(
				'content_name' 	=> 'Test Unique Module HTML',
				'content_table' => 'content_HTML'
			)
		), 
	'modules' => array(
			array(	
				'module_name' 			=> 'Module Registration Test',
				'module_description' 	=> 'Just testing something!',
				'module_path' 			=> 'cms.module.test',
				'module_icon' 			=> 'fa-gears',
				'module_type' 			=> 'testing'
			), 
			array(
				'module_name' 			=> 'Just another module',
				'module_description' 	=> 'Another module to test',
				'module_path' 			=> 'cms.module.test2',
				'module_icon' 			=> 'fa-paintbrush',
				'module_type' 			=> 'diagnostic'
			)
		),
	'module_tables' => array(
			array(
				'table_name' 	=> 'content_newTest',
				'module_id' => '5'
			),
			array(
				'table_name' 	=> 'content_TestTest',
				'module_id' => '3'
			)
		));

echo "Successfully imported. \n";