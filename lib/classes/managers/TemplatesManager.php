<?php
class TemplatesManager
{
	protected static $engine=null;
	protected static $ver='v2';
	
	public static function get_engine_object($type='php',$params=array()){
		$class=ucfirst($type).'TemplateEngine';
		return new $class($params);
	}
	
	public static function get_engine($template_engine,$ver='v2',$template_dir='',$cache_dir='',$trace=false,$debug=false,$cache_enabled=false)
	{
		$params=array(
			'version'=>$ver,
			'template_dir'=>$template_dir,
			'cache_dir'=>$cache_dir,
			'trace'=>$trace,
			'debug'=>$debug,
			'cache_enabled'=>$cache_enabled
		);
		self::$engine=self::get_engine_object($template_engine,$params);
		return self::$engine;		
	}
	
	public static function set_template_dir($dir='')
	{
		return self::$engine->set_template_dir($dir);
	}

	public static function get_template_dir()
	{
		return self::$engine->get_template_dir();
	}
	
	public static function set_compile_dir($dir)
	{
		return self::$engine->set_compile_dir($dir);
	}
	
	public static function get_compile_dir()
	{
		return self::$engine->get_compile_dir();
	}
	
	public static function get_template_var($var)
	{
		return self::$engine->get_template_var($var);
	}
	
	public static function enable_cache(){
		return self::$engine->enable_cache();
	}
	
	public static function disable_cache(){
		return self::$engine->disable_cache();
	}
	
	public static function set_cache($enabled=true){
		return self::$engine->set_cache($enabled);
	}
	
	public static function clear_cache($cache_id){
		if(self::$engine)
			return self::$engine->clear_cache($cache_id);
	}

	public static function template_exists($template){
		return self::$engine->template_exists($template);
	}
	
	public static function is_cached($template,$cache_id=''){
		return self::$engine->is_cached($template,$cache_id='');
	}
}