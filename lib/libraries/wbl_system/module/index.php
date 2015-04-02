<?php
class PageIndex extends Page
{
    function index() {
        
    }
    
    function action___sys_trace(){
        $trace_files=array_reverse(TraceManager::get_trace_files());
        $this->assign('files',$trace_files);
        $this->assign('page',isset_or($_REQUEST['page'],array_pop($trace_files)));
        $this->assign('can_build',$this->system->build_enabled);
        $this->assign('server',TraceManager::get_debug($_SERVER));
        if(file_exists($this->paths['main_root_dir'].'errs.log.json'))
        {
            $errors=file_get_contents($this->paths['main_root_dir'].'errs.log.json');            
            $errors=json_decode('['.rtrim(trim($errors),",").']');
            $errors=array_reverse($errors);
            $this->assign('errors',$errors);
        }
    }
    
    function action___sys_trace_build(){
        $this->view='build';
        $components=array('component'=>$this->system->main_module,'path'=>$this->paths['root'].$this->system->main_module);
        $components['kids']=$this->components($this->paths['main_root_code'].$this->system->main_module.'components/');
        $this->assign('components',$components);
    }
    
    function components($path){
        $result=array();
        $directories=$this->system->files_manager->dir_array($path);
        foreach($directories as $dir){
            $http_path=str_replace($this->paths['main_root_code'],$this->paths['root'],str_replace('components/','',$path.$dir));
            
            $arr=array('component'=>$dir,'path'=>$http_path);
            if(is_dir($path.$dir.'/components/')){
                $kids=array();
                $kids=$this->components($path.$dir.'/components/');
                if(count($kids))
                    $arr['kids']=$kids;
            }
            $result[]=$arr;
        }
        return $result;
    }
}
?>