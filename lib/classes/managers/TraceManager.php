<?php
/**
 * Trace Manager Class
 */

/**
 * System Trace Manager
 * @package WebLauncher\Managers
 */
class TraceManager
{
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
     * @param bool $save
     */
    public static function generate($save = true)
    {
        

        if (!$save) {
            $file_name = microtime(true) . '_' . sha1(System::getInstance()->paths['root']) . '_' . sha1(System::getInstance()->query) . '_' . sha1(echopre_r($_REQUEST)) . '.html';
            System::getInstance()->session['__current_trace'] = $file_name;
        }
        $db = self::get_debug(System::getInstance()->get_page());

        $session = self::get_debug(System::getInstance()->session);

        $paths = self::get_debug(System::getInstance()->paths);

        $user = self::get_debug(System::getInstance()->user);

        $browser = self::get_debug(System::getInstance()->browser);

        $template = self::get_debug(System::getInstance()->template ? System::getInstance()->template->get_template_var() : array());

        $random = base64_encode(microtime());
        $times = System::getInstance()->time->get_list();
        $memory = System::getInstance()->memory->get_list();

        $request = self::get_debug($_REQUEST);

        $db_conn = array();
        if (System::getInstance()->db_conn && is_a(System::getInstance()->db_conn->tables, 'TablesManager')) {
            $db_conn['dns'] = System::getInstance()->db_conn->get_dns();
            $db_conn['tables'] = self::get_debug(System::getInstance()->db_conn->get_tables());
            $db_conn['db_no_valid_queries'] = System::getInstance()->db_conn->num_valid_queries;
            $db_conn['db_no_invalid_queries'] = System::getInstance()->db_conn->num_invalid_queries;
            $db_conn['db_queries'] = self::get_debug(System::getInstance()->db_conn->queries);
            $db_conn['db_slowest_query'] = self::get_debug(System::getInstance()->db_conn->get_slowest_query());
        }

        $btn_style = "border:1px solid #ccc; color:#000; background:#efefef;margin-right:4px; border-top:0;height:auto;padding:auto;margin:auto; clear:none; float:left; width:auto;";
        System::getInstance()->trace_page = '<div style="clear:both; position:fixed;bottom:0px; z-index:20000000000;"><button id="btn_page_trace_' . $random . '" onclick="window.open(\'' . System::getInstance()->paths['root'] . '?a=__sys_trace&page=' . urlencode(System::getInstance()->session['__current_trace']) . '\');" style="' . $btn_style . '">&raquo;</button>';
        if (System::getInstance()->debug)
            System::getInstance()->trace_page .= '';
        if (System::getInstance()->logger->active && System::getInstance()->logger->no)
            System::getInstance()->trace_page .= '<button onclick="jQuery(\'#page_log_' . $random . '\').toggle();" style="' . $btn_style . '">log (' . System::getInstance()->logger->no . ')</button>';
        System::getInstance()->trace_page .= '</div>';


        System::getInstance()->trace_page .= '</div>';
        if (System::getInstance()->debug)
            System::getInstance()->trace_page .= '<div id="page_template_0101" style="background:#fff;display:none;clear:both; border:1px solid #000; height:400px;"><br/><iframe id="page_template_0101_frame" frameborder="0"  vspace="0"  hspace="0"  marginwidth="0"  marginheight="0" width="100%" height="100%"></iframe></div>';

        if (System::getInstance()->logger->active && System::getInstance()->logger->no)
            System::getInstance()->trace_page .= '<div id="page_log_' . $random . '" style="background:#fff;display:none;clear:both; border:1px solid #000; height:400px; overflow:scroll;">
						' . System::getInstance()->logger->get() . '</div>';
        if ($save) {
            ob_start();
            include __DIR__ . '/../../templates/trace/trace_page.php';
            self::$trace = ob_get_clean();
            self::save();
        }
    }

    /**
     * Get debug data
     * @param object $data
     * @return string
     */
    public static function get_debug($data)
    {
        return echopre($data, true);
    }

    /**
     * Save trace
     */
    public static function save()
    {
        
        $html = self::$trace;
        if ($trace_dir = self::check_dir())
            file_put_contents($trace_dir . System::getInstance()->session['__current_trace'], $html);
        self::clean_dir();
    }

    /**
     * Check directory
     */
    public static function check_dir()
    {
        
        $trace_dir = sys_get_temp_dir() . '/wbl_sys_trace/';
        if (!file_exists($trace_dir)) {
            if (!mkdir($trace_dir, 0777, true)) {
                return false;
            }
        } elseif (!is_writable($trace_dir)) {
            $trace_dir = System::getInstance()->paths['root_cache'] . 'wbl_sys_trace/';
            if (!file_exists($trace_dir) && !mkdir($trace_dir, 0777, true)) {
                return false;
            }
        }
        return $trace_dir;
    }

    /**
     * Clean directory
     */
    public static function clean_dir()
    {
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
    public static function get_trace_files()
    {
        
        $trace_dir = self::check_dir();
        $files = array();
        if ($handle = opendir($trace_dir)) {

            /* This is the correct way to loop over the directory. */
            while (false !== ($file = readdir($handle))) {
                if ($file != '.' && $file != '..' && strpos($file, '_' . sha1(System::getInstance()->paths['root']) . '_') !== false) {
                    $line = fgets(fopen($trace_dir . $file, 'r'));
                    $line = substr($line, 5, strlen($line) - 11);
                    $line = ltrim($line, '/');
                    $files[date("l jS F \@ g:i:s a", substr($file, 0, strpos($file, '_'))) . ($line ? ' (' . $line . ')' : '')] = $file;
                }
            }
        }
        return $files;
    }

    /**
     * Init trace
     */
    public static function init()
    {
        
        if ($trace_dir = self::check_dir()) {
            if (isset_or(System::getInstance()->actions[0]) == '__sys_trace_phpinfo') {
                phpinfo();
                die;
            } else if (isset_or(System::getInstance()->actions[0]) == '__sys_trace_get') {
                if (file_exists($trace_dir . $_REQUEST['page']))
                    echo file_get_contents($trace_dir . $_REQUEST['page']);
                else
                    echo 'File not found for trace: ' . $_REQUEST['page'];
                die;
            } else if ((($pos = strpos(isset_or(System::getInstance()->actions[0]), '__sys_trace')) !== FALSE && $pos == 0) || System::getInstance()->content == '_system') {
                System::getInstance()->import('library', 'wbl_system');
            }
        }
    }

    /**
     * Get trace template
     * @param string $name
     * @return mixed|string
     */
    public static function get_template($name)
    {
        ob_start();
        
        include __DIR__ . '/../../templates/trace/' . $name . '.php';
        $html = ob_get_clean();
        $html = preg_replace('!\s+!', ' ', $html);
        return $html;
    }
}