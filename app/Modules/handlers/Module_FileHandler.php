<?php

class Module_FileHandler 
{
	function copyDirectoryStructure($src, $dst) { 
		// echo 'triggered';
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
	

}

//Diagnostic message:
//echo "File transfer framework loaded.\n";