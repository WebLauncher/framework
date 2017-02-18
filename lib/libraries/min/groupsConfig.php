<?php

System::getInstance()->import('file', System::getInstance() -> paths['root_code'] . $_REQUEST['module']. '/config.php');
System::getInstance()->module=System::getInstance()->session_cookie_module?System::getInstance()->session_cookie_module:$_REQUEST['module'];
System::getInstance()->session_cookie=str_replace('_'.System::getInstance()->module,'',$_REQUEST['ck']);
	
System::getInstance()->init_session();

/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/**
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 **/
$arr=array();
foreach(System::getInstance()->session['__js_files'] as $k=>$v)
{
	$arr['js_site'.$k]=$v;
}
return $arr;