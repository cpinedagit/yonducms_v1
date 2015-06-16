<?php

class Module_FileHandler 
{
	function copyDirectoryStructure($src, $dst) { 
	    $dir = opendir($src);
	    if(!file_exists($dst)) { mkdir($dst); }
	    while(false !== ( $file = readdir($dir)) ) { 
	        if (( $file != '.' ) && ( $file != '..' )) { 
	            if ( is_dir($src . '/' . $file) ) { 
	                $this->copyDirectoryStructure($src . '/' . $file, $dst . '/' . $file);
	            } else {
	            	copy($src . '/' . $file, $dst . '/' . $file);
	            }
	        } 
	    } 
    	closedir($dir); 
	}
	
	function clearDirectory($dir) {
		if (is_dir($dir)) {
	    	$objects = scandir($dir);
	    	foreach ($objects as $object) {
	      		if ($object != "." && $object != "..") {
	        		if (filetype($dir."/".$object) == "dir") {
	        			$this->clearDirectory($dir."/".$object);
	        		} else {
	        			unlink($dir."/".$object);
	        		}
	      		}
	    	}
	    	reset($objects);
	    	rmdir($dir);
	  	}
 	}
}

//Diagnostic message:
echo "File transfer framework loaded.\n";