<?php
/**
 * Api Controller Class
 */

/**
 * PageApi Class - Component/Controller Api Object to be extended in components
 *
 * @package WebLauncher\Objects
 */
class PageApi extends Page {
    var $model = '';
    var $method = 'get';
    var $params = array();

    /**
     * On init method
     */
    function _on_init() {
        parent::_on_init();
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: accept, content-type, authorization");
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            header("Access-Control-Allow-Headers: accept, content-type, authorization");
            header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE');
            die ;
        }
    }

    /**
     * On load method
     */
    function _on_load() {
        header("Content-Type: application/json");
        $this -> model = $this -> system -> subquery[1];
        $this -> method = strtolower($_SERVER['REQUEST_METHOD']);
        if (isset($this -> system -> subquery[2]) && $this -> system -> subquery[2])
            $this -> params = array_slice($this -> system -> subquery, 2);
        if (method_exists($this, 'api_' . $this -> method))
            $this -> {'api_'.$this->method}();
        parent::_on_load();
    }

    /**
     * Api get method
     */
    function api_get() {
        $return = $this -> models -> {$this -> model} -> api_get($this -> params);
        die(json_encode($return, JSON_NUMERIC_CHECK));
    }

    /**
     * Api delete method
     */
    function api_delete() {
        $return = $this -> models -> {$this -> model} -> api_delete($this -> params);
        die(json_encode($return, JSON_NUMERIC_CHECK));
    }

    /**
     * Api put method
     */
    function api_put() {
        $return = $this -> models -> {$this -> model} -> api_put($this -> get_json(), $this -> params);
        die(json_encode($return, JSON_NUMERIC_CHECK));
    }

    /**
     * Api post method
     */
    function api_post() {
        $return = $this -> models -> {$this -> model} -> api_post($this -> get_json(), $this -> params);
        die(json_encode($return, JSON_NUMERIC_CHECK));
    }

    /**
     * Get json from php://input
     */
    function get_json() {
        return json_decode(file_get_contents('php://input'), true);
    }

}