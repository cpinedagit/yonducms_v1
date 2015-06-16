<?php

//---------------------------------------------------
// ModuleInstaller Class
//---------------------------------------------------
/*
 * Installs a module via AJAX.
 * 
 * File Path : script/
 * File Name : ModuleInstaller.php
 * 
 * Type      : yws_modules core
 */

include_once('config.php');
// define('EXTDIR', MODULES_REPOSITORY . 'ext/');
// define('SQLDIR', MODULES_REPOSITORY . 'ext/SQL');
// define('FILDIR', MODULES_REPOSITORY . 'ext/files');
// define('MODTGT', MODULES_REPOSITORY . 'module.tar.gz');
// define('JSNTGT', MODULES_REPOSITORY . 'ext/module.json');

class Module_Installer
{

	function __construct() {	
		require_once('handlers/Module_Archiver.php');
		require_once('handlers/Module_SqlHandler.php');
		require_once('handlers/Module_FileHandler.php');
		require_once('handlers/Module_CodeHandler.php');
	}


		// const EXTRACT_DIRECTORY 	= $extract_directory;
		// const SQL_DIRECTORY 		= $sql_directory;
		// const FILE_DIRECTORY 		= $file_directory;
		// const MODULE_TARGET 		= $module_target;
		// const MODULE_JSON_TARGET 	= $module_json_target; 

	function installModule() {
		$extract_directory = storage_path() . '/modules/ext/';
		$sql_directory = storage_path() . '/modules/ext/SQL/';
		$file_directory = storage_path() . '/modules/ext/files/';
		$module_target = storage_path() . '/modules/module.tar.gz';
		$module_json_target = storage_path() . '/modules/ext/module.json';
		$archivist 	= new Module_Archiver();
		$scribe 	= new Module_SqlHandler();
		$librarian 	= new Module_FileHandler();
		$editor 	= new Module_CodeHandler();
		// 	// echo "\nExtracting package...\n";
		// $extract = $archivist->unpack($module_target, $extract_directory);
		// 	// echo "\nDONE!\n"; 	
		// 	// echo "\nRunning SQL scripts...\n";
		// 	// $_POST['directory'] = $sql_directory;
		// 	// return false;
		$queries = $scribe->executeScripts($sql_directory);

		// 	// echo "\nDONE!\n";
		// 	// echo "\nCopying file structure...\n";
			$files 		= $librarian->copyDirectoryStructure($file_directory, base_path());
		// 	// echo "\nDONE!\n";
		// 	// echo "\nInjecting code...\n!";
			$editor->writeCode($module_json_target);
		// 	// echo "\nDONE!\n";
		// 	return $extract_directory;
			return TRUE;
		// } catch (Exception $e) {
		// 	echo $e->getMessage();
		// 	return FALSE;
		// }
	}
}