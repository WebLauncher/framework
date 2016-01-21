<?php
/**
 * Controller class for back-end
 */
/**
 * Controller Class for back-end usage
 * @ignore
 * @package WebLauncher\Objects
 */
class Page extends _Page
{
	/**
	 * @var \Base $model Model for the current page to use
	 */
	var $model=null;
    /**
     * @var string $page_title Title shown on page
     */
	var $page_title='';
    /**
     * @var array $page_buttons Buttons shown on page
     */
	var $page_buttons=array();
    /**
     * @var string $model_name Model name for the current page to use
     */
    var $model_name='';
	/**
	 * Model condition filtering the table
	 * @var string
	 */
	var $model_filter='';
    /**
     * @var bool $can_add Flag if add action is active
     */
    var $can_add = true;
    /**
     * @var bool $can_edit Flag if edit action is active
     */
    var $can_edit = true;
    /**
     * @var bool $can_delete Flag if delete action is active
     */
    var $can_delete = true;
    /**
     * @var bool $can_active Flag if active action is active
     */
    var $can_active = true;

	/**
	 * Set model for current cotroller to use
	 * @param Base $model
	 * @param string $model_name
	 */
	public function set_model($model,$model_name=''){
	    $this->model_name=$model_name;
		if(is_a($model, 'Base'))
			$this->model=$model;
		elseif(is_string($model))
			$this->model=&$this->models->{$model};
        if(!$this->model_name)
            $this->model_name=ucwords(str_replace('_', ' ', get_class($this->model))); 
	}
	
	function _on_load(){
		parent::_on_load();
		if(count($this->page_buttons))
			$this->assign('page_buttons',$this->page_buttons);
	}
	
	/**
	 * Get gridview table for model display
	 * @param int $data Load data or just header
	 * @return string
	 */
	public function get_model_table($data=0){
		if($this->model)
			return $this->model->get_admin_table('table_'.get_class($this).'_'.get_class($this->model), $data, $this->model_filter);
		return '';
	}
	
	public function assign($var,$value=''){
		switch($var){
			case 'page_title':
				$this->page_title=$value;
			break;
			default:
				parent::assign($var,$value);
		}
	}
	
	function action_update(){
		if($this->model)
			$this->get_model_table(true);
	}
	
	function index(){
		if($this->model)
			$this -> assign('table', $this -> get_model_table());
	}
	
	function action_add(){
		if($this->can_add && $this->model){
			$this->view='form';
			$this->assign('form',$this->model->get_admin_form('Add '.$this->model_name,'',$this->paths['current'],'save'));
		}
	}
	
	function action_edit($id){
		if($this->can_edit && $this->model){
			$this->view='form';
			$this->assign('form',$this->model->get_admin_form('Edit '.$this->model_name,'',$this->paths['current'],'save:'.$id,$id));
		}
	}

	/**
	 * @param $id
     */
	function action_delete($id){
        if($this->model && $this->can_delete){
            $this->model->delete($id);            
        }
        $this -> redirect($this -> paths['current']);
    }
    
    function action_active($id,$value){
        if($this->can_active && $this->model){
            $this->model->set_active($id,$value);
        }
        die(1);
    }
    
    function action_save($id=''){
        if($this->model){
            if(!$id)
                $id=$this->model->insert_from_admin_form();
            else
                $this->model->update_from_admin_form($id);
            $this -> system -> add_message("success", $this->model_name." saved!");
            
            if (isset($_REQUEST['return']) && $id != "" && $this->can_edit)
                $this -> redirect($this -> paths['current'] . "?a=edit:$id");    
        }
        $this -> redirect($this -> paths['current']);
    }
}
?>