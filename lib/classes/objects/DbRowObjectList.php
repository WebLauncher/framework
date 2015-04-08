<?php
/**
 * DbRowObjectList list of rows
 * @package WebLauncher\Objects
 */
class DbRowObjectList implements ArrayAccess,IteratorAggregate,Countable {
    /**
     * @var array $_data List data array
     */
    protected $_data = array();
    /**
     * @var /Base Model that this row is associatied to
     */
    private $_model = '';

    /**
     * Costructor
     * @param array $row
     * @param string $model
     */
    function __construct($row = array(), $model = '') {
        $this -> _model = &$model;
        foreach ($row as $k => $v) {
            if (is_a($v, 'DbRowObject'))
                $this -> _data[$k] = &$v;
            else
                $this -> _data[$k] = new DbRowObject($v, $this -> _model);
        }
    }

    /**
     * ArrayAccess exists
     * @param string $key
     */
    function offsetExists($key) {
        return isset($this -> _data[$key]);
    }

    /**
     * ArrayAccess get
     * @param string $key
     */
    function offsetGet($key) {
        return (isset($this[$key]) ? $this -> _data[$key] : '');
    }

    /**
     * ArrayAccess set
     * @param string $key
     * @param string $value
     */
    function offsetSet($key, $value) {
        if (!is_a($value, 'DbRowObject'))
            $value = new DbRowObject($value, $this -> _model);
        $this -> _data[$key] = $value;
    }

    /**
     * ArrayAccess unset
     * @param string $key
     */
    function offsetUnset($key) {
        $this[$key] = '';
    }

    /**
     * Save list in db
     */
    function save() {
        foreach ($this->_data as $v)
            $v -> save();
    }

    /**
     * Save list in db if forgot to save
     */
    function __destruct() {
        $this -> save();
    }

    /**
     * Get the agregate iterator
     */
    public function getIterator() {
        return new ArrayIterator($this -> _data);
    }

    public function count() {
        count($this -> _data);
    }

}
