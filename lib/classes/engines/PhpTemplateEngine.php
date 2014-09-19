<?php
class PhpTemplateEngine implements TemplateEngine{
	protected $_variables=array();
	protected $_params=array();
	
	public function __construct($params=array()){
		$this->_params=$params;
	}
	
	public function __get($name){
		if(isset($this->_variables[$name]))
			return $this->_variables[$name];
		else
			trigger_error('Variable '.$name.' is not defined in template!');
	}
	
	public function assign($var,$value=''){
		if(is_array($var))
			foreach($var as $name=>$val)
				$this->_assign($name, $val);
		else
			$this->_assign($var,$value);
	}
	
	protected function _assign($var,$value){
		$this->_variables[$var]=$value;
	}
	
	public function fetch($template_path,$cache_hash=''){
		$template=new PhpTemplate($template_path,$this);
		return $template->fetch();
	}
	
	public function clear_cache($cache_hash){
		return true;
	}
	
	public function disable_cache(){
		return true;
	}
	
	public function enable_cache(){
		return true;	
	}
	
	public function get_compile_dir(){
		return isset_or($this->_params['compile_dir']);	
	}
	
	public function get_template_dir(){
		return isset_or($this->_params['template_dir']);	
	}
	
	public function get_template_var($var=''){
		if($var)
			return $this->_variables[$var];
		return $this->_variables;
	}
	
	public function is_cached($template,$cache_hash=''){
		return false;	
	}
	
	public function set_cache($enabled=true){
		return true;	
	}
	
	public function set_compile_dir($dir){
		$this->_params['compile_dir']=$dir;
		return true;	
	}
	
	public function set_template_dir($dir=''){
		$this->_params['template_dir']=$dir;
		return true;
	}
	
	public function display($template,$cache_hash=''){
		$template=new PhpTemplate($template,$this);
		echo $template;
	}
}
?>