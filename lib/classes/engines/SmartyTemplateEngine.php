<?php

class SmartyTemplateEngine implements TemplateEngine{
	/**
	 * @var Smarty
	 */
	protected $_smarty;
	protected $_version='v2';
	protected $_params=array();
	
	public function __construct($params=array()){
		if(isset($params['version']))
			$this->_version=$params['version'];
		$this->_params=$params;
		$this->_get_engine();
	}
	
	public function __get($name){
		return $this->_smarty->{$name};
	}
	
	public function __call($name,$args){
		return call_user_func_array(array($this->_smarty, $name), $args);
	}
	
	public function assign($var,$value=''){
		return $this->_smarty->assign($var,$value);
	}
	
	public function fetch($template,$cache_hash=''){
		if(!pathinfo($template, PATHINFO_EXTENSION))
			$template.='.tpl';
		return $this->_smarty->fetch($template,$cache_hash);
	}
	
	public function set_template_dir($dir='')
	{
		switch($this->_version){
			case 'v2':
				$this->_smarty->template_dir=$dir;
			break;
			case 'v3':
				$this->_smarty->setTemplateDir($dir);
			break;
		}
	}

	/**
	 * @return array|string
     */
	public function get_template_dir()
	{
		switch($this->_version){
			case 'v2':
				return $this->_smarty->template_dir;
			break;
			case 'v3':
				$dirs=$this->_smarty->getTemplateDir();
				return $dirs[0];
			break;
            default:
                return '';
		}
	}

	/**
	 * @param $dir
     */
	public function set_compile_dir($dir)
	{
		switch($this->_version){
			case 'v2':
				$this->_smarty->compile_dir=$dir;
			break;
			case 'v3':
				$this->_smarty->setCompileDir($dir);
			break;
		}
	}

	/**
	 * @return string
     */
	public function get_compile_dir()
	{
		switch($this->_version){
			case 'v2':
				return $this->_smarty->compile_dir;
			break;
			case 'v3':
				return $this->_smarty->getCompileDir();
			break;
            default:
                return '';
		}
	}

	/**
	 * @param string $var
	 * @return array|mixed|null
     */
	public function get_template_var($var='')
	{
		switch($this->_version)
		{
			case 'v2':
				return $this->_smarty->get_template_vars($var);
			break;
			case 'v3':
                if($var)
				    return isset_or($this->_smarty->tpl_vars[$var]->value);
                else
                    return $this->_smarty->getTemplateVars();
			break;
            default:
                return null;
		}
	}

	/**
	 *
     */
	public function enable_cache(){
		switch($this->_version)
		{
			case 'v2':
				$this->_smarty->caching=2;
				$this->_smarty->cache_lifetime = 3600;
				$this->_smarty->compile_check = false;
			break;
			case 'v3':				
			break;
		}
	}
	
	public function disable_cache(){
		switch($this->_version)
		{
			case 'v2':
				$this->_smarty->caching=0;	
				$this->_smarty->compile_check = true;			
			break;
			case 'v3':				
			break;
		}
	}
	
	public function set_cache($enabled=true){
		if($enabled)
			$this->enable_cache();
		else 
			$this->disable_cache();		
	}
	
	public function clear_cache($cache_id){
		switch($this->_version)
		{
			case 'v2':
				$this->_smarty->clear_cache(null,$cache_id);					
			break;
			case 'v3':				
			break;
		}
	}

	/**
	 * @param $template
	 * @param string $cache_id
	 * @param null $compile_id
	 * @return bool|false|string
     */
	public function is_cached($template, $cache_id='', $compile_id=null){
		if(pathinfo($template, PATHINFO_EXTENSION)=='')
			$template.='.tpl';
		switch($this->_version)
		{
			case 'v2':
				$old=$this->_smarty->caching;
				$this->_smarty->caching = true;
				$is_cached= $this->_smarty->is_cached($template,$cache_id,$compile_id);
				$this->_smarty->caching = $old;
				return $is_cached;					
			break;
			case 'v3':				
				return $this->_smarty->isCached($template,$cache_id,$compile_id);
			break;
            default:
                return false;
		}
	}

	/**
	 * @param $template
	 * @param string $cache_hash
     */
	public function display($template, $cache_hash=''){
		if(!pathinfo($template, PATHINFO_EXTENSION))
			$template.='.tpl';
		$this->_smarty->display($template,$cache_hash);
	}

	/**
	 * @param $plugin
	 * @param $method
	 * @param $type
     */
	public function register_plugin($plugin, $method, $type){
		if($this->_version=='v2')
			$this->_smarty->{'register_'.$type}($plugin, $method);
		elseif($this->_version=='v3')
			$this->_smarty->registerPlugin($type, $plugin, $method);
	}

    /**
     *
     */
    protected function _get_engine(){
		if(!file_exists($this->_params['cache_dir'].'smarty_cache/'))
			mkdir($this->_params['cache_dir'].'smarty_cache/');
		switch($this->_version)
		{
			case 'v2':
				$this->_smarty = new Smarty;
				$this->_smarty->template_dir=$this->_params['template_dir'];
				$this->_smarty->compile_dir=$this->_params['cache_dir'];
				
				$this->_smarty->cache_dir=$this->_params['cache_dir'].'smarty_cache/';
				
				if(isset_or($this->_params['cache_enabled']))
				{
					$this->enable_cache();
				}
				if(isset_or($this->_params['debug']))
					$this->_smarty->error_reporting=E_ALL ^ E_NOTICE;			
				if(!isset_or($this->_params['trace']))
					$this->_smarty->load_filter('output', 'trimwhitespace');
			break;
			case 'v3':
				$this->_smarty= new Smarty();
				$this->_smarty->setTemplateDir($this->_params['template_dir']);
				$this->_smarty->setCompileDir($this->_params['cache_dir']);	
				$this->_smarty->allow_php_templates=true;
				$this->_smarty->auto_literal = false;
				$this->_smarty->error_unassigned = true;
				if(isset_or($this->_params['debug']))
				{
					$this->_smarty->debugging=false;
					$this->_smarty->compile_check = true;
					$this->_smarty->error_reporting=E_ALL & ~E_NOTICE;
				}
				else
				{
					$this->_smarty->debugging=false;
					$this->_smarty->compile_check = false;
					$this->_smarty->error_reporting=0;
				}
				if(!isset_or($this->_params['trace']))
					$this->_smarty->loadFilter('output', 'trimwhitespace');			
			break;		
		}
	}

	/**
	 * @param $template
	 * @return bool
	 */
	public function template_exists($template)
	{
		if(!pathinfo($template, PATHINFO_EXTENSION))
			$template.='.tpl';
		return file_exists($template);
	}
}