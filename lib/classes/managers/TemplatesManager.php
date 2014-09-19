<?php
class TemplatesManager
{
	protected static $engine=null;
	protected static $ver='v2';
	
	public static function get_engine_new($type='php',$params=array()){
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
		self::$engine=self::get_engine_new($template_engine,$params);
		return self::$engine;
		
		self::$ver=$ver;
		switch($ver)
		{
			case 'v2':
				require_once dirname(__FILE__).'/v2/libs/Smarty.class.php';
				self::$smarty = new Smarty;
				self::$smarty->template_dir=$template_dir;
				self::$smarty->compile_dir=$cache_dir;
				
				self::$smarty->cache_dir=$cache_dir.'smarty_cache/';
				if(!is_dir($cache_dir.'smarty_cache/'))
					mkdir($cache_dir.'smarty_cache/');
				if($cache_enabled)
				{
					self::enable_cache();
				}
				if($debug)
					self::$smarty->error_reporting=E_ALL ^ E_NOTICE;			
				if(!$trace)
					self::$smarty->load_filter('output', 'trimwhitespace');
			break;
			case 'v3':
				require_once dirname(__FILE__).'/v3/libs/Smarty.class.php';
				self::$smarty= new Smarty();
				self::$smarty->setTemplateDir($template_dir);
				self::$smarty->setCompileDir($cache_dir);	
				self::$smarty->allow_php_templates=true;
				self::$smarty->auto_literal = false;
				self::$smarty->error_unassigned = true;
				if($debug)
				{
					self::$smarty->debugging=false;
					self::$smarty->compile_check = true;
					self::$smarty->error_reporting=E_ALL & ~E_NOTICE;
				}
				else
				{
					self::$smarty->debugging=false;
					self::$smarty->compile_check = false;
					self::$smarty->error_reporting=0;
				}
				if(!$trace)
					self::$smarty->loadFilter('output', 'trimwhitespace');			
			break;		
		}
		return self::$smarty;
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
	
	public static function is_cached($template,$cache_id=''){
		return self::$engine->clear_cache($template,$cache_id='');
	}
}
?>