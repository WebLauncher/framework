<?php
    require_once dirname(__FILE__).'/lib/PageAdmin.php';
    require_once dirname(__FILE__).'/lib/BaseAdmin.php';
	require_once dirname(__FILE__).'/lib/SimpleExcel.php';
	require_once dirname(__FILE__).'/lib/AdminPage.php';
	require_once dirname(__FILE__).'/lib/AjaxTable.php';
	require_once dirname(__FILE__).'/lib/Form.php';
	require_once dirname(__FILE__).'/lib/Generator.php';
	require_once dirname(__FILE__).'/lib/Parser.php';
    
    global $page;
    if(!is_dir($page->paths['root_dir'].$page->modules_folder.$page->module) && $page->module!='site/'){
        $page->paths['main_root_dir']=$page->paths['root_dir'];
        $page->paths['main_root_code']=$page->paths['root_code'];
        $page->main_module=$page->module;
        
        $page->paths['root_dir']=__DIR__.'/';
        $page->paths['root_code']=__DIR__.'/';
        $page->module='module/';
    }
?>