<?php
/**
 * Trace Manager Class
 */
/**
 * System Trace Manager
 * @package WebLauncher\Managers
 */
class TraceManager {
    /**
     * @var string $trace Generated Trace
     */
    public static $trace = '';

    /**
     * @var array $files Trace files
     */
    public static $files = array();
    
    /**
     * @var array $components Components
     */
    public static $components = array();

    /**
     * Generate trace
     */
    public static function generate() {
        global $page;
        $page -> import('library', 'kint');
        
        $file_name = microtime(true) . '_' . sha1($page -> paths['root']) . '_' . sha1($page -> query) . '_' . sha1(echopre_r($_REQUEST)) . '.html';
        $page -> session['__current_trace'] = $file_name;

        $db = self::get_debug($page -> get_page());

        $session = self::get_debug($page -> session);

        $paths = self::get_debug($page -> paths);

        $user = self::get_debug($page -> user);
        
        $browser = self::get_debug($page -> browser);
        
        $template = self::get_debug($page->template?$page->template->get_template_var():array());

        $random = base64_encode(microtime());
        $times = $page -> time -> get_list();
        $memory = $page -> memory -> get_list();
        
        $request = self::get_debug($_REQUEST);
        
        $db_conn = array();
        if (is_a($page -> db_conn -> tables, 'TablesManager')) {
            $db_conn['dns'] = $page -> db_conn -> get_dns();
            $db_conn['tables'] = self::get_debug($page -> db_conn -> get_tables());
            $db_conn['db_no_valid_queries'] = $page -> db_conn -> num_valid_queries;
            $db_conn['db_no_invalid_queries'] = $page -> db_conn -> num_invalid_queries;
            $db_conn['db_queries'] = self::get_debug($page -> db_conn -> queries);
            $db_conn['db_slowest_query'] = self::get_debug($page -> db_conn -> get_slowest_query());
        }
        //$db_conn = self::get_debug($db_conn);

        $btn_style = "border:1px solid #ccc; color:#000; background:#efefef;margin-right:4px; border-top:0;height:auto;padding:auto;margin:auto; clear:none; float:left; width:auto;";
        $page -> trace_page = '<div style="clear:both; position:fixed;bottom:0px; z-index:20000000000;"><button id="btn_page_trace_' . $random . '" onclick="window.open(\'' . $page -> paths['root'] . '?a=__sys_trace&page=' . $page -> session['__current_trace'] . '\');" style="' . $btn_style . '">&raquo;</button>';
        if ($page -> debug)
            $page -> trace_page .= '';
        if ($page -> logger -> active && $page -> logger -> no)
            $page -> trace_page .= '<button onclick="jQuery(\'#page_log_' . $random . '\').toggle();" style="' . $btn_style . '">log (' . $page -> logger -> no . ')</button>';
        $page -> trace_page .= '</div>';

        ob_start();
        include __DIR__ . '/../../templates/trace/trace_page.php';
        self::$trace = ob_get_clean();
        $page -> trace_page .= '</div>';
        if ($page -> debug)
            $page -> trace_page .= '<div id="page_template_0101" style="background:#fff;display:none;clear:both; border:1px solid #000; height:400px;"><br/><iframe id="page_template_0101_frame" frameborder="0"  vspace="0"  hspace="0"  marginwidth="0"  marginheight="0" width="100%" height="100%"></iframe></div>';

        if ($page -> logger -> active && $page -> logger -> no)
            $page -> trace_page .= '<div id="page_log_' . $random . '" style="background:#fff;display:none;clear:both; border:1px solid #000; height:400px; overflow:scroll;">
						' . $page -> logger -> get() . '</div>';
        self::save();
    }

    /**
     * Get debug data
     * @param object $data
     */
    public static function get_debug($data) {
        ob_start();
        !d($data);
        return ob_get_clean();
    }

    /**
     * Save trace
     */
    public static function save() {
        global $page;
        $html = self::$trace;
        if ($trace_dir = self::check_dir())
            file_put_contents($trace_dir . $page -> session['__current_trace'], $html);
        self::clean_dir();
    }

    /**
     * Check directory
     */
    public static function check_dir() {
        global $page;
        $trace_dir = sys_get_temp_dir() . '/wbl_sys_trace/';
        if (!is_dir($trace_dir) ) {
            if (!mkdir($trace_dir, 0777, true)) {
                $this -> logger -> log('Cache_Write_Error', 'Can not create dir "' . $trace_dir . '" to cache folder!');
                return false;
            }
        }
        elseif(!is_writable ($trace_dir))
        {
            $trace_dir = $page->paths['root_cache'] . 'wbl_sys_trace/';
            if (!is_dir($trace_dir) && !mkdir($trace_dir, 0777, true)) {
                $this -> logger -> log('Cache_Write_Error', 'Can not create dir "' . $trace_dir . '" to cache folder!');
                return false;
            }
        }
        return $trace_dir;
    }

    /**
     * Clean directory
     */
    public static function clean_dir() {
        global $page;
        $trace_dir = self::check_dir();
        if ($handle = opendir($trace_dir)) {

            /* This is the correct way to loop over the directory. */
            while (false !== ($file = readdir($handle))) {
                if (filemtime($trace_dir . $file) <= time() - 60 * 15 && $file != '.' && $file != '..') {
                    unlink($trace_dir . $file);
                }
            }

            closedir($handle);
        }
    }

    /**
     * Get current files
     */
    public static function get_trace_files() {
        global $page;
        $trace_dir = self::check_dir();
        $files = array();
        if ($handle = opendir($trace_dir)) {

            /* This is the correct way to loop over the directory. */
            while (false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..' && strpos($file, '_' . sha1($page -> paths['root']) . '_') !== false) {
                    $line = fgets(fopen($trace_dir.$file, 'r'));  
                    $line = substr($line,5,strlen($line)-11);
                    $line=ltrim($line,'/');
                    $files[date("l jS F \@ g:i:s a", substr($file, 0, strpos($file, '_'))).($line?' ('.$line.')':'')] = $file;
                }
            }
        }
        return $files;
    }

    /**
     * Init trace
     */
    public static function init() {
        global $page;
        if ($trace_dir = self::check_dir()) {
            if (isset_or($page -> actions[0]) == '__sys_trace' || isset_or($page -> actions[0]) == '__sys_trace_build') {
                $page->import('library','wbl_system');
            } else if (isset_or($page -> actions[0]) == '__sys_trace_phpinfo') {
                phpinfo();die;
            } else if (isset_or($page -> actions[0]) == '__sys_trace_get') {
                if(file_exists($trace_dir . $_REQUEST['page']))
                    echo file_get_contents($trace_dir . $_REQUEST['page']);
                else 
                    echo 'File not found for trace: '.$_REQUEST['page'];
                die ;            
            }
        }
    }

    /**
     * Get trace template
     * @param string $name
     */
    public static function get_template($name) {
        global $page;
        ob_start();
        include __DIR__ . '/../../templates/trace/' . $name . '.php';
        $html = ob_get_clean();
        $html = preg_replace('!\s+!', ' ', $html);
        return $html;
    }
}
?>