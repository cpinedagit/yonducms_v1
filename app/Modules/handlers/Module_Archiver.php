<?php

class Module_Archiver
{
	function unpack($targz, $dir) {
		$archive = new PharData($targz);
		$this->clearDirectory($dir);
		try {
			$archive->extractTo($dir, NULL, TRUE);
			return TRUE;	
		} catch(Exception $e) {
			print_r($e);
			//Handle the error.
		}		
	}

	function clearDirectory($dir, $root = TRUE) {
		if (is_dir($dir)) {
	    	$objects = scandir($dir);
	    	foreach ($objects as $object) {
	      		if ($object != "." && $object != "..") {
	        		if (filetype($dir."/".$object) == "dir") {
	        			$this->clearDirectory($dir."/".$object, FALSE);
	        		} else {
	        			unlink($dir."/".$object);
	        		}
	      		}
	    	}
	    	reset($objects);
	    	if(!$root) {
	    		rmdir($dir);
	    	}
	  	}
 	}
}