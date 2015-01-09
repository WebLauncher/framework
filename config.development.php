<?php
// display page trace
$this -> trace = true;
// live page flag
$this -> live = false;
// Debug Set
$this -> debug = true;
// enable build
$this -> build_enabled = true;
// auto build
$this -> build_auto = false;

$this -> db_connections = array(0 => array(
        'host' => 'localhost',
        'user' => 'root',
        'password' => '',
        'dbname' => 'base'
    ));
?>