<?php
class SmartyExtensions {
	public $system = null;
	protected $version = 'v2';
	protected $plugins =array(
		'block'=>array(
			'bind',
			'image',
			'messages',
			'tr'
		),
		'function'=>array(
			'captcha',
			'element',
			'filter',
			'validator',
			'count',
			'css',
			'js'
		),
		'modifier'=>array(
			'add_param',
			'http',
			'https',
			'file_size'
		)
	);

	function __construct($version) {
		$this -> version = $version;
	}

	function register() {
		foreach($this->plugins as $type=>$plugins)
			foreach($plugins as $plugin)
				$this->register_plugin($type,$plugin);
	}
	
	function register_plugin($type,$plugin){
		$method=$this->get_plugin_method($plugin);
		if($this->version=='v2')
			$this->system->template->{'register_'.$type}($plugin, $method);
		elseif($this->version=='v3')
			$this->system->template->registerPlugin($type, $plugin, $method);
	}
	
	function get_plugin_method($plugin){
		$method=$plugin;
		if($this->version=='v2' && method_exists($this, $plugin.'_v2'))
			$method=$plugin.'_v2';
		elseif($this->version=='v3' && method_exists($this, $plugin.'_v3'))
			$method=$plugin.'_v3';
		return array(&$this,$method);
	}

	/**
	 * Smarty {tr}{/tr} block plugin
	 *
	 * Type:     block function<br>
	 * Name:     bind<br>
	 * Purpose:  displays the bindind value requested
	 * @author Mihai Varga
	 * @param string contents of the block
	 * @param Smarty clever simulation of a method
	 * @return string string $content translated
	 */
	function bind_v2($params, $content, &$smarty) {
		$return="";
		$assign=isset_or($params['assign']);
		if($content!=null)
		{
			$content=trim($content);
	
			global $page;
			if($page->db_conn)
			{
				$table=isset_or($params['table']);
				$get_field=isset_or($params['get_field']);
				$field=(isset_or($params['field'])?$params['field']:"id");
				$value=$content;
				if($table && $get_field && $field && $value)
				{
					$query="select `$get_field` from `$table` where `$field`='$value'";
					$row=$page->db_conn->getRow($query);
	
					if(isset($row[$get_field])) $return=$row[$get_field];
					else $return=isset_or($params['default']);	
				}
			}
		}
	
		return $assign ? $smarty->assign($assign, $return) : $return;
	}

