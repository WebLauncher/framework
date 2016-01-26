<?php
/**
 * Routes Manager file
 */

/**
 * Class Routes Manager
 * @package WebLauncher\Managers
 */
class RoutesManager
{
    /**
     * @var $matched
     */
    private $matched = false;
    /**
     * @var $matched_route
     */
    private $matched_route = '';

    /**
     * RoutesManager constructor.
     */
    public function __construct()
    {

    }

    /**
     * Route request to the pattern
     * @param string $pattern
     * @param string $replacement
     * @param array|string $params
     */
    function route($pattern, $replacement, $params = '')
    {
        if (!$this->matched) {
            $route = array(
                'pattern' => $pattern,
                'replacement' => $replacement,
                'params' => $params
            );
            if ($new_url = $this->_match_route($route, $_REQUEST['q'])) {
                $_REQUEST['q'] = $new_url;
                $this->matched = true;
                $this->matched_route = $route;
            }
        }
    }

    /**
     * Match the given route
     * @param array $route
     * @param $url
     * @return bool
     */
    function _match_route($route, $url)
    {
        if (preg_match("`^" . $route['pattern'] . "`i", $url)) {
            return $this->_check_url(preg_replace('`^' . $route['pattern'] . '`i', $route['replacement'], $url), $url);
        }
        return false;
    }

    /**
     * Check url and assign query vars to $_REQUEST
     * @param string $url
     * @param string $initial_url
     * @return string Processed url
     */
    private function _check_url($url, $initial_url)
    {
        $arr = parse_url($url);
        if ($arr === FALSE)
            return $initial_url;
        $url = $arr['path'];
        if (isset($arr['query'])) {
            $vars = array();
            parse_str($arr['query'], $vars);
            foreach ($vars as $k => $v) {
                $_REQUEST[$k] = $v;
                $_{$_SERVER['REQUEST_METHOD']}[$k] = $v;
            }
        }
        return $url;
    }
}
