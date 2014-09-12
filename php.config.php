<?php
	//MODULES GLOBAL CONFIG
	/* configure table models aliases
	$page->tables = array(
	 	'tbl_table'=>'table_new'
	);
	*/
	
	/* Use to import CSS files into template
	$page->add_css_file('{$skin_styles}screen.css');
	$page->add_css_file('{$skin_styles}ui.css');
	$page->add_css_file('{$skin_styles}ie.css','text/css','screen, projection','if IE');
	*/
	
	/* Use to import JS files into template */
	$page->add_js_file('{$root_scripts}jquery/jquery.js');
	 
	
	$host=isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'localhost';
	switch ($host)
	{
		case '86.105.121.23':
	  	case 'localhost':
	  		$page->db_connections=array
	  		(
	  			0=>array('host'=>'localhost','user'=>'root','password'=>'','dbname'=>'base')
	  		);
			// display page trace
			$page->trace=true;
			// live page flag
			$page->live=false;
			// Debug Set
			$page->debug = true;
			
			$page->build_enabled=true;
			
			$page->build_auto=false;
	  	break;

		default:
			trigger_error('Unknown database configuration for host <b>' . $_SERVER['HTTP_HOST'] . '</b>. Modify php.config.php');
			exit;
		break;
	}
	
	// site crypting key
	$page->crypt_key='site.com';
?>