	/**
	 * Smarty {image original width height class alt}{/image} block plugin
	 *
	 * Type:     block function<br>
	 * Name:     image<br>
	 * Purpose:  displays the image from the db table images at the given id
	 * @author Mihai Varga
	 * @param string contents of the block
	 * @param Smarty clever simulation of a method
	 * @return string string $content translated
	 */
	function image_v2($params, $content, &$smarty) {
		$assign = isset_or($params['assign']);
		$alt = isset_or($params['alt']) ? $params['alt'] : $this->system -> title;
		$default = isset_or($params['default'], 'no default');
		$width = isset_or($params['width']);
		$height = isset_or($params['height']);
		$fit = isset_or($params['fit']);
		$resize = isset($params['resize']) ? $params['resize'] == "true" : false;
		$class = isset($params['class']) ? "class='" . $params['class'] . "'" : "";
		$title = isset($params['title']) ? "title='" . $params['title'] . "'" : "";
		$align = isset($params['align']) ? "align='" . $params['align'] . "'" : "";
		$watermark = isset_or($params['watermark']);
		$watermark_left = isset_or($params['watermark_left'], 'left');
		$watermark_top = isset_or($params['watermark_top'], 'top');

		if (!$this->system -> models) {
			if ($this->system -> trace)
				return 'Init DAL';
			else
				$content = '';
		}
		if (!$content && isset_or($default))
			$content = $default;

		$content = trim($content);
		if (is_numeric($content)) {
			$obj = $this->system -> models -> images -> get($content);
			$image_path = $this->system->paths['root'].$obj['path'];
		} else
			$image_path = $content;

		if ($resize) {
			// get cache path
			$path = str_replace($this->system -> paths['root'], $this->system -> paths['dir'], $image_path);
			$img_cache = $this->system -> paths['root_cache'] . 'img_mod/';
			$cache_filename = generate_seo_link($alt) . '_' . sha1($path . $width . $height . $fit . $watermark . $watermark_left . $watermark_top);
			$cache_path = $img_cache . $cache_filename . '.png';
			if (is_file($cache_path))
				$image_path = $this->system -> paths['root'] . $this->system -> cache_folder . '/img_mod/' . $cache_filename . '.png';
			else {
				$image_path = $this->system -> paths['root'] . "img_mod/?_file=" . urlencode($image_path) . "&_width=" . $width . "&_height=" . $height . '&_fit=' . $fit;
				if ($watermark)
					$image_path .= ('&_w=' . urlencode($watermark) . '&_w_left=' . $watermark_left . '&_w_top=' . $watermark_top);
				$image_path .= ('&name=' . $cache_filename . '.png');
			}
		} else {
			$style = "";
			if ($width)
				$style .= "width:" . $width . "px;";
			if ($height)
				$style .= "height:" . $height . "px";
			if ($style)
				$style = 'style="' . $style . '"';
		}
		$return='';
		if (isset_or($params['get_path']))
			$return=$image_path;
		else
			$return="<img src='" . $image_path . "' $align $title alt='" . $alt . "' border='0' $style $class/>";
		return $assign ? $smarty->assign($assign, $return) : $return;		
	}

	/**
	 * Smarty {messages}{/messages} block plugin
	 *
	 * Type:     block function<br>
	 * Name:     display messages<br>
	 * Purpose:  display system messages
	 * @author Mihai Varga
	 * @param string contents of the block
	 * @param Smarty clever simulation of a method
	 * @return string string $content translated
	 */
	function messages_v2($params, $content, &$smarty)
	{
		
		$assign=isset_or($params['assign']);
		$class=isset_or($params['class'],'');
		if($class)$class=' class="'.$class.'"';
		$success=isset_or($params['class_success'],'message-success');
		$error=isset_or($params['class_error'],'message-error');
		$other=isset_or($params['class_other'],'message-other');
		$tag=isset_or($params['tag'],'div');
		
		$template=$content;
		$content='';
		$messages=isset_or($this->system->messages);
		if(count($messages) && is_array($messages))
		{
			$content='<'.$tag.$class.'>';
			foreach($messages as $v)
			{
				$message=$template;
				$message=str_replace('**message**',tr($v['text']),$message);
				switch($v['type'])
				{
					case 'success':
						$message=str_replace('**class_type**',$success,$message);
					break;
					case 'error':
						$message=str_replace('**class_type**',$error,$message);
					break;
					default:
						$message=str_replace('**class_type**',$other,$message);
				}
				$content.=$message;
			}
			$content.='</'.$tag.'>';
			$this->system->clear_messages();
		}
			
		return $assign ? $smarty->assign($assign, $content) : $content;;
	}
	
	/**
	 * Smarty {tr}{/tr} block plugin
	 *
	 * Type:     block function<br>
	 * Name:     translation<br>
	 * Purpose:  translates the content if translation foun in db or inserts the text
	 * as default in database
	 * @author Mihai Varga
	 * @param string contents of the block
	 * @param Smarty clever simulation of a method
	 * @return string string $content translated
	 */
	function tr_v2($params, $content, &$smarty)
	{
		$assign = isset_or($params['assign']);
		if($content != "")
		{
			$language = isset($params['language']) ? $params['language'] : isset($this->system -> session['language_id'])?$this->system -> session['language_id']:0;
			$quer = $content;
			$tags = isset($params['tags']) ? $params['tags'] : "site";

			$content=tr($content,$language,$tags);
		}
		return $assign ? $smarty -> assign($assign, $content) : $content;
	}

