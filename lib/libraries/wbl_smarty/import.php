<?php
	require_once dirname(__FILE__).'/SmartyExtensions.php';
	
	$extension=new SmartyExtensions(System::getInstance()->libraries_settings['smarty']['version']);
	$extension->system=System::getInstance();
	$extension->register();