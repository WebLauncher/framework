<?php
/**
 * Base List Extender
 */

/**
 * Base List extender
 * @package WebLauncher\Objects
 */
class BaseExtenderList
{
    /**
     * @var array $_list List data array
     */
    protected $_list = array();
    /**
     * @var _Base $_model Model linked
     */
    protected $_model = null;
    /**
     * @var array $_methods Methods available
     */
    protected $_methods = array();
    /**
     * @var array $_aliases Aliases for fields
     */
    protected $_aliases = array();
    /**
     * @var bool $_accept_all_methods If it should accept all methods
     */
    protected $_accept_all_methods = null;

    /**
     * Constructor
     * @param _Base $model
     */
    function __construct($model)
    {
        $this->_model =& $model;
    }

    /**
     * Magic method get
     * @param string $name
     * @return mixed
     */
    function __get($name)
    {
        if (isset($this->_list[$name]))
            return $this->_list[$name];
        if (isset($this->_aliases[$name]))
            return $this->_list[$this->_aliases[$name]];
        System::triggerError('Extension ' . $name . ' not found on model ' . get_class($this->_model) . '.');
        return null;
    }

    /**
     * Add class
     * @param object $class
     */
    function add($class)
    {
        if (is_array($class)) {
            foreach ($class as $cl)
                $this->add($cl);
        } else {
            $obj = null;
            if (is_string($class) && !in_array($class, array_keys($this->_list))) {
                $cname = 'Base' . $class;
                $this->_aliases[$class] = $cname;
                $obj = new $cname($this->_model);
                $class = $cname;
            } elseif (is_object($class) && is_a($class, 'BaseExtender') && !isset($this->_list[get_class($class)])) {
                $obj = $class;
                $class = get_class($obj);
            }
            // check class vars to get from model
            $c_vars = get_class_vars($class);
            $model_vars = get_object_vars($this->_model);
            foreach ($c_vars as $k => $v) {
                if (isset($model_vars[$k]))
                    $obj->{$k} = $model_vars[$k];
            }
            $obj->init();
            $this->_list[$class] = $obj;
            if ($obj->accept_all_methods)
                $this->_accept_all_methods = $class;

            $this->_methods = array_merge($this->_methods, $this->_get_methods($class));
        }
    }

    /**
     * Unload extension class
     * @param mixed $class
     */
    function unload($class)
    {
        unset($this->_list[$class]);
    }

    /**
     * Get methods
     * @param object $class
     * @return array
     */
    private function _get_methods($class)
    {
        if (is_object($class))
            $class = get_class($class);
        return array_fill_keys(get_class_methods($class), $class);
    }

    /**
     * Magic call method
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    function __call($name, $arguments)
    {
        if (isset($this->_methods[$name]))
            return call_user_func_array(array(
                $this->{$this->_methods[$name]},
                $name
            ), $arguments);
        elseif ($this->_accept_all_methods)
            return call_user_func_array(array(
                $this->{$this->_accept_all_methods},
                $name
            ), $arguments);
        return null;
    }

    /**
     * Check if method exists
     * @param string $name
     * @return bool
     */
    function method_exists($name)
    {
        return isset($this->_methods[$name]) || $this->_accept_all_methods;
    }
}