	/**
	 * Smarty {captcha} function plugin
	 *
	 * Type:     function<br>
	 * Name:     captcha<br>
	 * Purpose:  dsplays captcha
	 *
	 * @author   Mihai Varga
	 * @param array
	 * @param Smarty
	 * @return string
	 */
	function captcha($params, &$smarty)
	{
		unset($this->system->session['signature']);
		$result='<img src="'.$this->system->paths['current'].'?a=signature&rand='.base64_encode(microtime()).'"/>';
	
	    if (empty($params['assign']))
	    {
	    	echo $result;
	    } else {
	        $smarty->assign($params['assign'],$result);
	    }
	}
	
	/**
	 * Smarty {element} function plugin
	 *
	 * Type:     function<br>
	 * Name:     element<br>
	 * Purpose:  loading elements and views from components<br>
	 *
	 * @author   Mihai Varga
	 * @param array
	 * @param Smarty
	 * @return string
	 */
	function element_v2($params, &$smarty)
	{
	    if (empty($params['path'])) {
	        $smarty->trigger_error("element: missing 'path' parameter");
	        return;
	    }
		
		// process path and check if it is ok
		$path=pathinfo($params['path']);
		$dirname=str_replace('/', DS.'components'.DS, $path['dirname']);
		$template_path=$this->system->paths['root_code'].$dirname.DS.'views'.DS.$this->system->skin.DS.$path['filename'].'.tpl';
		if(!file_exists($template_path))
			$template_path=$this->system->paths['root_code'].$dirname.DS.'views'.DS.$this->system->default_skin.DS.$path['filename'].'.tpl';
		if(file_exists($template_path))
		{
			
			$s_t_dir=$this->system->template->template_dir;
			$s_c_dir=$this->system->template->compile_dir;
			
		    $params['file']=$template_path;
			$this->system->change_template_dir($this->system->paths['root_code'].$dirname.DS.'views'.DS.$this->system->skin.DS);
			$cache_path=$this->system->paths['root_cache'].$dirname.DS.'views'.DS.$this->system->skin.DS;
			$this->system->change_cache_dir($cache_path);
			
			unset($params['path']);
			$old_vars=array_intersect_key($smarty->get_template_vars(),$params);
			$smarty->assign($params);
			$template=$this->system->fetch_template($path['filename'], $template_path, $cache_path,true);
			$smarty->assign($old_vars);
			$this->system->change_template_dir($s_t_dir);
			$this->system->change_cache_dir($s_c_dir);
			if (empty($params['assign']))
		    {
		    	echo $template;
		    } else {
		        $smarty->assign($params['assign'],$template);
		    }
	    }	
		else{
			$smarty->trigger_error("element: template file not found at: ".$template_path);
	        return;	
		}
	}

	function element_v3($params, $template)
	{
		$smarty=&$template->smarty;
	    if (empty($params['path'])) {
	        trigger_error("{element}: missing 'path' parameter");
	        return;
	    }
		
		// process path and check if it is ok
		$path=pathinfo($params['path']);
		$dirname=str_replace('/', DS.'components'.DS, $path['dirname']);
		$template_path=$this->system->paths['root_code'].$dirname.DS.'views'.DS.$this->system->skin.DS.$path['filename'].'.tpl';
		if(!file_exists($template_path))
			$template_path=$this->system->paths['root_code'].$dirname.DS.'views'.DS.$this->system->default_skin.DS.$path['filename'].'.tpl';
		if(file_exists($template_path))
		{
			
			$s_t_dir=$this->system->template->template_dir;
			$s_c_dir=$this->system->template->compile_dir;
			
		    $params['file']=$template_path;
			$this->system->change_template_dir($this->system->paths['root_code'].$dirname.DS.'views'.DS.$this->system->skin.DS);
			$cache_path=$this->system->paths['root_cache'].$dirname.DS.'views'.DS.$this->system->skin.DS;
			$this->system->change_cache_dir($cache_path);
			
			unset($params['path']);
			$old_vars=array_intersect_key($smarty->getTemplateVars(),$params);
			$smarty->assign($params);
			$template=$this->system->fetch_template($path['filename'], $template_path, $cache_path,true);
			$smarty->assign($old_vars);
			$this->system->change_template_dir($s_t_dir);
			$this->system->change_cache_dir($s_c_dir);
			if (empty($params['assign']))
		    {
		    	echo $template;
		    } else {
		        $smarty->assign($params['assign'],$template);
		    }
	    }	
		else{
			trigger_error("{element}: template file not found at: ".$template_path);
	        return;	
		}
	}

