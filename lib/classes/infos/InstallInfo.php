<?php
/**
 * InstallInfo Class
 */

/**
 * Install info
 * @package WebLauncher\Infos
 */
class InstallInfo
{
    /**
     * Display Info
     */
    public static function display()
    {
        global $page;
        echo 'Checking if server is compatible<br/>';
        echo apache_get_version().'<br/>';
        
        echo '<h2>Required</h2>';

        echo '<h3>Apache</h3>';
        echo self::check('MOD Rewrite: ',in_array ('mod_rewrite', apache_get_modules ()));
        
        echo '<h3>PHP</h3>';
        echo self::check('PHP version >= 5.3.3 [Found '.phpversion().']: ', phpversion() > '5.3.3');
        echo self::check('PDO : ', extension_loaded('pdo'));
        echo self::check('GD2 : ', extension_loaded('gd') && function_exists('gd_info'));
        echo self::check('MCrypt : ', (function_exists('mcrypt_decrypt')));
        echo self::check('CURL : ', extension_loaded('curl'));
        echo self::check('MBstring : ', extension_loaded('mbstring'));
        
        echo '<h2>Recomended [mostly for production]</h2>';
        echo '<h3>Apache</h3>';
        echo self::check('MOD Security: ',in_array ('mod_security', apache_get_modules ()));
        echo self::check('MOD Filter: ',in_array ('mod_filter', apache_get_modules ()));
        echo self::check('MOD Deflate: ',in_array ('mod_deflate', apache_get_modules ()));
        echo self::check('MOD Expires: ',in_array ('mod_expires', apache_get_modules ()));
        
        echo '<h3>PHP</h3>';
        echo self::check('APC or eAccelerator or OPCache : ', extension_loaded('apc') || extension_loaded('eaccelerator') || function_exists('opcache_reset'));
        echo self::check('SOAP : ', extension_loaded('soap'));
        echo self::check('Posix : ', extension_loaded('posix'));
        echo self::check('MBregex : ', extension_loaded('mbregex'));
        

        echo '<br/>';
        if (isset($page->db_connections[0])) {
            echo 'Checking MySQL Database connection and tables<br/>';
            flush();
            global $page;
            $connect = 1;
            try {
                $dbh = new PDO('mysql:host=' . isset_or($page->db_connections[0]['host']) . ';dbname=' . isset_or($page->db_connections[0]['dbname']), isset_or($page->db_connections[0]['user']), isset_or($page->db_connections[0]['password']));
                $dbh->query('SELECT 1;');
                $dbh = null;
            } catch (PDOException $e) {
                $connect = 0;
            }

            echo self::check('MySql Database connection: ', $connect);
        }
    }

    /**
     * Get success message
     * @param string $str
     */
    private static function get_success($str)
    {
        return '<span style="color:#0c0;">' . $str . '</span>';
    }

    /**
     * Get error message
     * @param string $str
     */
    private static function get_error($str)
    {
        return '<span style="color:#f00;">' . $str . '</span>';
    }

    /**
     * Check method
     * @param string $pretext
     * @param string $condition
     */
    private static function check($pretext, $condition)
    {
        return $pretext . ($condition ? self::get_success('PASSED') : self::get_error('NOT PASSED')) . '<br/>';
    }

}
?>