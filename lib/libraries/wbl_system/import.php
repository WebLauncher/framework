<?php

System::getInstance()->paths['main_root_dir'] = System::getInstance()->paths['root_dir'];
System::getInstance()->paths['main_root_code'] = System::getInstance()->paths['root_code'];
System::getInstance()->main_module = System::getInstance()->module;

System::getInstance()->paths['root_dir'] = __DIR__ . '/';
System::getInstance()->paths['root_code'] = __DIR__ . '/';
System::getInstance()->template_engine = 'smarty';
System::getInstance()->module = 'module/';
System::getInstance()->subquery=array('module','home');