	/**
	 * Smarty {filter} function plugin
	 *
	 * Type:     function<br>
	 * Name:     filter<br>
	 * Purpose:  handle validations in template<br>
	 *
	 * @author   Mihai Varga
	 * @param array
	 * @param Smarty
	 * @return string
	 */
	function filter($params, &$smarty)
	{		    
	    if (empty($params['form'])) {
	        $smarty->trigger_error("filter: missing 'form' parameter");
	        return;
	    }
		
		if (empty($params['type'])) {
	        $smarty->trigger_error("filter: missing 'type' parameter");
	        return;
	    }
	
	    $form_id = isset_or($params['form']);
		$field= isset_or($params['field']);
		$filter= isset_or($params['type']);
		$pars=isset_or($params['params']);
		$client=empty($params['client'])||strtolower($params['client'])=="yes";
		$server=empty($params['server'])||strtolower($params['server'])=="yes";
		
		$result='';
		if(!isset($this->system->validate[$form_id]))
		{
			$hash=$this->system->validate->get_form_hash($form_id);
			$result.='<input type="hidden" name="__hash" value="'.$hash.'"/>';
		}
		$this->system->add_filter($form_id,$field,$filter,$pars,$client,$server);
		$smarty->assign('p',$this->system->get_page());
		if($this->system->ajax)
			$smarty->assign('bottom_script','<script type="text/javascript">'.$this->system->session['script'].'</script>');
		
		if (empty($params['assign']))
	    {
	    	echo $result;
	    } else {
	        $smarty->assign($params['assign'],$result);
	    }
	}
	
	/**
	 * Smarty {validator} function plugin
	 *
	 * Type:     function<br>
	 * Name:     validator<br>
	 * Purpose:  handle validations in template<br>
	 *
	 * @author   Mihai Varga
	 * @param array
	 * @param Smarty
	 * @return string
	 */
	function validator($params, &$smarty)
	{
	    if (empty($params['form'])) {
	        $smarty->trigger_error("validator: missing 'form' parameter");
	        return;
	    }
		
		if (empty($params['field'])) {
	        $smarty->trigger_error("validator: missing 'field' parameter");
	        return;
	    }
		
		if (empty($params['rule'])) {
	        $smarty->trigger_error("validator: missing 'rule' parameter");
	        return;
	    }
		
		if (empty($params['message'])) {
	        $smarty->trigger_error("validator: missing 'message' parameter");
	        return;
	    }
	
	    $form_id = $params['form'];
		$field=$params['field'];
		$rule=$params['rule'];
		$location=isset_or($params['location']);
		$translate=empty($params['translate'])||strtolower($params['translate'])=="yes";
		$message=$translate?tr(trim($params['message'])):trim($params['message']);
		$client=empty($params['client'])||strtolower($params['client'])=="yes";
		$server=empty($params['server'])||strtolower($params['server'])=="yes";
		
		$found_error=isset($this->system->errors[$field])?"":" style='display:none' ";
		if(isset($this->system->errors[$field]))
		{
			$message=$this->system->errors[$field];
		}
		if(!isset($this->system->errors['_smarty_showed']))$this->system->errors['_smarty_showed']=array();
		$show_error=($found_error==""||(!empty($params['show']) && $params['show']=='yes'))&&(!in_array($field,$this->system->errors['_smarty_showed']));
		$result='';
		if($show_error)
		{
			$result="<label class='error' for='$field' $found_error>".$message."</label>";
			$this->system->errors['_smarty_showed'][]=$field;
		}
		else
		{
			if(!isset($this->system->temp))$this->system->temp=array();
			if(!isset($this->system->temp['_smarty_location_fixed'][$form_id][$field]) && $location){
				$result='<label class="error" for="'.$field.'" style="display:none" generated="true">'.$message.'</label>';
				$this->system->temp['_smarty_location_fixed'][$form_id][$field]=1;
			}
		}
		if(!isset($this->system->validate[$form_id]))
		{
			$hash=$this->system->validate->get_form_hash($form_id);
			$result.='<input type="hidden" name="__hash" value="'.$hash.'"/>';
		}
		$this->system->add_validator($form_id,$field,$rule,$message,$client,$server);
		$smarty->assign('p',$this->system->get_page());
		if($this->system->ajax)
			$smarty->assign('bottom_script','<script type="text/javascript">'.$this->system->session['script'].'</script>');
		
	    if (empty($params['assign']))
	    {
	    	echo $result;
	    } else {
	        $smarty->assign($params['assign'],$result);
	    }
	}

