<?php
class PageIndex extends Page
{
    function on_init(){
    }

    function index() {
        $trace_files=array_reverse(TraceManager::get_trace_files());
        $this->assign('files',$trace_files);
        $this->assign('page',isset_or($_REQUEST['page'],array_pop($trace_files)));
        $this->assign('can_build',$this->system->build_enabled);
        $this->assign('server',TraceManager::get_debug($_SERVER));
        if(file_exists($this->paths['main_root_dir'].'errs.log.json'))
        {
            $errors=file_get_contents($this->paths['main_root_dir'].'errs.log.json');
            $errors=json_decode('['.rtrim(trim($errors),",").']');
            if(is_array($errors))
                $errors=array_reverse($errors);
            $this->assign('errors',$errors);
        }
    }

    function action__system(){
        $this->index();
    }

    function action___sys_trace(){
        $this->index();
    }

    function action___sys_trace_build(){
        $this->view='build';
        $components=array('component'=>$this->system->main_module,'path'=>$this->paths['root'].$this->system->main_module);
        $components['kids']=$this->components($this->paths['main_root_code'].$this->system->main_module.'components/');
        $this->assign('components',$components);
        $this->assign('models',$this->get_models());
        $this->assign('migrations',$this->get_migrations());
    }

    function components($path){
        $result=array();
        $directories=$this->system->files_manager->dir_array($path);
        foreach($directories as $dir){
            $http_path=str_replace($this->paths['main_root_code'],$this->paths['root'],str_replace('components/','',$path.$dir));

            $arr=array('component'=>$dir,'path'=>$http_path);
            if(file_exists($path.$dir.'/components/')){
                $kids=$this->components($path.$dir.'/components/');
                if(count($kids))
                    $arr['kids']=$kids;
            }
            $result[]=$arr;
        }
        return $result;
    }

    function get_migrations(){
        return require_once $this->paths['main_root_dir'].'db/migrations.php';
    }

    function get_models(){
        $tables=array();
        if($this->system->db_conn)
            $tables=$this->system->db_conn->get_tables();
        $files=$this->system->uploads->file_array($this->paths['main_root_code'].$this->system->main_module.'models'.DS);
        $models=array();
        foreach($tables as $v){
            $model=array('name'=>array_values($v)[0]);
            $model['db']=true;
            $model['file']=in_array($model['name'].'.php',$files);
            $model['path']=$this->paths['main_root_code'].$this->system->main_module.'models'.DS.$model['name'].'.php';
            $models[$model['name']]=$model;
        }
        foreach($files as $f){
            if($f!='empty' && !isset($models[basename($f,'.php')]))
            {
                $model=array('name'=>basename($f,'.php'));
                $model['db']=false;
                $model['file']=true;
                $models[$model['name']]=$model;
            }
        }
        return $models;
    }
}