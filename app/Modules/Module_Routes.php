<?php
/**
 * Module_Routes
 * 
 */


Route::resource('cms/samplemodule', 'SampleController');



Route::get('samplemodule', 'SampleController@index');

Route::get('cms.samplemodule', 'SampleController@index');