	/**
	 * Smarty edit/add parameter to url
	 *
	 * Type:     modifier<br>
	 * Name:     add_param<br>
	 * Purpose:  simple search/replace 
	 * @author   Mihai Varga
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	function add_param($string, $param, $value)
	{
	    $url_data = parse_url($string);
	     if(!isset($url_data["query"]))
	         $url_data["query"]="";
	
	     $params = array();
	     parse_str($url_data['query'], $params);
	     $params[$param] = $value;   
	     $url_data['query'] = http_build_query($params);
	
		 $url="";
	     if(isset($url_data['host']))
	     {
	         $url .= $url_data['scheme'] . '://';
	         if (isset($url_data['user'])) {
	             $url .= $url_data['user'];
	                 if (isset($url_data['pass'])) {
	                     $url .= ':' . $url_data['pass'];
	                 }
	             $url .= '@';
	         }
	         $url .= $url_data['host'];
	         if (isset($url_data['port'])) {
	             $url .= ':' . $url_data['port'];
	         }
	     }
	     $url .= $url_data['path'];
	     if (isset($url_data['query'])) {
	         $url .= '?' . $url_data['query'];
	     }
	     if (isset($url_data['fragment'])) {
	         $url .= '#' . $url_data['fragment'];
	     }
	     return $url;	
	}

	/**
	 * Smarty change https: in http:
	 *
	 * Type:     modifier<br>
	 * Name:     http<br>
	 * Purpose:  simple search/replace 
	 * @author   Mihai Varga
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	function http($string)
	{
		$url=str_replace('https:', 'http:', $string);
	   	return $url;	
	}
	
	/**
	 * Smarty change http: in https:
	 *
	 * Type:     modifier<br>
	 * Name:     https<br>
	 * Purpose:  simple search/replace 
	 * @author   Mihai Varga
	 * @param string
	 * @param string
	 * @param string
	 * @return string
	 */
	function https($string)
	{
		$url=str_replace('http:', 'https:', $string);
	   	return $url;	
	}
	
	/** 
	 * Smarty {math} function plugin
	 *
	 * Type:     function<br>
	 * Name:     math<br>
	 * Purpose:  handle math computations in template<br>
	 * @link http://smarty.php.net/manual/en/language.function.math.php {math}
	 *          (Smarty online manual)
	 * @author   Monte Ohrt <monte at ohrt dot com>
	 * @param array
	 * @param Smarty
	 * @return string
	 */
	function count($params, &$smarty)
	{
	    // be sure equation parameter is present
	    if (empty($params['array'])) {
	        $smarty->trigger_error("count: missing array parameter");
	        return;
	    }   
	
		$smarty_result=count($params['array']);
		
	    if (empty($params['assign'])) {
	        return $smarty_result;
	    } else {
	        $smarty->assign($params['assign'],$smarty_result);
	    }    
	}
	
