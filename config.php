<?php
/*
	Add config files to the system this will load extra config in case hostnames or
	callback function are matched.

	Add 'console' as hostname if that configuration should be loaded when script is run
	from console.

	By default 'development' is set to array('localhost','127.0.0.1') so there no need
	to add it.

	$this -> add_config('development', 'localhost');
*/

$this->add_config('production', 'example.com');
$this->add_config('development', array('localhost:10001','localhost:8888'));

/*
	Use to import CSS files into template

	$page->add_css_file('{$skin_styles}screen.css');
 	$page->add_css_file('{$skin_styles}ui.css');
 	$page->add_css_file('{$skin_styles}ie.css','text/css','screen, projection','if IE');
*/
$this->add_css_file('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css');

/* 
	Use to import JS files into template 

	$this->add_js_file('{$root_scripts}jquery/jquery.js');
*/
$this->add_js_file('{$root_scripts}jquery/jquery.js');
$this->add_js_file('{$root_scripts}validation/jquery.validate.js');
$this->add_js_file('{$root_scripts}validation/jquery.validate-ext.js');

// site crypting key
$this->crypt_key = 'site.com';
?>