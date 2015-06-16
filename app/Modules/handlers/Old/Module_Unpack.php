<?php

class Module_Unpack
{
	function unpack($targz) {
		$archive = new PharData($targz);
		try {
			$archive->extractTo(__DIR__);	
		} catch(Exception $e) {
			print_r($e);
		}		
	}
}

$a = new Module_Unpack();
$a->unpack('SampleModule.tar.gz');