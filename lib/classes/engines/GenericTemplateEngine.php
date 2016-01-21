<?php

class GenericTemplateEngine implements TemplateEngine
{
    /**
     * @var array
     */
    protected $_variables = array();
    /**
     * @var array
     */
    protected $_params = array();

    /**
     * @var array
     */
    protected $_engines = array(
        '.tpl' => 'SmartyTemplateEngine',
        '.php' => 'PhpTemplateEngine'
    );

    /**
     * PhpTemplateEngine constructor.
     * @param array $params
     */
    public function __construct($params = array())
    {
        $this->_params = $params;
        foreach ($this->_engines as $k => $engine) {
            $this->_engines[$k] = new $engine($params);
        }
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (isset($this->_variables[$name]))
            return $this->_variables[$name];
        else
            System::triggerError('Variable ' . $name . ' is not defined in template!');
        return null;
    }

    /**
     * Assign new template var
     * @param $var
     * @param string $value
     */
    public function assign($var, $value = '')
    {
        if (is_array($var))
            foreach ($var as $name => $val)
                $this->_assign($name, $val);
        else
            $this->_assign($var, $value);
    }

    /**
     * @param $var
     * @param $value
     */
    protected function _assign($var, $value)
    {
        $this->_variables[$var] = $value;
        foreach ($this->_engines as $engine)
            $engine->assign($var, $value);
    }

    /**
     * Fetch a template
     * @param string $template
     * @param string $cache_hash
     * @return string
     */
    public function fetch($template, $cache_hash = '')
    {
        $extension = $this->get_extension($template);
        $template .=(pathinfo($template, PATHINFO_EXTENSION)?'':$extension);
        if (isset($this->_engines[$extension]))
            return $this->_engines[$extension]->fetch($template, $cache_hash);
        return '';
    }

    /**
     * Clear cache
     * @param $cache_hash
     * @return bool
     */
    public function clear_cache($cache_hash)
    {
        foreach ($this->_engines as $engine)
            $engine->clear_cache($cache_hash);
        return true;
    }

    /**
     * Disable cache
     * @return bool
     */
    public function disable_cache()
    {
        foreach ($this->_engines as $engine)
            $engine->disable_cache();
        return true;
    }

    /**
     * Enable cache
     * @return bool
     */
    public function enable_cache()
    {
        foreach ($this->_engines as $engine)
            $engine->enable_cache();
        return true;
    }

    /**
     * @return string
     */
    public function get_compile_dir()
    {
        return isset_or($this->_params['compile_dir']);
    }

    /**
     * @return string
     */
    public function get_template_dir()
    {
        return isset_or($this->_params['template_dir']);
    }

    /**
     * Get template vars
     * @param string $var
     * @return array
     */
    public function get_template_var($var = '')
    {
        if ($var)
            return $this->_variables[$var];
        return $this->_variables;
    }

    /**
     * Check if template is cache
     * @param $template
     * @param string $cache_hash
     * @return bool
     */
    public function is_cached($template, $cache_hash = '')
    {
        $extension = $this->get_extension($template);
        $template .=(pathinfo($template, PATHINFO_EXTENSION)?'':$extension);
        if (isset($this->_engines[$extension]))
            $this->_engines[$extension]->is_cached($template, $cache_hash);
    }

    /**
     * Enable/disable cache
     * @param bool|true $enabled
     * @return bool
     */
    public function set_cache($enabled = true)
    {
        foreach ($this->_engines as $engine)
            $engine->set_cache($enabled);
        return true;
    }

    /**
     * Set the compile directory
     * @param $dir
     * @return bool
     */
    public function set_compile_dir($dir)
    {
        $this->_params['compile_dir'] = $dir;
        foreach ($this->_engines as $engine)
            $engine->set_compile_dir($dir);
        return true;
    }

    /**
     * Set template dir
     * @param string $dir
     * @return bool
     */
    public function set_template_dir($dir = '')
    {
        $this->_params['template_dir'] = $dir;
        foreach ($this->_engines as $engine)
            $engine->set_template_dir($dir);
        return true;
    }

    /**
     * Display template
     * @param $template
     * @param string $cache_hash
     */
    public function display($template, $cache_hash = '')
    {
        $extension = $this->get_extension($template);
        $template .=(pathinfo($template, PATHINFO_EXTENSION)?'':$extension);
        if (isset($this->_engines[$extension]))
            $this->_engines[$extension]->display($template, $cache_hash);
    }


    /**
     * Get a template extension
     * @param string $template
     * @return string
     */
    public function get_extension($template)
    {
        $extension = pathinfo($template, PATHINFO_EXTENSION);
        if (!($extension)) {
            $extensions = $this->get_extensions();
            foreach ($extensions as $ext)
                if (file_exists($template . $ext))
                    $extension = str_replace('.','',$ext);
        }
        return '.'.$extension;
    }


    /**
     * Get the template engine based on file extension
     * @param string $extension
     * @return TemplateEngine
     */
    public function get_engine($extension)
    {
        if (isset($this->_engines[$extension])) {
            if (is_a($this->_engines[$extension], 'TemplateEngine'))
                return $this->_engines[$extension];
            else {
                $class_name = $this->_engines[$extension];
                $this->_engines[$extension] = new $class_name($this->_params);
                return $this->_engines[$extension];
            }
        } else {
            System::triggerError('Template engine for extension ' . $extension . ' not found!');
            return false;
        }
    }

    /**
     * Get templates engines extensions
     */
    public function get_extensions()
    {
        return array_keys($this->_engines);
    }

    /**
     * @param $plugin
     * @param $method
     */
    public function register_plugin($plugin, $method, $type)
    {
        foreach ($this->_engines as $engine)
            $engine->register_plugin($plugin, $method, $type);
    }

    /**
     * Check if template exists
     * @param $template
     * @return bool
     */
    public function template_exists($template){
        $exists=false;
        $extension = $this->get_extension($template);
        $template .=(pathinfo($template, PATHINFO_EXTENSION)?'':$extension);
        if (isset($this->_engines[$extension]) && $this->_engines[$extension]->template_exists($template))
            $exists=true;
        return $exists;
    }
}