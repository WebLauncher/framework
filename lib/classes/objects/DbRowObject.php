<?php
/**
 * Database Row Object
 */

/**
 * Db Row Object
 * @ignore
 * @package WebLauncher\Objects
 */
class DbRowObject implements ArrayAccess
{
    /**
     * @var array $_data Row data array
     */
    protected $_data = array();
    /**
     * @var array $_old_data Row old data array
     */
    protected $_old_data = array();

    /**
     * @var array $_virtual_data Row virtual data
     */
    protected $_virtual_data = array();

    /**
     * @var /Base $_model Model that the row is from
     */
    private $_model = '';

    /**
     * Constructor
     * @param array $row
     * @param _Base $model
     */
    function __construct($row = array(), $model = null)
    {
        $this->_data = $row;
        $this->_old_data = $row;
        $this->_model = &$model;
    }

    /**
     * ArrayAccess offset exists
     * @param string $field
     * @return bool
     */
    function offsetExists($field)
    {
        return isset($this->_data[$field]);
    }

    /**
     * ArrayAccess ofset get
     * @param string $field
     * @return mixed
     */
    function & offsetGet($field)
    {
        if (isset($this->_data[$field]))
            return $this->_data[$field];
        else
            return $this->_virtual_data[$field];
    }

    /**
     * ArrayAccess offset set
     * @param string $field
     * @param string $value
     */
    function offsetSet($field, $value)
    {
        if (isset($this->_data[$field]))
            $this->_data[$field] = $value;
        else
            $this->_virtual_data[$field] = $value;
    }

    /**
     * Set the field value
     * @param string $field
     * @param string $value
     * @return $this
     */
    function set($field, $value)
    {
        $this[$field] = $value;
        return $this;
    }

    /**
     * ArrayAccess unset
     * @param string $field
     */
    function offsetUnset($field)
    {
        $this[$field] = '';
    }

    /**
     * Save row method
     */
    function save()
    {
        $diff = $this->_differences();
        if (count($diff))
            $this->_model[$this->_old_data[$this->_model->id_field]] = $diff;
    }

    /**
     * Get get differences
     */
    private function _differences()
    {
        $pars = array();
        foreach ($this->_data as $k => $v)
            if ($v != $this->_old_data[$k])
                $pars[$k] = $v;
        return $pars;
    }

    /**
     * Save object in db if forgot to call save
     */
    function __destruct()
    {
        $this->save();
    }

    /**
     * Clone object and insert into db
     */
    function __clone()
    {
        if (isset($this->_data[$this->_model->id_field]))
            unset($this->_data[$this->_model->id_field]);
        $this->_model[] = $this->_data;
        $this->_data['id'] = $this->_model->last_id();
        $this->_old_data = $this->_data;
    }

    /**
     * Return JSON object when called tostring
     */
    function __toString()
    {
        return json_encode($this->_data);
    }

}