	/**
	 * Smarty file_size modifier plugin
	 *
	 * Type: modifier<br>
	 * Name: file_size<br>
	 * Purpose: format file size represented in bytes into a human readable string<br>
	 * Input:<br>
	 * - bytes: input bytes integer
	 * @author Rob Ruchte <rob at thirdpartylabs dot com>
	 * @param integer
	 * @return string
	 */
	function file_size($bytes = 0) {
		$output = 0;
		if(is_numeric($bytes))
		{
			$mb = 1024 * 1024;
			$gb = $mb * 1024;
			if ($bytes > $gb) {
				$output = sprintf("%01.2f", $bytes / $gb) . " GB";
			} elseif ($bytes > $mb) {
				$output = sprintf("%01.2f", $bytes / $mb) . " MB";
			} elseif ($bytes >= 1024) {
				$output = sprintf("%01.0f", $bytes / 1024) . " KB";
			} else {
				$output = $bytes . " bytes";
			}
		}
		return $output;
	}
	
	/**
	 * Smarty {css} function plugin
	 *
	 * Type:     function<br>
	 * Name:     css<br>
	 * Purpose:  handle css files from template<br>
	 *
	 * @author   Mihai Varga
	 * @param array
	 * @param Smarty
	 * @return string
	 */
	function css($params, &$smarty)
	{
		global $page;
	    if (empty($params['src'])) {
	        $smarty->trigger_error("css: missing 'src' parameter");
	        return;
	    }
	    $src=$params['src'];
	    $type=isset_or($params['type'],'text/css');
	    $media=isset_or($params['media'],'screen, projection');
	    $browser_cond=isset_or($params['browser_cond']);
	
		$page->add_css_file($src,$type,$media,$browser_cond);
	
		return '';
	}
	
	/**
	 * Smarty {js} function plugin
	 *
	 * Type:     function<br>
	 * Name:     js<br>
	 * Purpose:  handle js files from template<br>
	 *
	 * @author   Mihai Varga
	 * @param array
	 * @param Smarty
	 * @return string
	 */
	
	function js($params, &$smarty)
	{
		global $page;
	    if (empty($params['src'])) {
	        $smarty->trigger_error("js: missing 'src' parameter");
	        return;
	    }
	    $src=$params['src'];
	    $local=isset_or($params['local']) && $params['local']=='false'?false:true;
	    $type=isset_or($params['type'],'text/javascript');
	
		$page->add_js_file($src,$local,$type);
	
		return '';
	}
	
	
	/**
	 * Smarty {bind}{/bind} block plugin
	 *
	 * Type:     block function<br>
	 * Name:     bind<br>
	 * Purpose:  displays the bindind value requested
	 * @author Mihai Varga
	 * @param string contents of the block
	 * @param Smarty clever simulation of a method
	 * @return string string $content translated
	 */
	function bind_v3($params, $content, &$smarty,&$repeat)
	{
		if(!$repeat)
			return $this->bind_v2($params,$content,$smarty);
	}
	
	/**
	 * Smarty {image}{/image} block plugin
	 */
	function image_v3($params, $content, &$smarty, &$repeat){
		if(!$repeat){
			return $this->image_v2($params, $content, $smarty);
		}
	}
	
	/**
	 * Smarty {messages}{/messages} block plugin
	 */
	function messages_v3($params, $content, &$smarty, &$repeat){
		return $this->messages_v2($params, $content, $smarty);
	}
	
	/**
	 * Smarty {tr}{/tr} block plugin
	 */
	function tr_v3($params, $content, &$smarty, &$repeat){
		if(!$repeat)
			return $this->tr_v2($params, $content, $smarty);
	}
}
?>