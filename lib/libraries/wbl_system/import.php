<?php
    global $page;    
    $page->paths['main_root_dir']=$page->paths['root_dir'];
    $page->paths['main_root_code']=$page->paths['root_code'];
    $page->main_module=$page->module;
    
    $page->paths['root_dir']=__DIR__.'/';
    $page->paths['root_code']=__DIR__.'/';
    $page->module='module/';
    
?>