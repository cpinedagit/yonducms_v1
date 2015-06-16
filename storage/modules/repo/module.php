<?php


$filename = '../../app/Http/routes.php';
$input = "\nRoute::get('tomato', 'TomatoController@index');";

file_put_contents($filename, $input, FILE_APPEND | LOCK_EX );
echo "Appended";