<?php
/**
 * Models Manager
 */
/**
 * Models Manager Class
 * @package WebLauncher\Managers
 */
class ModelsManager
{
	/**
	 * @var DbManager Connection
	 */
	public $db;
	/**
	 * @var array Loaded Libraries
	 */
	public $models=array();

	/**
	 * Constructor
	 */
	function __construct()
	{
	}
	/**
	 * Get magic method
	 * @param string $name
	 * @return mixed
	 * @example $this->model Init model named model
	 */
	function __get($name)
	{
		if($this->import($name))
			return $this->$name;
		else
		{
			$trace = debug_backtrace();
	        System::triggerError(
	            'Undefined table for model in php.config.php file via __get(): ' . $name .
	            ' in ' . $trace[0]['file'] .
	            ' on line ' . $trace[0]['line'],
	            E_USER_NOTICE);
	        return null;
		}
	}

	/**
	 * Magic method call inits new model
	 * @param string $name
	 * @param array $arguments
	 * @return mixed|null
	 */
	function __call($name,$arguments){
		if($this->import($name)){
			return $this->$name;
		}
		else
		{
			$trace = debug_backtrace();
	        System::triggerError(
	            'Undefined table for model in php.config.php file via __call(): ' . $name .
	            ' in ' . $trace[0]['file'] .
	            ' on line ' . $trace[0]['line'],
	            E_USER_NOTICE);
	        return null;
		}
	}

	/**
	 * Import particular libraries from the lib folder
	 * @param mixed $model
	 * @return boolean
	 */
	function import($model)
	{
		
		if(!in_array($model,$this->models))
		{
			if($this->import_from_page($model))
				return true;
			if(isset($this->db->tables[$model]))
			{
				$this->$model=new Base();                
				if(is_a($this->$model,'_Base') && !$this->$model->table)
					$this->$model->table=$this->db->tables[strtolower($model)];                
				$this->models[]=$model;
                $this->{$model}->models=&$this;
				$this->{$model}->system=System::getInstance();
				return true;
			}
			return false;
		}
		else
		{
			return true;
		}
	}

	/**
	 * Import model from file
	 * @param string $model
	 * @param string $file
	 * @return bool
	 */
	function import_from_file($model,$file)
	{
		if(!class_exists($model) && is_file($file))
		{
			require_once $file;
			$model_name=strtolower($model);
			$this->$model_name=new $model();
			if(is_a($this->$model_name,'_Base') && !$this->$model_name->table)
				$this->$model_name->table=$this->db->tables[strtolower($model)];
			$this->models[]=strtolower($model);
            $this->{$model_name}->models=&$this;
            
            $this->{$model_name}->system=System::getInstance();
			return true;
		}
		return false;
	}
	
	/**
	 * Import from component
	 * @param string $model
	 * @return bool
	 */
	function import_from_page($model)
	{
		

		// page subpaths
		$paths=array();
		$spath=System::getInstance()->paths['root_dir'].System::getInstance()->modules_folder.DS;		
		foreach(System::getInstance()->subquery as $k=>$v)
		{
			if($v)
			{
				if($k>0)
				$spath.='components'.DS.$v;
				else $spath.=$v;

				if($spath[strlen($spath)-1]!=DS)
					$spath.=DS;

				$paths[]=$spath;
			}
		}
		foreach(array_reverse($paths) as $v)
			if($this->import_from_file($model,$v.'models'.DS.$model.'.php') || $this->import_from_file($model,$v.'models'.DS.ucfirst($model).'.php'))
				return true;
		return false;
	}
}