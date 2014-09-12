<?php
	require_once dirname(__FILE__).'/SmartyExtensions.php';
	global $page;
	$extension=new SmartyExtensions($page->libraries_settings['smarty']['version']);
	$extension->system=&$page;
	$extension->register();
?>