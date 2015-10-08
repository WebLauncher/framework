<?php
/**
 * Code generation manager 
 */
 
/**
 * Code generation manager 
 * @package WebLauncher\Managers
 */
class BuildManager
{
	/**
	 * @var \FilesManager $files Files manager object
	 */
	var $files='';
	/**
	 * @var array $errors Errors generated while building is done
	 */
	var $errors=array();
	
	/**
	 * Constructor
	 * @param \FilesManager $files_manager 
	 */
	function __construct(&$files_manager)
	{
		$this->files=&$files_manager;
	}
	
	/**
	 * Add component to site
	 * @param string $path
	 * @param string $component
	 * @param string $skin 
	 */
	function add($path,$component,$skin='default')
	{
		if(!$this->files->add_dir($path))
		{
			$this->errors[]='Could not add dir:"'.$path.'"!';
		}
		if(!$this->files->add_dir($path.'components/'))
		{
			$this->errors[]=('Could not add dir:"'.$path.'components/"!');
		}
		if(!$this->files->add_dir($path.'views/'.$skin.'/'))
		{
			$this->errors[]=('Could not add dir:"'.$path.'views/'.$skin.'/"!');
		}
		if(!$this->files->save_file($path.'views/'.$skin.'/'.$component.'.tpl',$this->get_component_view($component)))
		{
			$this->errors[]=('Could not write file:"'.$path.'views/'.$skin.'/'.$component.'.tpl"!');
		}
		if(!$this->files->save_file($path.$component.'.php',$this->get_component_class($component)))
		{
			$this->errors[]=('Could not write file:"'.$path.$component.'.php"!');
		}
		return count($this->errors)?false:true;
	}
    
    /**
     * Add model to site
     * @param string $path
     * @param string $component
     */
    function add_model($path,$name)
    {
        if(!$this->files->add_dir($path.'models/'))
        {
            $this->errors[]='Could not add dir:"'.$path.'"!';
        }
        if(!$this->files->save_file($path.'models/'.$name.'.php',$this->get_model_class($name)))
        {
            $this->errors[]=('Could not write file:"'.$path.'models/'.$name.'.php"!');
        }
        return count($this->errors)?false:true;
    }
	
	/**
	 * Add component to site
	 * @param string $path
	 * @param string $component
	 * @param string $skin 
	 */
	function add_module($path,$skin='default')
	{
		$module=basename($path);
		if(!$this->files->add_dir($path))
		{
			$this->errors[]='Could not add dir:"'.$path.'"!';
		}
		if(!$this->files->add_dir($path.'components/'))
		{
			$this->errors[]=('Could not add dir:"'.$path.'components/"!');
		}
		if(!$this->files->add_dir($path.'views/'.$skin.'/'))
		{
			$this->errors[]=('Could not add dir:"'.$path.'views/'.$skin.'/"!');
		}
		if(!$this->files->save_file($path.'views/'.$skin.'/index.tpl',$this->get_component_view($module)))
		{
			$this->errors[]=('Could not write file:"'.$path.'views/'.$skin.'/'.$component.'.tpl"!');
		}
		if(!$this->files->save_file($path.'index.php',$this->get_module_class($module)))
		{
			$this->errors[]=('Could not write file:"'.$path.'index.php"!');
		}
		if(!$this->files->save_file($path.'config.php',$this->get_module_config($module)))
		{
			$this->errors[]=('Could not write file:"'.$path.'config.php"!');
		}
		$this->add($path.'components/home/','home',$skin);
		return count($this->errors)?false:true;
	}

	/**
	 * Get generated code for component class
	 * @param string $component
	 */
	function get_component_class($component)
	{
		$class="<?php\n";
		$class.="/**\n";
 		$class.="* Class ".$component."_page\n";
 		$class.="* @author BuildManager\n";
 		$class.="*\n";
 		$class.="*/\n";
		$class.="class ".$component."_page extends Page\n";
		$class.="{\n";
		$class.="	function index()\n";
		$class.="	{\n";
		$class.="	}\n";
		$class.="}\n";
		$class.="?>";
		return $class;
	}
    
    /**
     * Get generated code for model class
     * @param string $name
     */
    function get_model_class($name)
    {
        $class="<?php\n";
        $class.="/**\n";
        $class.="* Class ".$name."\n";
        $class.="* @author BuildManager\n";
        $class.="*\n";
        $class.="*/\n";
        $class.="class ".$name." extends Base\n";
        $class.="{\n";
        $class.="}\n";
        $class.="?>";
        return $class;
    }
	
	/**
	 * Get generated code for module class
	 * @param string $module
	 */
	function get_module_class($module)
	{
		$class="<?php\n";
		$class.="/**\n";
 		$class.="* Class PageIndex for module '$module'\n";
 		$class.="* @author BuildManager\n";
 		$class.="*\n";
 		$class.="*/\n";
		$class.="class PageIndex extends Page{\n";
		$class.="	function index()\n";
		$class.="	{\n";
		$class.="	}\n";
		$class.="}\n";
		$class.="?>";
		return $class;
	}
	
	/**
	 * Get generated code for module config file
	 * @param string $component
	 */
	function get_module_config($module)
	{
		$class="<?php\n";
		$class.="/**\n";
 		$class.="* global page access \n";
 		$class.="*\n";
 		$class.="*/\n";
		$class.='global $page;'."\n";
		$class.='$page->title="page title for module '.$module.'";'."\n";
		$class.="?>";
		return $class;
	}
	
	/**
	 * Get generated component view
	 * @param string $component 
	 */
	function get_component_view($component)
	{
		$view="\n";
		$view.="{if isset_or(\$subpage)}\n";
		$view.="{\$subpage}\n";
		$view.="{else}\n";
		$view.="- to do '".$component."' page -\n";
		$view.="{/if}\n";
		return $view;
	}
}

?>