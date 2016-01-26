<?php
class PhpTemplate {
	/**
	 * @var string
	 */
	protected $_template='';
	/**
	 * @var PhpTemplateEngine
	 */
	protected $_engine='';
	
	public function __construct($template,&$engine){
		$this->_template=$template;
		$this->_engine=&$engine;
	}
	
	public function __get($name){
		return $this->_engine->{$name};
	}
	
	public function __call($name,$args){
		return call_user_func_array(array($this->_engine, $name), $args);
	}
	
	public function __toString()
	{
	    return $this->fetch();
	}
	
	public function fetch(){		
		extract($this->_engine->get_template_var());
	    ob_start();

	 	if(file_exists($this->_template))
	    	include $this->_template;
		else
			include $this->_engine->get_template_dir().$this->_template;		
	 
	    return ob_get_clean();
	}
}