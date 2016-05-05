<?php
/**
 * Tables Manager Class
 */

/**
 * DB Tables Manager
 * @package WebLauncher\Managers
 */
class TablesManager implements ArrayAccess
{
    /**
     * @var array System Tables
     */
    private $tables = array();

    /**
     * TablesManager constructor.
     */
    public function __construct($tables = array())
    {
        $this->tables = $tables;
    }

    /**
     * ArrayAccess set
     * @param string $offset
     * @param string $value
     */
    public function offsetSet($offset, $value)
    {

        $this->tables[$offset] = $this->_cleanValue($value);
    }

    /**
     * ArrayAccess exists
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {

        $offset = $this->_cleanValue($offset);
        if (!isset($this->tables[$offset]))
            $this->tables[$offset] = $offset;
        return isset($this->tables[$offset]);
    }

    /**
     * ArrayAccess unset
     * @param string $offset
     */
    public function offsetUnset($offset)
    {

        $offset = $this->_cleanValue($offset);
        unset($this->tables[$offset]);
    }

    /**
     * ArrayAccess get
     * @param string $offset
     * @return mixed|string
     */
    public function offsetGet($offset)
    {

        $offset = $this->_cleanValue($offset);
        return isset($this->tables[$offset]) ? $this->tables[$offset] : $offset;
    }

    /**
     * Magic method get
     * @param string $name
     * @return mixed|string
     */
    public function __get($name)
    {
        $name = $this->_cleanValue($name);
        return $this[$name];
    }

    /**
     * Magic method set
     * @param string $name
     * @param string $value
     */
    public function __set($name, $value)
    {
        $name = $this->_cleanValue($name);
        $value = $this->_cleanValue($value);
        $this[$name] = $value;
    }

    /**
     * Clean old tbl_ and trigger error
     * @param string $value
     * @return string
     */
    private function _cleanValue($value)
    {
        return substr($value, 0, 4) == 'tbl_' ? substr($value, 4) : $value;
    }
}
