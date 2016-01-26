<?php
/**
 * Hocks Manager
 */

/**
 * Code Hocks Manager Class
 * @package WebLauncher\Managers
 * @method before_init
 * @method after_init
 * @method before_render
 * @method after_render
 * @method before_session_init
 * @method after_session_init
 * @method before_logout
 * @method after_logout
 * @method before_login
 * @method after_login
 */
class HocksManager
{
    /**
     * @var array $_data Hocks data
     */
    private $_data = array();

    /**
     * Contructor
     */
    function __construct()
    {
        $this->_data = array();
    }

    /**
     * Magic method __call
     * @param string|object $name
     * @param array $args
     * @return mixed
     */
    function __call($name, $args)
    {
        return $this->execute($name);
    }

    /**
     * Add hock method
     * @param string $name
     * @param string|callable $function
     */
    public function add($name, $function)
    {
        if (!isset($this->_data[$name]))
            $this->_data[$name] = array();
        $this->_data[$name][] = $function;
    }

    /**
     * Add arr of functions
     * @param string $name
     * @param array $functions_arr
     */
    public function add_arr($name, $functions_arr)
    {
        foreach ($functions_arr as $function)
            $this->add($name, $function);
    }

    /**
     * Execute hock zone by name
     * @param string $name
     * @param array $arguments
     * @return string
     */
    public function execute($name, $arguments = array())
    {
        if (isset($this->_data[$name]))
            foreach ($this->_data[$name] as $func)
                call_user_func_array($func, $arguments);
        return '';
    }
}