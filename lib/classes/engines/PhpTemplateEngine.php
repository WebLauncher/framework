<?php

/**
 * Class PhpTemplateEngine
 */
class PhpTemplateEngine implements TemplateEngine
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
     * PhpTemplateEngine constructor.
     * @param array $params
     */
    public function __construct($params = array())
    {
        $this->_params = $params;
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
    }

    /**
     * Fetch a template
     * @param $template
     * @param string $cache_hash
     * @return string
     */
    public function fetch($template, $cache_hash = '')
    {
        if (pathinfo($template, PATHINFO_EXTENSION) == '')
            $template .= '.php';
        $template = new PhpTemplate($template, $this);
        return $template->fetch();
    }

    /**
     * Clear cache
     * @param $cache_hash
     * @return bool
     */
    public function clear_cache($cache_hash)
    {
        return true;
    }

    /**
     * Disable cache
     * @return bool
     */
    public function disable_cache()
    {
        return true;
    }

    /**
     * Enable cache
     * @return bool
     */
    public function enable_cache()
    {
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
        return false;
    }

    /**
     * Enable/disable cache
     * @param bool|true $enabled
     * @return bool
     */
    public function set_cache($enabled = true)
    {
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
        return true;
    }

    /**
     * Display template
     * @param $template
     * @param string $cache_hash
     */
    public function display($template, $cache_hash = '')
    {
        if (pathinfo($template, PATHINFO_EXTENSION) == '')
            $template .= '.php';
        $template = new PhpTemplate($template, $this);
        echo $template;
    }

    /**
     * @param $plugin
     * @param $method
     * @param $type
     * @return bool
     */
    public function register_plugin($plugin, $method, $type)
    {
        return true;
    }

    /**
     * @param $template
     * @return bool
     */
    public function template_exists($template)
    {
        if (pathinfo($template, PATHINFO_EXTENSION) == '')
            $template .= '.php';
        return file_exists($template);
    }
}