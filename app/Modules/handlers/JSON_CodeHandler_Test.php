<?php

//CodeHandler Test
$a = array();
//Diagnostic code: Add timestamp of module installation to Module_Installer.php
$a['/app/Modules/Module_Installer.php'] = '//New module added: ' . date("Y-m-d h:i:sa", time());
$a['/app/Modules/Module_Routes.php'] = '//New route added: ' . date("Y-m-d h:i:sa", time());
$a['/app/Modules/Module_Routes.php'] = 'Route::get("modules", ModuleController@index);';
$b = array();
$c = array();
$c['controller'] = 'SampleController';
$c['method'] = 'index';
$c['url'] = "samplemodule";
$b[] = $c;

$d = array();
$d['custom-appends'] = $a;
$d['routes-appends'] = $b;

$string = json_encode($d);
file_put_contents('module.json', $string, FILE_APPEND | LOCK_EX);
