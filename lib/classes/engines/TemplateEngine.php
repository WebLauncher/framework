<?php
interface TemplateEngine {
	public function __construct($params=array());
	public function assign($var,$value='');	
	public function fetch($template_path,$cache_hash='');
	public function clear_cache($cache_hash);
	public function disable_cache();
	public function enable_cache();
	public function get_compile_dir();
	public function get_template_dir();
	public function get_template_var($var='');
	public function is_cached($template,$cache_hash='');
	public function set_cache($enabled=true);
	public function set_compile_dir($dir);
	public function set_template_dir($dir='');
	public function display($template,$cache_hash='');
} 
?>