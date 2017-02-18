<?php
    require_once dirname(__FILE__).'/lib/PageAdmin.php';
    require_once dirname(__FILE__).'/lib/BaseAdmin.php';
	require_once dirname(__FILE__).'/lib/SimpleExcel.php';
	require_once dirname(__FILE__).'/lib/AdminPage.php';
	require_once dirname(__FILE__).'/lib/AjaxTable.php';
	require_once dirname(__FILE__).'/lib/Form.php';
	require_once dirname(__FILE__).'/lib/Generator.php';
	require_once dirname(__FILE__).'/lib/Parser.php';
    
    
    if(!file_exists(System::getInstance()->paths['root_dir'].System::getInstance()->modules_folder.DS.System::getInstance()->module) && System::getInstance()->module!='site/'){
        System::getInstance()->paths['main_root_dir']=System::getInstance()->paths['root_dir'];
        System::getInstance()->paths['main_root_code']=System::getInstance()->paths['root_code'];
        System::getInstance()->main_module=System::getInstance()->module;
        
        System::getInstance()->paths['root_dir']=__DIR__.'/';
        System::getInstance()->paths['root_code']=__DIR__.'/';
        System::getInstance()->module='module/';
    }
?>