<?php
/**
 * Api Model Class
 */

/**
 * Api Model Class - Api Model Object to be extended in components
 *
 * @package WebLauncher\Objects
 */
class BaseApi extends Base {
    /**
     * Error method
     * @param string $message
     * @param int $code
     * @return array
     */
    public function error($message, $code = 1) {
        return array(
            'error' => $code,
            'message' => $message
        );
    }

    /**
     * Api GET method
     * Returns one element if id provided or all elements from db
     * @param array $url_params Pass data from url like REST
     * @return array|null
     */
    public function api_get($url_params) {
        if (isset_or($url_params[0]))
            return $this -> get($url_params[0]);
        return $this -> get_all();
    }

    /**
     * Api DELETE method
     * Deletes the row identified by the provided ID
     * @param array $url_params Pass data from url like REST
     * @return int
     */
    public function api_delete($url_params) {
        $this -> delete($url_params[0]);
        return 1;
    }

    /**
     * Api PUT method
     * Updates the row identified by the provided ID
     * @param array $params Data provided as JSON in php://input
     * @param array $url_params Data provided in the url as REST
     * @return array The updated row
     */
    public function api_put($params, $url_params) {
        $id = isset_or($params[$this -> id_field]);
        if (isset_or($url_params[0]))
            $id = $url_params[0];
        $params[$this -> id_field] = $id;
        $this -> update($params);
        return $this -> get($params[$this -> id_field]);
    }

    /**
     * Api POST method
     * Inserts or updates the row into db (updates if the ID is provided)
     * @param array $params Data provided as JSON in php://input
     * @param array $url_params Data provided in the url as REST
     * @return array The inserted/updated row
     */
    public function api_post($params, $url_params) {
        $id = isset_or($params[$this -> id_field]);
        if (isset_or($url_params[0]))
            $id = $url_params[0];
        $params[$this -> id_field] = $id;
        $id = $this -> save($params);
        return $this -> get($id);
    }
}