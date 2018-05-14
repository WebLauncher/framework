<?php

/**
 * System class.
 *
 * PHP version 5.3
 *
 * @category Class
 * @package  WebLauncher\System
 * @author   WebLauncher <contact@weblauncher.ro>
 * @license  GPL-3.0 http://opensource.org/licenses/LGPL-3.0
 * @link     http://www.weblauncher.ro
 *
 */

/**
 * Directory Separator
 * @package  WebLauncher\System
 */
define('DS', DIRECTORY_SEPARATOR);

/**
 * System Version
 * @package  WebLauncher\System
 */
define('SYS_VERSION', '2.7.10');

/**
 * System Class.
 *
 * @property mixed ispostback
 * @property string visits_logs_enabled
 * @property mixed ajax
 * @property mixed browser
 * @property mixed ssl
 * @property mixed browser_ip
 * @property mixed sys_version
 * @property mixed server
 * @category Class
 * @package  WebLauncher\System
 * @author   WebLauncher <contact@weblauncher.ro>
 * @license  GPL-3.0 http://opensource.org/licenses/LGPL-3.0
 * @link     http://www.weblauncher.ro
 */
class System
{
    /**
     * @var System class instance
     */
    public static $instance;

    /**
     * @var string $title Page Title
     */
    public $title = 'Title not assigned!';

    /**
     * @var string $doctype Doctype text
     */
    public $doctype = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 
    Transitional//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';

    /**
     * @var string $html_tag Html tag to use for template
     */
    public $html_tag = '<html xmlns="http://www.w3.org/1999/xhtml">';

    /**
     * @var string $body_tag Body tag to use for template
     */
    public $body_tag = '<body>';

    /**
     * @var string $content_type Content type setting
     */
    public $content_type = 'text/html; charset=UTF-8';

    /**
     * The setting of the tile in the database
     * @var string $title_setting
     */
    public $title_setting = 'general_page_title';

    /**
     * @var boolean flag if page is live
     */
    public $live = false;

    /**
     * @var int flag if administrative zone
     */
    public $admin = 0;

    /**
     * @var boolean flag if default admin zone is enabled
     */
    public $admin_enabled = true;

    /**
     * @var string page query
     */
    public $query = '';

    /**
     * @var array page subqueries array
     */
    public $subquery = array();

    /**
     * @var string page content
     */
    public $content = 'home';

    /**
     * @var array page components
     */
    public $components = array();

    /**
     * @var string page component
     */
    public $component = '';

    /**
     * @var string Subcomponents Name
     */
    public $subcomponent = '';

    /**
     * @var array page meta tags array
     */
    public $meta_tags = array();

    /**
     * @var string page skin
     */
    public $skin = 'default';

    /**
     * @var string page default skin
     */
    public $default_skin = 'default';

    /**
     * @var string Skins Folder ( default:'skins/' )
     */
    public $skins_folder = 'assets/skins/';

    /**
     * @var string skin server path
     */
    public $skin_server_path = '';

    /**
     * @var string assets server path
     */
    public $assets_server_path = '';

    /**
     * @var string page default module
     */
    public $default_module = 'site/';

    /**
     * @var string page module
     */
    public $module = '';

    /**
     * @var string current module user type for authentication
     */
    public $module_user_type = '';

    /**
     * @var string Modules folder path
     */
    public $modules_folder = 'modules';

    /**
     * @var array current actions array
     */
    public $actions = array();

    /**
     * @var array Actions executed list
     */
    public $actions_executed = array();

    /**
     * @var array current errors array
     */
    public $errors = array();

    /**
     * Error log files path e.g. /home/errors/
     * @var string
     */
    public $error_log_path = '';

    /**
     * Error log e-mail to send fatal errors
     * @var string
     */
    public $error_log_email = "";

    /**
     * @var array current messages array
     */
    public $messages = array();

    /**
     * @var array history array
     */
    public $history = array();

    /**
     * @var boolean flag for history active
     */
    public $history_active = true;

    /**
     * @var array paths array
     */
    public $paths = array();

    /**
     * @var boolean flag if should connect to database
     */
    public $db_conn_enabled = true;

    /**
     * @var DbManager database connection
     */
    public $db_conn;

    /**
     * @var array database connections array
     */
    public $db_connections = array();

    /**
     * @var array objects array
     */
    public $objects = array();

    /**
     * @var string Objects Folder
     */
    public $objects_folder = 'objects';

    /**
     * Check cookies flag
     * @var boolean
     */
    public $check_cookies = false;

    /**
     * Cookies enabled flag
     * @var boolean
     */
    public $cookies_enabled = false;

    /**
     * @var mixed session var
     */
    public $session = '';

    /**
     * @var SessionManager session manager class
     */
    public $session_manager = '';

    /**
     * @var string session cookie
     */
    public $session_cookie = 'default_session_cookie';

    /**
     * @var int session default timeout in seconds
     */
    public $session_timeout = 1800;

    /**
     * @var string session cookie module
     */
    public $session_cookie_module = '';

    /**
     * @var mixed user data array
     */
    public $user = '';

    /**
     * @var boolean trace activation flag [true/false]
     */
    public $trace = false;

    /**
     * @var string trace string
     */
    public $trace_page = '';

    /**
     * @var boolean debug activation flag
     */
    public $debug = true;

    /**
     * Database tables
     * @var array unknown_type
     */
    public $tables = array();

    /**
     * @var array database tables
     */
    public $user_types_tables = array();

    /**
     * @var boolean flag if pagination from db is enabled
     */
    public $pagination_enabled = true;

    /**
     * @var array pagination array
     */
    public $pagination = array(0 => 10);

    /**
     * @var int current page number
     */
    public $page_no = 1;

    /**
     * @var int current page skip number
     */
    public $page_skip = 0;

    /**
     * @var int current page offset number
     */
    public $page_offset = 10;

    /**
     * @var int current page total rows
     */
    public $no_total_rows = -1;

    /**
     * @var int current number of pages
     */
    public $no_pages = 0;

    /**
     * @var FilesManager page files manager
     */
    public $files_manager;

    /**
     * @var string files manager folder
     */
    public $files_folder = 'files/';

    /**
     * @var array files manager allowed upload extensions
     */
    public $upload_allowed_extensions = array(
        'png',
        'jpeg',
        'gif',
        'bmp',
        'doc',
        'pdf',
        'zip',
        'jpg',
        'mp4',
        'wmv',
        'mpeg',
        'avi',
        '3gp',
        'MP4',
        'swf',
        'docx',
        'ppt',
        'pptx',
        'xls',
        'xlsx'
    );

    /**
     * @var boolean page restricted flag
     */
    public $restricted = false;

    /**
     * @var array page state array
     */
    public $state;

    /**
     * @var boolean check login on page flag
     */
    public $check_login = false;

    /**
     * Custom login messages
     * @var array
     */
    public $login_messages = array(
        'active' => 'User is not activated!',
        'deleted' => 'User is deleted!',
        'valid' => 'User is invalid!',
        'success' => 'You are logged in!',
        'no_user' => 'The given username does not exist!',
        'no_pass' => 'The password you provided is invalid!'
    );

    /**
     * @var boolean Show/Hide Log-in messages
     */
    public $show_login_messages = true;

    /**
     * @var boolean user authenticated flag
     */
    public $logged = false;

    /**
     * @var FormsManager validation manager
     */
    public $validate;

    /**
     * @var boolean form valid flag
     */
    public $valid = true;

    /**
     * @var string page crypt key
     */
    public $crypt_key = 'default';

    /**
     * @var boolean flag if settings are enabled
     */
    public $settings_enabled = false;

    /**
     * @var array page settings array
     */
    public $settings = array();

    /**
     * @var string page settings table
     */
    public $settings_table = 'settings';

    /**
     * @var boolean render entire page flag
     */
    public $render_all = true;

    /**
     * @var boolean page multilanguage flag
     */
    public $multi_language = false;

    /**
     * @var Page index page object
     */
    public $obj_index;

    /**
     * @var TimeLogger
     */
    public $time;

    /**
     * @var CacheManager
     */
    public $cache;

    /**
     * @var AuthenticationManager
     */
    public $authenticate;

    /**
     * @var EmailManager
     */
    private $_mail = null;

    /**
     * Mail sender type
     * @var string
     */
    public $mail_type = 'mail';

    /**
     * Mail queue table
     * @var string
     */
    public $mail_queue_table = 'email_queue';

    /**
     * Mail host
     * @var string
     */
    public $mail_host = 'localhost';

    /**
     * Mail user
     * @var string
     */
    public $mail_user = '';

    /**
     * SMTP mail password
     * @var string
     */
    public $mail_password = '';

    /**
     * SMTP Host port
     * @var string
     */
    public $mail_port = 25;

    /**
     * SMTP ssl active
     * @var boolean
     */
    public $mail_ssl = false;

    /**
     * E-mail default parameters
     * @var array
     */
    public $mail_defaults = array(
        'subject' => 'system new e-mail',
        'from' => 'from@website.com',
        'fromname' => 'system from name',
        'reply_to' => 'no-reply@website.com',
        'reply_name' => 'system reply name',
        'attachments' => array(),
        'mail_in' => 'to',
        'sender' => '',
        'others' => array()
    );

    /**
     * @var ScriptManager New variable for scripts manager
     */
    public $scripts = '';

    /**
     * @var array loaded libraries array
     */
    public $loaded_libraries = array();

    /**
     * @var array system libraries
     */
    public $libraries = array();

    /**
     * @var array $libraries_settings Libraries settings
     */
    public $libraries_settings = array(
        'smarty' => array('version' => 'v2'),
        'wbl_locale' => array(
            'type'=>'db',
            'default'=>'en_US',
            'table' => 'locales',
            'texts_table' => 'locales_texts',
            'translations_table' => 'locales_translations'
        ),
        'wbl_seo' => array(
            'links_table' => 'seo_links',
            'metas_table' => 'seo_metas',
            'trackings_enabled' => false,
            'trackings_mode' => 'all',
            'trackings_table' => 'seo_trackings'
        )
    );

    /**
     * @var MemoryLogger memory used
     */
    public $memory = '';

    /**
     * @var array Current page settings
     */
    public $page = array();

    /**
     * @var boolean search engine optimization per page activated
     */
    public $seo_enabled = false;

    /**
     * @var boolean flag to secure request ( IDS )
     */
    public $secure_request_enabled = false;

    /**
     * @var boolean Log-in Visits Logger ( for statistics )
     */
    public $logins_logs_enabled = false;

    /**
     * @var string Log-in Visits Logger Table
     */
    public $logins_logs_table = 'logins';

    /**
     * System Logger
     * @var SystemLogger
     */
    public $logger = '';

    /**
     * Page cache enabled
     * @var boolean
     */
    public $page_cache_enabled = false;

    /**
     * Cache enabled
     * @var boolean
     */
    public $cache_enabled = false;

    /**
     * Cache options
     * @var string
     */
    public $cache_options = '';

    /**
     * Cache enabled
     */
    public $no_cache = false;

    /**
     * @var string Cache Folder ( default: 'cache/' )
     */
    public $cache_folder = 'cache';

    /**
     * Cache hash for current page caching
     * @var string
     */
    public $cache_hash = '';

    /**
     * @var FilesManager New variable for files manager
     */
    public $uploads = '';

    /**
     * @var DownloadManager $downloads Download manager object
     */
    public $downloads = '';

    /**
     * @var array $download_allowed_extensions Download allowed extensions and filetypes
     */
    public $download_allowed_extensions = array();

    /**
     * Function used form downloading file (reaadfile, fpassthru, stream, xsendfile)
     * @var string
     */
    public $download_function = 'readfile';

    /**
     * Template engine
     * @var TemplateEngine
     */
    public $template = '';

    /**
     * Template engine (default: smarty)
     * @var string
     */
    public $template_engine = 'smarty';

    /**
     * Template file extension
     * @var string
     */
    public $template_extension = '.tpl';

    /**
     * Models Manager
     * @var ModelsManager
     */
    public $models = '';

    /**
     * Flag for enabling components builder
     * @var boolean
     */
    public $build_enabled = false;

    /**
     * Flag for enabling components builder auto-build non-existing components
     * @var boolean
     */
    public $build_auto = false;

    /**
     * List of redirect links e.g. array('test'=>'site/?a=set:test') will redirect
     * website.com/test to website.com/site/?a=set:test
     * @var array
     */
    public $redirects = array();

    /**
     * Js files to be loaded
     * @var array
     */
    public $js_files = array();

    /**
     * CSS files to be loaded
     * @var array
     */
    public $css_files = array();

    /**
     * If SSL should be maintained
     * @var boolean $maintain_ssl
     */
    public $maintain_ssl = false;

    /**
     * Hostname of the request
     * @var string $hostname
     */
    static $hostname = '';

    /**
     * Render Type
     * @var string $render_type
     */
    public $render_type = 'all';

    /**
     * If 404 page is enabled
     * @var bool $enable_404
     */
    public $enable_404 = true;

    /**
     * Hocks Manager
     * @var HocksManager
     */
    public $hocks = null;

    /**
     * If script is run from console on from request
     */
    public $console = false;

    /**
     * Base url to use for paths when running from console
     */
    public $console_baseurl = '';

    /**
     * Flags if cronjobs from database should be run
     */
    public $console_cronjobs_db_enabled = true;

    /**
     * @var array $console_cronjobs_db_table Console cronjobs database table
     */
    public $console_cronjobs_db_table = 'cronjobs';

    /**
     * System error message to display as 500 internal error
     * @var string
     */
    public $system_error = '';

    /**
     * System error show flag
     * @var boolean
     */
    public $system_error_enabled = true;

    /**
     * System config filename
     */
    public $config_file = 'config.php';

    /**
     * System response type
     */
    public $response_type = 'html';

    /**
     * System allowed response types
     */
    public $response_types = array(
        'html',
        'json'
    );

    /**
     * System response data
     */
    public $response_data = array();

    /**
     * System response assign with assign() method
     */
    public $response_assign = false;

    /**
     * System environments
     */
    protected $environments = array('development' => array(
        'localhost',
        '127.0.0.1'
    ));

    /**
     * Layout file
     * @var string
     */
    public $layout = 'layout';

    /**
     * Routes Manager
     * @var RoutesManager
     */
    public $router = null;

    /**
     * If it should use browscap.ini or not
     * @var bool
     */
    public $browser_enabled=false;

    /**
     * System predefined modules
     * @var array
     */
    protected $system_modules=array('img_mod','min','_check','_system');

    /**
     * Constructor
     */
    function __construct()
    {
    }

    /**
     * @return System
     */
    public static function getInstance(){
        if (null === static::$instance) {
            static::$instance = new System();
        }

        return static::$instance;
    }

    /**
     * Call magic method
     *
     * @param string $name Name of the called method
     * @param array $args Arguments
     *
     * @return mixed Value returned by the function call
     */
    function __call($name, $args)
    {
        switch (trim($name)) {
            case 'get_meta_tags' :
                return $this->meta_tags;
                break;
            case 'call_404':
                return $this->_404();
                break;
        }
        if ($name) {
            $name = str_replace('_', '', lcfirst(ucwords_d($name, '_')));
            if (method_exists($this, $name)) {
                return call_user_func_array(array(
                    $this,
                    $name
                ), $args);
            }
        }
        $this->triggerError("Method " . $name . "(".implode(',',$args).") not defined on System class.");
        return null;
    }

    /**
     * Set magic method
     *
     * @param string $name Name of attribute
     * @param string $value Value of the attribute
     */
    function __set($name, $value)
    {
        switch ($name) {
            case 'metas_enabled' :
                $this->seo_enabled = $value;
                break;
            case 'visits_logs_enabled' :
                $this->visits_logs_enabled = $value;
                break;
            default :
                $this->{$name} = $value;
        }
    }

    /**
     * Get magic method
     *
     * @param string $name Name of attribute
     *
     * @return  mixed Attribute
     */
    function __get($name)
    {
        switch ($name) {
            case 'browser' :
                if($this->browser_enabled)
                    return BrowserInfo::get(isset_or($_SERVER['HTTP_USER_AGENT']));
                else
                    return array('user_agent'=>isset_or($_SERVER['HTTP_USER_AGENT']));
                break;

            case 'browser_ip' :
                return BrowserInfo::get_user_ip();
                break;

            case 'server' :
                return ServerInfo::get();
                break;

            case 'ispostback' :
                return (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST');
                break;

            case 'ajax' :
                return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
                break;

            case 'sys_version' :
                return SYS_VERSION;
                break;

            case 'ssl' :
                return isset($_SERVER['HTTPS']);
                break;
            case 'metas_enabled' :
                return $this->seo_enabled;
                break;
            case 'visits_logs_enabled' :
                return $this->logins_logs_enabled;
                break;
            case 'mail':
                if (!$this->_mail)
                    $this->_initMail();
                return $this->_mail;
                break;
            case 'db_conn':
                return false;
                break;
            case 'request_method' :
                $methods = array(
                    'POST',
                    'DELETE',
                    'GET',
                    'PUT'
                );
                return in_array(isset_or($_SERVER['REQUEST_METHOD'], 'GET'), $methods) ? strtolower(isset_or($_SERVER['REQUEST_METHOD'], 'GET')) : 'get';
                break;
            default:
                $this->triggerError('Attribute ' . $name . ' not found on class System.');
                return null;
        }
    }

    /**
     * Import libraries
     *
     * @param string $type ( 'dal', 'functions', 'classes')
     * @param string $file File path
     *
     * @return boolean
     */
    function import($type, $file)
    {
        $types = array(
            'dal',
            'class',
            'library',
            'file',
            'model'
        );
        if($type=='dal')$type='model';
        return in_array($type, $types) && $this->{"load" . ucfirst($type)}($file);
    }

    /**
     * Initialisation function
     */
    function init()
    {

        // init autoload
        $this->_initAutoload();

        // init router
        $this->_initRouter();

        // init functions
        $this->_initFunctions();

        // init configuration
        $this->_initConfig();

        // init console
        $this->_initConsole();

        // init hocks
        $this->_initHocks();

        self::$hostname = self::get_hostname();

        $this->hocks->before_init();

        // init loggers
        $this->_initLoggers();

        // init paths
        $this->_initPaths();

        // init check system requirements
        $this->_initCheck();

        // init trace
        if ($this->trace) {
            $this->_initTrace();
        }

        // init image modifier
        $this->_initImageModifier();

        //init redirects
        $this->_initRedirects();

        // init module config
        $this->_initModuleConfig();

        // init DAL
        $this->_initDal();

        // execute console
        if ($this->console) {
            ConsoleManager::execute();
        }

        // init migrations
        $this->_initMigrations();

        // init minify
        $this->_initMinify();

        // pagination
        $this->_initPagination();

        // get settings from db
        $this->_initSettings();

        // init session
        $this->initSession();

        // check if script file request
        $this->_initJsScript();

        // check if signature requested
        $this->_initSignature();

        // get user info
        $this->_initUser();

        // set language
        $this->_initLanguage();

        // set errors
        $this->_initErrors();

        // set messages
        $this->_initMessages();

        // secure link request and post
        $this->_initSecurity();

        // save history
        $this->_initHistoy();

        // validate if postback
        $this->_initValidation();

        // init uploads
        $this->_initUploads();

        // download manager
        $this->_initDownloads();

        // clear state
        $this->_initState();

        // check if authentication requested
        $this->_initAuthentication();

        // get metas from db
        $this->_initMetas();

        // init title
        $this->_initTitle();

        // apply page settings
        $this->_initPageSettings();

        // init template manager
        $this->_initTemplate();

        // load objects
        $this->_initObjects();

        // init system error
        $this->_initSystemError();
        $this->hocks->after_init();
        $this->memory->save('system_after_init');
        $this->time->end('init');
    }

    /**
     * Init Routes Manager
     */
    private function _initRouter()
    {
        $this->router = new RoutesManager();
    }

    /**
     * Route page to another
     *
     * @param string $pattern Regexp pattern
     * @param string $replacement Replacement URL
     * @param mixed $params Parameters
     */
    public function route($pattern, $replacement, $params = '')
    {
        $this->router->route($pattern, $replacement, $params);
    }

    /**
     * Auto loader
     *
     * @param string $name Name of the class
     */
    static public function generalAutoload($name)
    {
        if (!empty($name)) {
            if (file_exists(__DIR__ . '/classes/objects/' . $name . '.php')) {
                include_once __DIR__ . '/classes/objects/' . $name . '.php';
            } else {
                $results = array();
                preg_match_all('/[A-Z][^A-Z]*/', $name, $results);
                $file = __DIR__ . '/classes/objects/' . $name . '.php';
                if (isset($results[0])) {
                    if (count($results[0])) {
                        $file = __DIR__ . '/classes/' . strtolower(array_pop($results[0])) . 's/' . $name . '.php';
                    }
                }
                if (file_exists($file)) {
                    include_once $file;
                }
            }
        }
    }

    /**
     * Init auto loader
     */
    private function _initAutoload()
    {
        spl_autoload_register('System::generalAutoload');
    }

    /**
     * Init system error
     *
     * @param string $code Error code
     * @param string $message Message
     */
    private function _initSystemError($code = '500', $message = '')
    {
        if ($this->system_error_enabled && ($this->system_error || $message)) {
            $this->system_error = $message ? $message : $this->system_error;
            $err_file = $this->paths['root_code'] . $this->module . 'views/' . $this->skin . '/' . $code . $this->template_extension;
            if (!is_file($err_file)) {
                $err_file = $this->paths['root_code'] . $this->default_module . 'views/' . $this->skin . '/' . $code . $this->template_extension;
                $this->assign('code', $code);
                $this->assign('message', $this->system_error);
            }
            $status = $this->_headerStatus($code);
            if (is_file($err_file) && $this->template) {
                $this->template->display($err_file);
            } else {
                echo '<h1>' . $status . '</h1>' . $this->system_error;
            }
            exit();
        }
    }

    /**
     * System error trigger
     *
     * @param int $code Error code
     * @param string $message Message
     */
    public function system_error($code = 505, $message = '')
    {
        $this->_initSystemError($code, $message);
    }

    /**
     * Init mail attribute
     */
    private function _initMail()
    {
        $this->import('library', 'mail');
        $this->_mail = new EmailManager();
    }

    /**
     * Init console determination function
     */
    private function _initConsole()
    {
        $this->console = defined('PHP_SAPI') && (PHP_SAPI == 'cli' || (php_sapi_name() === 'cli'));
        if ($this->console) {
            ConsoleManager::$system = &$this;
            ConsoleManager::init();
        }
    }

    /**
     * Init Trace function
     */
    private function _initTrace()
    {
        TraceManager::init();
    }

    /**
     * Init hock function
     */
    private function _initHocks()
    {
        $this->hocks = new HocksManager();
    }

    /**
     * Add hock function
     *
     * @param string $name Hock name
     * @param callable $function Function
     *
     * @return bool
     */
    public function addHock($name, $function)
    {
        $this->hocks->add($name, $function);
        return true;
    }

    /**
     * Init configuration function
     */
    private function _initConfig()
    {
        $this->tables = new TablesManager();
        if (defined('SYSTEM_CONFIG_FILE')) {
            $this->config_file = SYSTEM_CONFIG_FILE;
        }
        if (!isset($_SERVER["SCRIPT_FILENAME"]) && isset($_SERVER['PWD'])) {
            $_SERVER['SCRIPT_FILENAME'] = $_SERVER['PWD'] . '/index.php';
            $_SERVER['SCRIPT_NAME'] = isset_or($_SERVER['SCRIPT_NAME'], 'index.php');
        }

        // configuration file
        if (isset($_SERVER["SCRIPT_FILENAME"]) && is_file(dirname($_SERVER["SCRIPT_FILENAME"]) . DS . $this->config_file)) {
            include_once dirname($_SERVER["SCRIPT_FILENAME"]) . DS . $this->config_file;
        } elseif (defined('SYSTEM_CONFIG_PATH') && is_file(SYSTEM_CONFIG_PATH . $this->config_file)) {
            include_once SYSTEM_CONFIG_PATH . $this->config_file;
        } else {
            System::triggerError('Configuration file "' . dirname($_SERVER["SCRIPT_FILENAME"]) . DS . $this->config_file . '" missing!');
        }

        // get environment
        $configs = $this->_getConfigs();
        foreach ($configs as $env) {
            if (isset($_SERVER["SCRIPT_FILENAME"]) && is_file(dirname($_SERVER["SCRIPT_FILENAME"]) . DS . 'config.' . $env . '.php')) {
                include_once dirname($_SERVER["SCRIPT_FILENAME"]) . DS . 'config.' . $env . '.php';
            } else {
                System::triggerError('Configuration file "' . dirname($_SERVER["SCRIPT_FILENAME"]) . DS . 'config.' . $env . '.php" missing!');
            }
        }
        if (substr($this->default_module, -1) !== '/') {
            $this->default_module .= '/';
        }
        $this->_initDebug();
    }

    /**
     * Init functions
     */
    private function _initFunctions()
    {
        // general functions
        $this->import('file', __DIR__ . '/functions/system.php');
        $this->import('file', __DIR__ . '/functions/password.php');
    }

    /**
     * Init loggers function
     */
    private function _initLoggers()
    {
        $this->logger = new SystemLogger($this->trace);
        $this->memory = new MemoryLogger($this->trace);
        $this->time = new TimeLogger($this->trace);

        $this->time->start('system');
        $this->time->start('init');
        $this->memory->save('max', ini_get('memory_limit'), '%s');
        $this->memory->save('system_before_init');
    }

    /**
     * Init template function
     */
    private function _initTemplate()
    {
        global $smarty;
        $this->import('library', 'Smarty');
        $smarty = TemplatesManager::get_engine($this->template_engine, $this->libraries_settings['smarty']['version'], $this->paths['root_code'], $this->paths['root_cache'], $this->trace, $this->debug, $this->page_cache_enabled);
        $this->template = &$smarty;
        if ($this->template_engine == 'smarty' || $this->template_engine == 'generic') {
            $this->import('library', 'wbl_smarty');
        }
        $this->changeTemplateDir($this->paths['root_code']);
        $this->changeCacheDir($this->paths['root_cache']);
        if (isset_or($_REQUEST['__clear_cache'])) {
            $current_url = str_replace('?__clear_cache=1', '', $this->paths['current_full']);
            $current_url = str_replace('&__clear_cache=1', '', $current_url);
            $this->cache_hash = base64_encode($current_url);
            $this->no_cache = true;
            TemplatesManager::clear_cache($this->cache_hash);
        }
    }

    /**
     * Init DAL function
     */
    private function _initDal()
    {
        global $dal;
        if (!$this->admin) {
            $this->import('class', 'objects.Base');
        }

        // Data Access Layer
        $dal = new ModelsManager();
        $this->models = &$dal;
        $this->models->db = &$this->db_conn;
        $this->_dbConnect();
    }

    /**
     * Init module configuration file
     */
    private function _initModuleConfig()
    {

        // check and import module config.php file
        if (defined('MODULE_CONFIG_PATH')) {
            include MODULE_CONFIG_PATH . 'config.php';
        } else {
            $this->loadFile($this->paths['root_code'] . $this->module . 'config.php');
        }
        $this->_initDebug();
        if (!isset($this->db_connections) || !is_array($this->db_connections) || !count($this->db_connections)) {
            $this->db_conn_enabled = false;
        }
    }

    /**
     * Init debug settings
     */
    private function _initDebug()
    {
        ini_set('display_errors', $this->debug ? 1 : 0);
        error_reporting($this->debug ? E_ALL : 0);
    }

    /**
     * Check the requirements of the system if called
     */
    private function _initCheck()
    {
        if ($this->trace && $this->debug && $this->content == '_check') {
            InstallInfo::display();
            die;
        }
    }

    /**
     * Init image modifier
     */
    private function _initImageModifier()
    {
        if ($this->content == 'img_mod') {
            ini_set('memory_limit', '128M');
            $this->loadLibrary("images");
            $path = str_replace($this->paths['root'], $this->paths['dir'], $_REQUEST['_file']);

            // get cache path
            $img_cache = $this->paths['root_cache'] . 'img_mod/';
            if (!file_exists($img_cache)) {
                if (!mkdir($img_cache, 0777, true)) {
                    $this->logger->log('Cache_Write_Error', 'Can not create dir "' . $img_cache . '" to cache folder!');
                    return false;
                }
            }
            @chmod($img_cache, 0777);
            $cache_filename = $_REQUEST['name'];
            $cache_path = $img_cache . $cache_filename;
            ImageManager::get_resized_image_proportional($path, isset_or($_REQUEST['_width']), isset_or($_REQUEST['_height']), isset_or($_REQUEST['_fit']), $cache_path, false);

            if (isset_or($_REQUEST['_w'])) {
                ImageManager::apply_watermarked($cache_path, $_REQUEST['_w'], isset_or($_REQUEST['_w_left'], 'left'), isset_or($_REQUEST['_w_top'], 'top'));
            }
            header('Content-Disposition: inline; filename="' . $_REQUEST['name'] . '"');
            ImageManager::output($cache_path);
            die;
        }
        return null;
    }

    /**
     * Init migrations
     */
    private function _initMigrations()
    {
        if (isset($this->actions[0]) && $this->actions[0] == 'migrate') {
            $this->import('library', 'wbl_migrate');

            $manager = new MigrationsManager();
            $manager->system = &$this;
            if(!isset($this->actions[2])) {
                $manager->run(isset_or($this->actions[1], 'up'));
            }
            else{
                $manager->run_migration($this->actions[3],$this->actions[2],$this->actions[1]);
            }
            die;
        }
    }

    /**
     * Init minify script
     */
    private function _initMinify()
    {
        if ($this->content == 'min') {
            header('Expires: Thu, 4 Oct 2014 20:00:00 GMT');
            $this->import('library', 'min');
            die;
        }
    }

    /**
     * Init redirects
     */
    private function _initRedirects()
    {
        foreach ($this->redirects as $k => $v) {
            if ($k . '/' == $this->query || $k == $this->query) {
                $this->redirect(str_replace('//', $this->paths['root'], $v));
            }
        }
    }

    /**
     * Init page title
     */
    private function _initTitle()
    {
        if (!$this->ajax) {
            $this->title = isset($this->settings[$this->title_setting]) ? $this->settings[$this->title_setting]['value'] : $this->title;
        }
    }

    /**
     * Init uploads manager
     */
    private function _initUploads()
    {
        $this->files_manager = new FilesManager($this->files_folder, $this->paths['root'], $this->paths['root_dir']);
        $this->uploads = &$this->files_manager;
    }

    /**
     * Init downloads manager
     */
    private function _initDownloads()
    {
        $this->downloads = new DownloadManager();
    }

    /**
     * Init messages function
     */
    private function _initMessages()
    {
        $this->messages = isset($this->session['messages']) ? $this->session['messages'] : '';
    }

    /**
     * Init system paths
     */
    private function _initPaths()
    {
        $this_address = ($this->ssl ? 'https://' : 'http://') . isset_or($_SERVER['HTTP_HOST'], 'localhost');
        $application_name = dirname(isset_or($_SERVER['SCRIPT_NAME']));
        $this->paths['root'] = $this->console ? $this->console_baseurl : $this_address . (strlen($application_name) <= 1 ? '' : $application_name) . '/';
        $this->assets_server_path = $this->assets_server_path ? $this->assets_server_path : $this->paths['root'] . 'assets/';
        $this->paths['root_styles'] = $this->assets_server_path . 'styles/';
        $this->paths['root_images'] = $this->assets_server_path . 'images/';
        $this->paths['root_scripts'] = $this->assets_server_path . 'scripts/';
        $this->paths['root_objects'] = $this->paths['root'] . $this->objects_folder;
        $this->paths['dir'] = dirname(isset_or($_SERVER['SCRIPT_FILENAME'])) . DS;
        if ($this->console) {
            $included = get_included_files();
            $this->paths['dir'] = dirname($included[0]) . DS;
        }
        $this->paths['root_dir'] = $this->paths['dir'];
        $this->paths['root_code'] = $this->paths['dir'] . $this->modules_folder . DS;
        $this->paths['root_cache'] = $this->paths['dir'] . $this->cache_folder . DS;
        $this->paths['root_objects_inc'] = $this->paths['dir'] . $this->objects_folder . DS;

        $this->error_log_path = $this->paths['root_dir'];

        // set actions
        if (isset($_REQUEST['a'])) {
            $action = $_REQUEST['a'];
            $actions = explode(':', $action);
            $this->actions = $actions;
            $this->actions['all'] = $action;
        } elseif ($this->console) {
            $url = parse_url($this->query);
            parse_str(isset_or($url['query']));
            $action = isset_or($a);
            $actions = explode(':', $action);
            $this->actions = $actions;
            $this->actions['all'] = $action;
        }

        // @var string
        $q = isset($_REQUEST['q']) ? $_REQUEST['q'] : $this->query;
        if (php_sapi_name() == 'cli-server') {
            $q = ltrim(str_replace($application_name, '', $_SERVER["REQUEST_URI"]), '/');
            $url = parse_url($q);
            $q = $url['path'];
        }
        if ($this->console) {
            $url = parse_url($this->query);
            $q = $url['path'];
        }
        // set response type
        if (isset($_REQUEST['response']) && in_array(strtolower($_REQUEST['response']), $this->response_types)) {
            $this->response_type = strtolower($_REQUEST['response']);
        } elseif (in_array(strtolower(pathinfo($q, PATHINFO_EXTENSION)), $this->response_types)) {
            $this->response_type = strtolower(pathinfo($q, PATHINFO_EXTENSION));
            $q = substr($q, 0, strlen($q) - strlen($this->response_type) - 1);
        }
        $this->set_query($q);

        if (is_dir($this->subquery[0])) {
            die('Module not found!');
        }

        // component
        if (isset($this->subquery[2])) {
            $this->component = $this->subquery[2];
        }

        // sub component
        if (isset($this->subquery[3])) {
            $this->subcomponent = $this->subquery[3];
        }

        // components
        for ($i = 1; $i < count($this->subquery); $i++) {
            if ($this->subquery[$i]) {
                $this->components[] = $this->subquery[$i];
            }
        }
        if (!isset($this->components[0])) {
            $this->components[0] = 'home';
        }

        // sub query init
        $this->subquery[0] = $this->module;
        $this->subquery[1] = $this->content;

        // page sub paths
        $spath = $this->paths['root'];
        foreach ($this->subquery as $k => $v) {
            if ($v) {
                if ($k > 1) {
                    $spath .= '/' . $v;
                } else {
                    $spath .= $v;
                }
                $this->paths['sub_paths'][$k] = $spath;
                if ($this->paths['sub_paths'][$k][strlen($this->paths['sub_paths'][$k]) - 1] != '/') {
                    $this->paths['sub_paths'][$k] .= '/';
                }
            }
        }

        // current link
        $this->paths['current'] = isset_or($this->paths['sub_paths'][count($this->paths['sub_paths']) - 1]);

        $this->paths['current_full'] = page_url();
        $this->cache_hash = base64_encode($this->paths['current_full']);
        $this->_initCache();

        $this->paths['root_module'] = isset_or($this->paths['sub_paths'][0]);
        $this->paths['root_content'] = $this->paths['sub_paths'][1];
        if (isset($this->paths['sub_paths'][2])) {
            $this->paths['root_component'] = $this->paths['sub_paths'][2];
        }
        if (isset($this->paths['sub_paths'][3])) {
            $this->paths['root_subcomponent'] = $this->paths['sub_paths'][3];
        }

        $this->_initSkin();
        $this->render_all = !$this->ajax;
        $this->render_type = $this->_getRenderType();

        if ($this->admin) {
            $this->import('library', 'wbl_admin');
        }
    }

    /**
     * Init system cache
     */
    private function _initCache()
    {
        $this->no_cache = !$this->live;
        if (isset_or($_REQUEST['__nocache'])) {
            $this->page_cache_enabled = false;
            $this->no_cache = true;
        }
        if ($this->cache_enabled) {
            $this->import('library', 'stash');
            if (!$this->cache_options) {
                $this->cache_options = array('short' => array(
                    'type' => 'file',
                    'default' => true,
                    'options' => array('path' => $this->paths['root_cache'] . '_system/')
                ));
            }
            $this->cache = new CacheManager($this->cache_options);
        }
    }

    /**
     * Init skin
     */
    private function _initSkin()
    {

        // set skins folders
        if ($this->module != '') {
            $skin_path = ($this->skin_server_path) ? $this->skin_server_path : $this->paths['root'] . $this->skins_folder;
            if (file_exists($this->paths['root_dir'] . $this->skins_folder . $this->skin . '/')) {
                $this->addPath('skin_images', $skin_path . $this->skin . '/' . $this->module . 'images/');
                $this->addPath('skin_scripts', $skin_path . $this->skin . '/' . $this->module . 'scripts/');
                $this->addPath('skin_styles', $skin_path . $this->skin . '/' . $this->module . 'styles/');
            } else {
                $this->addPath('skin_images', $skin_path . $this->default_skin . '/' . $this->module . 'images/');
                $this->addPath('skin_scripts', $skin_path . $this->default_skin . '/' . $this->module . 'scripts/');
                $this->addPath('skin_styles', $skin_path . $this->default_skin . '/' . $this->module . 'styles/');
            }
        } else {
            $this->addPath('skin_images', $this->paths['root_images']);
            $this->addPath('skin_scripts', $this->paths['root_scripts']);
            $this->addPath('skin_styles', $this->paths['root_styles']);
        }
    }

    /**
     * Get page settings from db
     */
    private function _initPageSettings()
    {
        if ($this->seo_enabled && !$this->ajax && $this->db_conn) {
            $pagepath = $this->paths['current_full'];
            $model = $this->libraries_settings['wbl_seo']['links_table'];
            $query=new QueryBuilder($model);
            $pg = $query->select()->where('page="' . $pagepath . '"')->first();
            if ($pg) {
                $params = array();
                $pg['views']++;
                $params['views'] = $pg['views'];

                $query=new QueryBuilder($model);
                $query->update($params)->where('id=' . $pg['id'])->execute();
            } else {
                $params = array();
                $params['page'] = $pagepath;
                $params['views'] = 1;
                $params['active'] = 1;
                $params['title'] = $this->title;
                $params['keywords'] = $this->getMetaTag('keywords') ? $this->getMetaTag('keywords') : '';
                $params['description'] = $this->getMetaTag('description') ? $this->getMetaTag('description') : '';

                $query=new QueryBuilder($model);
                $id = $query->insert($params)->execute();
                $pg = $params;
                $pg['id'] = $id;
            }
            $this->page = $pg;

            // apply settings
            $this->title = str_replace('%title%', $this->title, $this->page['title']);
            $this->setMetaTag('keywords', $this->getMetaTag('keywords') ? str_replace('%main%', $this->getMetaTag('keywords'), $this->page['keywords']) : $this->page['keywords']);
            $this->setMetaTag('description', $this->getMetaTag('description') ? str_replace('%main%', $this->getMetaTag('description'), $this->page['description']) : $this->page['description']);
        }
    }

    /**
     * Save the page settings if not saved
     */
    private function _savePageSettings()
    {
        if ($this->seo_enabled && $this->db_conn_enabled && !$this->ajax) {
            $pagepath = $this->paths['current_full'];
            $model = $this->libraries_settings['wbl_seo']['links_table'];
            $pg = $this->models->{$model}->get_cond('page="' . $pagepath . '"');
            if ($pg) {
                $params = array();
                $pg['views']++;
                $params['views'] = $pg['views'];
                $this->models->{$model}->update($params, 'id=' . $pg['id']);
            } else {
                $params = array();
                $params['page'] = $this->paths['current_full'];
                $params['views'] = 1;
                $params['active'] = 1;
                $params['title'] = $this->title;
                $params['keywords'] = $this->getMetaTag('keywords') ? $this->getMetaTag('keywords') : '';
                $params['description'] = $this->getMetaTag('description') ? $this->getMetaTag('description') : '';

                $this->models->{$model}->insert($params);
            }

            if ($this->libraries_settings['wbl_seo']['trackings_enabled']) {
                $params = array();
                $params['url'] = $pagepath;
                $params['datetime'] = nowfull();
                if (($this->libraries_settings['wbl_seo']['trackings_mode'] == 'all' || $this->libraries_settings['wbl_seo']['trackings_mode'] == 'robot') && $this->browser['type'] == 'robot') {
                    $params['crawler'] = $this->browser['browser'];
                }
                if (($this->libraries_settings['wbl_seo']['trackings_mode'] == 'all' || $this->libraries_settings['wbl_seo']['trackings_mode'] == 'browser') && $this->browser['type'] == 'browser') {
                    $params['browser'] = $this->browser['browser'];
                    $params['referer_url'] = isset_or($_SERVER["HTTP_REFERER"]);
                    $params['client_ip'] = $this->browser_ip;
                    $params['session_hash'] = session_id();
                }
                $this->models->{$this->libraries_settings['wbl_seo']['trackings_table']}->insert($params);
            }
        }
    }

    /**
     * Init validation PHP/Javascript
     */
    private function _initValidation()
    {
        $this->validate = new FormsManager();
        $this->validate->init();
    }

    /**
     * Display js generated script
     */
    private function _initJsScript()
    {
        if (strpos($this->subquery[1], 'script_file_') !== false) {
            header('Content-Type: application/javascript');
            header('Expires: Thu, 4 Oct 2014 20:00:00 GMT');
            header('Cache-Control: public, max-age=31536000');
            header('Last-Modified: ' . date('D, j M Y G:i:s T'));

            echo @$this->session['script'];
            unset($this->session['script']);
            @$this->saveSession();
            die();
        }

        // scripts manager
        $this->scripts = new ScriptManager();
    }

    /**
     * Get meta tags from db
     */
    private function _initMetas()
    {
        if (!$this->ajax && $this->seo_enabled && $this->db_conn) {
            $query = new QueryBuilder($this->libraries_settings['wbl_seo']['metas_table']);
            $query->select(array('name','content'))->where('is_active=1');
            $metas = $query->execute();
            foreach ($metas as $v) {
                $this->setMetaTag($v['name'], $v['content']);
            }
        }
    }

    /**
     * Get settings from the database table 'settings'
     */
    private function _initSettings()
    {
        if ($this->settings_enabled && isset($this->db_conn->tables[$this->settings_table])) {
            $query = new QueryBuilder($this->db_conn->tables[$this->settings_table]);
            $arr = $query->select()->execute();
            $return = array();
            foreach ($arr as $k => $v) {
                if ($v['type'] == "id") {
                    $query = "select `" . $v['from_field'] . "` from `" . $v['from_table'] . "` where id=" . $v['value'];
                    $return[$v['name']] = array(
                        "value" => $this->db_conn->getOne($query),
                        "id" => $v['value']
                    );
                } else {
                    $return[$v['name']] = array("value" => $v['value']);
                }
            }
            $this->settings = $return;
        }
    }

    /**
     * Generates a init_signature image
     */
    private function _initSignature()
    {
        if (isset($this->actions[0]) && $this->actions[0] == 'signature_reset') {
            unset($this->session['signature']);
            $this->actions[0] = 'signature';
        }
        if (isset($this->actions[0]) && $this->actions[0] == 'signature') {
            $obj = new SignatureManager($this->session);
            $obj->display(5, dirname(__FILE__) . '/font.ttf');
            $this->saveSession();
            die;
        }
    }

    /**
     * Secures data transferred from the client
     */
    private function _initSecurity()
    {
        if ($this->secure_request_enabled) {
            $this->import('library', 'ids');
        }
    }

    /**
     * Init history array
     */
    private function _initHistoy()
    {
        if ($this->history_active) {
            $history = new HistoryManager($this->session, $this->ajax ? '' : $this->paths['current_full']);
            $this->history = $history->get_history();
        }
    }

    /**
     * Init current language
     */
    private function _initLanguage()
    {
        if ($this->multi_language) {
            if (!isset($this->session['language_id'])) {
                if ($this->admin) {
                    if (isset($this->settings['admin_default_language']['id'])) {
                        $this->session['language_id'] = $this->settings['admin_default_language']['id'];
                    } else {
                        $this->logger->log('settings_error', 'Setting field "admin_default_language" not found!');
                    }
                } else {
                    if (isset($this->settings['default_language_id']['id'])) {
                        $this->session['language_id'] = $this->settings['default_language_id']['id'];
                    } else {
                        $this->logger->log('settings_error', 'Setting field "default_language_id" not found!');
                    }
                }
            }

            // check if language change requested
            if (isset($_REQUEST['language'])) {
                $this->session['language_id'] = $_REQUEST['language'];
                $this->redirect($this->paths['current']);
            }

            // set locale

            $query=new QueryBuilder($this->libraries_settings['wbl_locale']['table']);
            $language = $query->select()->where('id=' . $this->session['language_id'])->first();
            if (isset($this->browser['os']) && strtolower($this->browser['os']) == 'windows' && isset_or($language['locale_win']))
                $locale = $language['locale_win'];
            elseif (isset_or($language['locale_linux']))
                $locale = $language['locale_linux'];
            else
                $locale = $this->libraries_settings['wbl_locale']['default'];
            $domain = 'messages';
            putenv('LANG=' . $locale);
            setlocale(LC_ALL, $locale);
            if (!function_exists("gettext")){
                $this->import('library','gettext');
                T_setlocale(LC_ALL, $locale);
            }
            textdomain($domain);
            bindtextdomain($domain, $this->paths['root_dir'] . 'Locale');
            bind_textdomain_codeset($domain, 'UTF-8');
        }
    }

    /**
     * Init pagination information
     */
    private function _initPagination()
    {
        if ($this->pagination_enabled) {
            $p = isset($_REQUEST['p']) ? $_REQUEST['p'] : 1;
            $this->page_no = $p;

            $this->page_offset = isset($this->pagination[0]) ? $this->pagination[0] : 10;

            // calculate page skip
            if ($this->page_no > 1) {
                $this->page_skip = ($this->page_no - 1) * $this->page_offset;
            }
        }
    }

    /**
     * Get meta tag by name
     *
     * @param string $name Name of the meta
     *
     * @return string
     */
    public function getMetaTag($name)
    {
        return isset($this->meta_tags[$name]) ? $this->meta_tags[$name]['content'] : '';
    }

    /**
     * Set meta tag by name and value
     *
     * @param string $name name of the meta
     * @param string $content content of the meta
     */
    public function setMetaTag($name, $content)
    {
        if (isset($this->meta_tags[$name])) {
            $this->meta_tags[$name]['content'] = $content;
        } else {
            $this->meta_tags[$name] = array(
                'name' => $name,
                'content' => $content
            );
        }
    }

    /**
     * Add js file to be loaded
     *
     * @param string $file File path
     * @param bool $local If it is local
     * @param string $type Type of the file
     *
     *
     */
    public function addJsFile($file, $local = true, $type = 'text/javascript')
    {
        $file = str_replace(isset_or($this->paths['skin_scripts']), '{$skin_scripts}', $file);
        $file = str_replace(isset_or($this->paths['root_scripts']), '{$root_scripts}', $file);
        $this->js_files[$file] = array(
            'src' => $file,
            'local' => $local,
            'type' => $type
        );
    }

    /**
     * Save in session the current js files
     *
     *
     */
    public function saveJsFiles()
    {
        $this->session['__js_files'] = array();
        $js_files = $this->js_files;

        $this->js_files = array();
        $group = 0;
        $module = str_replace('/', '', $this->module);
        foreach ($js_files as $k => $v) {
            if (isset_or($v['src'])) {
                if ($v['local']) {
                    $this->session['__js_files'][$group][] = str_replace('{$skin_scripts}', '//' . $this->skins_folder . $this->skin . '/' . $this->module . 'scripts/', str_replace('{$root_scripts}', '//assets/scripts/', $v['src']));
                    $this->addJsFile($this->paths['root'] . 'min/?g=js_site' . $group . '&module=' . $module . '&ck=' . $this->session_cookie . '&skin=' . $this->skin, false);
                } else {
                    $this->addJsFile($v['src'], false, $v['type']);
                    $group++;
                }
            }
        }

        $this->saveSession();
        $this->assign('p', $this->getPage());
    }

    /**
     * Add css file to be loaded
     *
     * @param string $file File path
     * @param string $type File type
     * @param string $media Media
     * @param string $browser_cond Browser condition
     *
     *
     */
    public function addCssFile($file, $type = 'text/css', $media = 'screen, projection', $browser_cond = '')
    {
        $this->css_files[$file] = array(
            'href' => $file,
            'type' => $type,
            'media' => $media,
            'browser_cond' => $browser_cond
        );
    }

    /**
     * System render
     *
     *
     */
    public function render()
    {
        $this->memory->save('system_before_render');
        $this->hocks->before_render();

        // load scripts
        $this->time->start('render_scripts');
        $this->_renderScripts();
        $this->time->end('render_scripts');

        // load variables
        $this->_renderVariables();

        // load templates
        $this->time->start('render_templates');
        $this->_renderTemplate();
        $this->hocks->after_render();

        // save page settings
        $this->_savePageSettings();

        // save session
        $this->saveSession();
    }

    /**
     * Change smarty cache dir
     *
     * @param string $dir Directory path
     *
     * @return bool
     */
    public function changeCacheDir($dir)
    {
        if (!file_exists($dir)) {
            if (!mkdir($dir, 0777, true)) {
                $this->logger->log('Cache_Write_Error', 'Can not create dir "' . $dir . '" to cache folder!');
                return false;
            }
            @chmod($dir, 0777);
        }
        TemplatesManager::set_compile_dir($dir);
        return true;
    }

    /**
     * Clear all cache for a given url
     *
     * @param string $url Url
     *
     *
     */
    public function clearCache($url = '')
    {
        if (!$url) {
            $url = $this->paths['current_full'];
        }
        if (class_exists('TemplatesManager')) {
            TemplatesManager::clear_cache(base64_encode($url));
        }
    }

    /**
     * Change smarty template dir
     *
     * @param string $dir Directory path
     *
     *
     */
    public function changeTemplateDir($dir)
    {
        TemplatesManager::set_template_dir($dir);
        if (!file_exists(TemplatesManager::get_template_dir())) {
            $this->logger->log('Templates_Error', 'Can not find templates directory "' . $dir . '"!');
        }
    }

    /**
     * Fetch template file into variable
     *
     * @param string $name Variable name
     * @param string $file File path
     * @param string $cache_folder Cache folder
     * @param bool $return Return template
     *
     * @return mixed
     */
    public function fetchTemplate($name, $file, $cache_folder, $return = false)
    {
        $this->changeCacheDir($cache_folder);
        if ($this->template->template_exists($file)) {
            try {
                if ($return) {
                    return $this->template->fetch($file, $this->cache_hash);
                } else {
                    $this->assign($name, $this->template->fetch($file, $this->cache_hash));
                }
            } catch (Exception $ex) {
                System::triggerError('Template Exception: ' . $ex->getMessage());
                return false;
            }
        } else {
            $this->logger->log('Templates_Error', 'Can not fetch template "' . $name . '" from file "' . $file . '"!');
            return false;
        }
        return true;
    }

    /**
     * Assign variable to template
     *
     * @param mixed $var Variable name
     * @param mixed $value Variable value
     *
     *
     */
    public function assign($var, $value = null)
    {
        if ($this->response_type == 'html') {
            $this->template->assign($var, $value);
        } elseif ($this->response_assign) {
            if (is_array($var)) {
                $this->response_data = array_merge($this->response_data, $var);
            } else {
                $this->response_data[$var] = $value;
            }
        }
    }

    /**
     * Render skin
     *
     *;
     */
    private function _renderSkin()
    {
        if ($this->response_type == 'html') {
            $this->_initSkin();

            // set skins folders
            $this->assign('skin_images', $this->paths['skin_images']);
            $this->assign('skin_scripts', $this->paths['skin_scripts']);
            $this->assign('skin_styles', $this->paths['skin_styles']);
        }
    }

    /**
     * Render all templates
     *
     *
     */
    private function _renderTemplate()
    {
        $template_folder = $this->paths['root_dir'];
        $this->render_type = $this->_getRenderType();

        if ($this->live && $this->render_type == 'all') {
            $this->saveJsFiles();
        }
        if (!$this->no_cache && (TemplatesManager::is_cached($this->paths['root_dir'] . $this->layout.$this->template_extension , $this->cache_hash) || TemplatesManager::is_cached(__DIR__ . '/objects/system/' . $this->layout . $this->template_extension, $this->cache_hash))) {
            header('Content-Type: ' . $this->content_type);
            TemplatesManager::set_cache(true);
            if (is_file($template_folder . $this->layout . $this->template_extension)) {
                $this->template->display($template_folder . $this->layout.$this->template_extension, $this->cache_hash);
            } else {
                $this->template->display(__DIR__ . '/objects/system/' . $this->layout.$this->template_extension, $this->cache_hash);
            }
            die;
        }
        $cache_folder = $this->paths['root_cache'];
        if (!TemplatesManager::is_cached($template_folder . $this->layout.$this->template_extension, $this->cache_hash)) {
            $this->_renderSkin();

            // change smarty template dir for module
            $template_folder = $this->paths['root_code'] . $this->module . 'views/';
            if (file_exists($this->paths['root_code'] . $this->module . 'views/' . $this->skin . '/')) {
                $template_folder = $this->paths['root_code'] . $this->module . 'views/' . $this->skin . '/';
            } elseif (file_exists($this->paths['root_code'] . $this->module . 'views/' . $this->default_skin . '/')) {
                $template_folder = $this->paths['root_code'] . $this->module . 'views/' . $this->default_skin . '/';
            }

            $cache_folder = $this->paths['root_cache'] . $this->module . 'views' . DS . $this->skin . DS;

            if (is_file($template_folder . 'noscript.tpl')) {
                $this->fetchTemplate('__noscript', $template_folder . 'noscript.tpl', $cache_folder);
            }
            if ($this->ajax && $this->obj_index->view != 'index' && count($this->components)<=1) {
                $this->render_type = 'page';
            }
            if (is_a($this->obj_index, "Page")) {
                $this->obj_index->_render_template($this->render_type);
            } elseif (!$this->live && $this->build_enabled && isset($this->actions[0]) && $this->actions[0] == 'build-module') {
                $build = new BuildManager($this->uploads);
                if (!$build->add_module($this->paths['root_code'] . $this->module)) {
                    foreach ($build->errors as $e) {
                        $this->logger->log('builder_error', $e);
                    }
                }
                $this->redirect($this->paths['current']);
            } else {
                System::triggerError('No class named PageIndex extending Page provided in "index.php" file provided for module ' . $this->module);
            }

            // change smarty template and cache dir for main index
            $template_folder = $this->paths['root_dir'];
            $cache_folder = $this->paths['root_cache'] . '_index/';

            if ($this->trace) {
                TraceManager::generate(0);
                $this->assign('page_trace', $this->trace_page);
            }

            // set title
            $this->assign('title', $this->title);
            $this->assign('render_type', $this->render_type);

            $this->assign('p', $this->getPage());
        }
        if (!headers_sent()) {
            header('Content-Type: ' . $this->content_type);
        }
        $this->changeCacheDir($cache_folder);
        try {
            if (is_file($template_folder . $this->layout .  $this->template_extension)) {
                $this->template->display($template_folder . $this->layout.$this->template_extension, $this->cache_hash);
            } else {
                $this->template->display(__DIR__ . '/templates/system/' . $this->layout.$this->template_extension, $this->cache_hash);
            }
            $this->time->end('system');
            $this->time->end('render_templates');
            $this->memory->save('system_after_render');
            if ($this->trace) {
                TraceManager::generate();
            }
        } catch (Exception $ex) {
            System::triggerError('Template Exception: ' . $ex->getMessage());
        }
    }

    /**
     * Get the render type
     *
     * @return string
     */
    private function _getRenderType()
    {

        // check render type
        if ($this->render_all) {
            return 'all';
        } else {

            // check if it was changed
            if ($this->render_type != 'all') {
                return $this->render_type;
            }
            if (!count($this->components)) {
                return 'page';
            } else {
                return 'page_component_' . (count($this->components) - 1);
            }
        }
    }

    /**
     * 404 Error
     */
    private function _404()
    {
        if ($this->enable_404) {
            $this->_initSystemError('404', 'The page that you have requested could not be found.');
        }
        return '';
    }

    /**
     * Render scripts
     *
     *
     */
    private function _renderScripts()
    {

        if ($this->admin) {
            $this->import('library', 'wbl_admin');
        }
        if ($this->import('file', $this->paths['root_code'] . $this->module . 'index.php') && class_exists('PageIndex')) {
            $this->obj_index = new PageIndex('page', $this->paths['root_cache'] . $this->module, $this->paths['root_code'] . $this->module, 'index.php', 'index', $this->skin);
            $this->obj_index->subquery = $this->components;
        } else {
            if (!class_exists('PageIndex')) {
                $this->logger->log('OOP_Warning', 'No \'PageIndex\' class found for this module!');
            } else {
                $this->_404();
            }
        }

        // check if validation is called
        if (isset($this->actions[0]) && $this->actions[0] == 'validate') {
            die($this->validate->validate($_POST['rule'], $_POST['value']) ? '1' : '0');
        }
        try {

            // init index
            if (isset($this->obj_index)) {
                $this->obj_index->_init();
            }

            // render index
            if (!$this->restricted && isset($this->obj_index)) {
                $this->obj_index->_render();
            }
        } catch (Exception $ex) {
            System::triggerError('Exception: ' . $ex->getMessage());
        }

        // get database pages number if required
        if ($this->no_pages == 0 && $this->no_total_rows < 0) {
            $this->no_total_rows = (is_object($this->db_conn) ? $this->db_conn->countTotalRows() : $this->no_total_rows);
            if ($this->no_total_rows > $this->page_offset && $this->no_total_rows >= 0 && $this->page_offset) {
                $this->no_pages = (int)($this->no_total_rows / $this->page_offset) + (($this->no_total_rows % $this->page_offset > 0) ? 1 : 0);
            } else {
                $this->no_pages = 0;
            }
        } elseif ($this->no_pages == 0 && $this->no_total_rows != 0) {
            $this->no_pages = (int)($this->no_total_rows / $this->page_offset) + (($this->no_total_rows % $this->page_offset > 0) ? 1 : 0);
        }
        if ($this->ajax && SessionManager::is_new() && $this->check_login) {
            $this->redirect($this->paths['root_module']);
        }

        if ($this->response_type != 'html') {
            $this->getResponse();
        }

        // page object
        $this->assign('p', $this->getPage());
    }

    /**
     * Render objects
     *
     *
     */
    private function _initObjects()
    {

        // load objects
        if (file_exists($this->paths['root_objects_inc'])) {
            $files = scandir($this->paths['root_objects_inc']);
            foreach ($files as $k => $v) {
                if ($v != '.' && $v != '..' && $v != '') {
                    $this->objects[$v] = array();
                    $objs = scandir($this->paths['root_objects_inc'] . $v);
                    foreach ($objs as $l => $o) {
                        if ($o != '.' && $o != '..' && $o != '' && is_file($this->paths['root_objects_inc'] . $v . '/' . $o . '/include.tpl')) {
                            $this->objects[$v][$o] = $this->paths['root_objects_inc'] . $v . '/' . $o . '/include.tpl';
                        }
                    }
                }
            }
        }
    }

    /**
     * Get validation errors from session
     *
     *
     */
    private function _initErrors()
    {
        if (isset($this->session['errors']) && is_array($this->session['errors'])) {
            foreach ($this->session['errors'] as $e) {
                if (isset($e['field']) && isset($e['text'])) {
                    $this->errors[$e['field']] = $e['text'];
                }
            }
        }
    }

    /**
     * Initialize session
     *
     *
     */
    public function initSession()
    {

        // set cookie for module
        $this->session_cookie .= ('_' . ($this->session_cookie_module ? $this->session_cookie_module : str_replace('/', '', $this->module)));
        $this->hocks->before_session_init();

        SessionManager::init($this->session_cookie, $this->session_timeout);
        $this->session = &$_SESSION;

        $this->_initCheckCookies();

        if (isset($this->session['state'])) {
            $this->state = $this->session['state'];
        }
        $this->clearMessages();
        $this->clearErrors();
        $this->messages = isset($this->session['messages']) ? $this->session['messages'] : array();
        $this->hocks->after_session_init();
    }

    /**
     * Init check cookie if this is configured as enabled
     *
     *
     */
    private function _initCheckCookies()
    {
        if ($this->check_cookies) {
            if (isset($this->actions[0]) && $this->actions[0] == '__no_cookies') {
                $this->system_error = 'Please enable the cookies in your browser and then <a href="' . base64_decode($_REQUEST['page']) . '">click here</a> to go to the page you wanted to access.';
            } elseif (isset($this->actions[0]) && $this->actions[0] == '__check_cookies') {
                $this->cookies_enabled = $_SESSION['__check_cookies'] && $_SESSION['_hash'] = $_REQUEST['hash'];
                if ($this->cookies_enabled) {
                    $this->redirect(base64_decode($_REQUEST['page']));
                } else {
                    $this->redirect($this->paths['root_module'] . '?a=__no_cookies&page=' . $_REQUEST['page']);
                }
            } elseif (!isset($_SESSION['__check_cookies'])) {
                $_SESSION['__check_cookies'] = 1;
                $this->redirect($this->paths['root_module'] . '?a=__check_cookies&hash=' . $_SESSION['_hash'] . '&page=' . base64_encode($this->paths['current_full']));
            } else {
                $this->cookies_enabled = true;
            }
        }
    }

    /**
     * Public function to check if cookies are enable, user will be redirected to a
     * link to check if cookies are enabled
     *
     *
     */
    public function checkCookies()
    {
        $this->check_cookies = true;
        $this->_initCheckCookies();
    }

    /**
     * Render template variables
     *
     *
     */
    private function _renderVariables()
    {
        if ($this->response_type == 'html') {
            $this->assign('random', md5(time() . rand()));
            $this->assign('session', $this->session);
            $this->assign('ssl', $this->ssl);
            $this->assign('root', $this->paths['root']);
            $this->assign('current', $this->paths['current']);
            $this->assign('root_images', $this->paths['root_images']);
            $this->assign('root_styles', $this->paths['root_styles']);
            $this->assign('root_scripts', $this->paths['root_scripts']);
            $this->assign('root_module', $this->paths['root_module']);
            $this->assign('root_content', $this->paths['root_content']);
            $this->assign('root_component', isset_or($this->paths['root_component']));
            $this->assign('root_subcomponent', isset_or($this->paths['root_subcomponent']));

            // user logged
            $this->assign('logged', $this->logged);

            // date
            $this->assign('date', @getdate());

            // actions
            $this->assign('actions', $this->actions);

            // errors
            $this->assign('errors', $this->errors);

            // history
            $this->assign('history', $this->history);

            // query
            $this->assign('query', $this->query);

            // module
            $this->assign('module', $this->module);

            // messages
            $this->assign('messages', $this->messages);

            // set skins folders
            $this->assign('skin_images', $this->paths['skin_images']);
            $this->assign('skin_scripts', $this->paths['skin_scripts']);
            $this->assign('skin_styles', $this->paths['skin_styles']);

            $before_skin = '<link rel="icon" ' . 'href="{$root_images}favicon.ico" type="image/x-icon"/>
<link rel="shortcut icon" href="{$root_images}favicon.ico" type="image/x-icon"/>
<script type="text/javascript">
    var root="{$root}";
    var root_current="{$current}";
</script>';
            $this->assign('__before_skin', $before_skin);
        }
    }

    /**
     * Get db tables
     *
     *
     */
    private function _dbConnect()
    {
        if (isset($this->db_connections[0])) {
            $this->addTables();
            $this->db_conn = new DbManager($this->tables);
            $this->db_conn->trace = $this->trace;
            $this->db_conn_enabled = $this->db_conn->connect($this->db_connections[0]['host'], $this->db_connections[0]['user'], $this->db_connections[0]['password'], $this->db_connections[0]['dbname'], isset_or($this->db_connections[0]['type'], 'mysql'));
            if (!$this->db_conn_enabled) {
                unset($this->db_conn);
            }
        }
    }

    /**
     * Set the moduel user type for authentication purpose
     *
     * @param string $type User type
     *
     *
     */
    public function setModuleUserType($type)
    {
        $this->module_user_type = $type;

        // check user
        if ($this->module_user_type && isset($this->session['user_type']) && $this->session['user_type'] != '' && $this->session['user_type'] != $this->module_user_type) {
            $this->logout();
        }
    }

    /**
     * Add a system message
     *
     * @param object $type Message type
     * @param object $text Message text
     *
     *
     */
    public function addMessage($type, $text)
    {
        if (@!is_array(@$this->session['messages'])) {
            $this->session['messages'] = array();
        }
        $this->session['messages'][] = array(
            'type' => $type,
            'text' => $text,
            'showed' => 0
        );
        $this->saveSession();
        $this->messages = $this->session['messages'];
    }

    /**
     * Add a input validation error
     *
     * @param string $field Name of the input
     * @param string $text Text
     *
     *
     */
    public function addError($field, $text)
    {
        if (!isset($this->session['errors']) || !is_array($this->session['errors'])) {
            $this->session['errors'] = array();
        }
        $this->session['errors'][] = array(
            'field' => $field,
            'text' => $text,
            'showed' => 0
        );
        $this->errors[$field] = $text;
        $this->valid = false;
    }

    /**
     * Parse query 'q' url rewrite
     *
     * @param string $query Query string
     *
     *
     */
    public function set_query($query)
    {
        $this->query = $query;
        $pages = explode('/', $query);
        $module = trim($pages[0]);
        if (($module != '' && is_dir($this->paths['root_code'] . $module)) || (!$this->live && $this->build_enabled && isset_or($_REQUEST['a']) == 'build-module')) {
            $module .= '/';
        } elseif ($this->admin_enabled && $module == 'admin') {
            $this->admin = true;
            $module .= DS;
        } elseif ($module == '') {
            $module = $this->default_module;
        } elseif (($module != '' && is_dir($this->paths['root_code'] . $this->default_module . 'components/' . $module . '/'))) {
            $module = $this->default_module;
            array_unshift($pages, str_replace('/', '', $this->default_module));
        } else {
            if (in_array($module,$this->system_modules)) {
                $pages[1] = $module;
                if (isset($_REQUEST['module'])) {
                    $pages[0] = $_REQUEST['module'];
                    $module = $pages[0] . '/';
                }
            } else {
                $module = $this->default_module;
                array_unshift($pages, str_replace('/', '', $this->default_module));
            }
        }
        $this->module = $module;
        if (isset_or($pages[1])) {
            $this->content = $pages[1];
        }
        $this->subquery = $pages;
    }

    /**
     * Add system meta tag
     *
     * @param string $name Tag name
     * @param string $content Tag content
     *
     *
     */
    public function addMetaTag($name, $content)
    {
        $this->meta_tags[$name] = array(
            'name' => $name,
            'content' => $content
        );
    }

    /**
     * Add system path
     *
     * @param string $name Name of the path
     * @param string $value Value
     *
     *
     */
    public function addPath($name, $value)
    {
        $this->paths[$name] = $value;
    }

    /**
     * Save current session
     *
     *
     */
    public function saveSession()
    {
        $_SESSION = $this->session;
    }

    /**
     * Save current system state
     *
     *
     */
    public function saveState()
    {
        if (isset($this->history[0])) {
            $this->session['state_link'] = $this->history[0];
        } else {
            $this->session['state_link'] = $this->paths['current_full'];
        }

        $this->session['state'] = $_REQUEST;
        $this->saveSession();
    }

    /**
     * Init current system state
     *
     *
     */
    private function _initState()
    {
        if (isset($this->session['state_link']) && $this->session['state_link'] != $this->paths['current_full']) {
            $this->session['state'] = '';
            $this->session['state_link'] = '';
            $this->saveSession();
        }
    }

    /**
     * Authenticate user if required
     *
     *
     */
    private function _initAuthentication()
    {
        if (isset($this->actions[0])) {
            switch ($this->actions[0]) {
                case 'login' :
                    $this->login();
                    break;

                case 'logout' :
                    $this->logout();
                    break;
            }
        } else {
            $this->updateVisitLog();
        }
    }

    /**
     * Get current logged user
     *
     *
     */
    private function _initUser()
    {
        if (count($this->user_types_tables) && $this->module_user_type) {
            $this->_initAuthenticate();
            $this->authenticate->init_user();
        }
    }

    /**
     * Clear system messages
     *
     *
     */
    public function clearMessages()
    {
        if (isset($this->session['messages'])) {
            foreach ($this->session['messages'] as $k => $v) {
                if ($v['showed'] >= 1) {
                    array_splice($this->session['messages'], $k, 1);
                } elseif (isset($this->session['messages'][$k]['showed'])) {
                    $this->session['messages'][$k]['showed']++;
                }
            }
        }
    }

    /**
     * Clear system errors
     *
     *
     */
    public function clearErrors()
    {
        if (isset($this->session['errors'])) {
            foreach ($this->session['errors'] as $k => $v) {
                if ($v['showed'] >= 1) {
                    array_splice($this->session['errors'], $k, 1);
                } elseif (isset($this->session['errors'][$k]['showed'])) {
                    $this->session['errors'][$k]['showed']++;
                }
            }
            $this->_initErrors();
        }
    }

    /**
     * Log out current user
     *
     * @param string $goto Url for redirect
     *
     *
     */
    function logout($goto = '')
    {
        $this->_initAuthenticate();
        $this->hocks->before_logout();
        $this->authenticate->logout($goto);
        $this->hocks->after_logout();
    }

    /**
     * Update visit log in db
     *
     *
     */
    public function updateVisitLog()
    {
        $this->_initAuthenticate();
        $this->authenticate->update_visit_log();
    }

    /**
     * Init authentication
     *
     *
     */
    private function _initAuthenticate()
    {
        if (!isset($this->authenticate)) {
            $this->authenticate = new AuthenticationManager();
        }
        $this->authenticate->settings = $this->user_types_tables;
        $this->authenticate->messages = $this->login_messages;
        $this->authenticate->show_messages = $this->show_login_messages;
        $this->authenticate->logins_logs_enabled = $this->logins_logs_enabled;
        $this->authenticate->logins_logs_model = $this->logins_logs_table;
        $this->authenticate->module_user_type = $this->module_user_type;
    }

    /**
     * Login request
     *
     *
     */
    public function login()
    {
        $this->_initAuthenticate();
        $this->hocks->before_login();
        $this->authenticate->login();
        $this->hocks->after_login();
    }

    /**
     * Validate a form
     *
     * @param string $form_id Form ID
     *
     *
     */
    public function validateForm($form_id)
    {
        if (isset($this->validate[$form_id]) && !$this->validate[$form_id]->validate()) {
            $errors = $this->validate[$form_id]->get_errors();
            foreach ($errors as $f => $e) {
                $this->addError($f, $e);
            }
            $this->saveSession();
        }
    }

    /**
     * Add form validator
     *
     * @param object $form_id Form ID
     * @param object $field Input name
     * @param object $rule Validation rule
     * @param string $message [optional] Message
     * @param bool $client Client execution
     * @param bool $server Server execution
     *
     *
     */
    public function addValidator($form_id, $field, $rule, $message = '', $client = false, $server = true)
    {
        if ($server) {
            $hash = $this->validate->get_form_hash($form_id);
            if (!isset($this->session['validation'])) {
                $this->session['validation'] = array();
            }
            if (!isset($this->session['validation'][$hash])) {
                $this->session['validation'][$hash] = array(
                    'form_id' => $form_id,
                    'fields' => array()
                );
            }
            $this->session['validation'][$hash]['fields'][$field]['rules'][$rule] = $message;
            $this->validate->add_rule($form_id, $field, $rule, $message);
        }
        if ($client) {
            $this->scripts->add_validator($form_id, $field, $rule, $message);
        }
        $this->saveSession();
    }

    /**
     * Add form filter
     *
     * @param object $form_id Form ID
     * @param object $field Input name
     * @param object $filter Filter
     * @param mixed $params Parameters
     * @param bool $client Client execution
     * @param bool $server Server execution
     *
     *
     */
    public function addFilter($form_id, $field, $filter, $params = '', $client = false, $server = true)
    {
        if ($server) {
            $hash = $this->validate->get_form_hash($form_id);
            if (!isset($this->session['validation'])) {
                $this->session['validation'] = array();
            }
            if (!isset($this->session['validation'][$hash])) {
                $this->session['validation'][$hash] = array(
                    'form_id' => $form_id,
                    'fields' => array()
                );
            }
            $this->session['validation'][$hash]['fields'][$field]['filters'][$filter] = $params;
            $this->validate->add_filter($form_id, $field, $filter, $params);
        }
        if ($client) {

            // no client filters yet
            // $this -> scripts -> add_validator($form_id, $field, $rule, $message);

        }
        $this->saveSession();
    }

    /**
     * Redirect system to anothe url
     *
     * @param string $url [optional] Url
     *
     *
     */
    function redirect($url = '')
    {
        $this->clearCache($url);
        if (!$this->ajax) {
            $this->saveState();
        }
        if ($this->trace) {
            $this->time->end('render_scripts');
            $this->time->end('render_templates');
            $this->time->end('system');
            TraceManager::generate();
        }
        if ($url) {
            if (headers_sent() || $this->ajax) {
                echo '<script type="text/javascript">location.href="' . $url . '";</script>';
            } else {
                ob_start();
                header('Location: ' . $url);
                ob_end_flush();
            }
        } else {
            $this->redirect($this->paths['current_full']);
        }
        exit;
    }

    /**
     * Redirect system to another ssl url
     *
     * @param string $url [optional] Url
     *
     * @return mixed
     */
    public function redirectSsl($url = '')
    {
        $this->clearCache($url);
        $this->saveState();

        if (!$url) {
            if ($_SERVER['SERVER_PORT'] == 443) {
                return true;
            }
            $url = $this->paths['current_full'];
        }
        $url = str_replace('http:', 'https:', $url);
        if ($url) {
            if (headers_sent()) {
                echo '<script type="text/javascript">location.href="' . $url . '";</script>';
            } else {
                header("HTTP/1.1 301 Moved Permanently");
                header('Location: ' . $url);
            }
        }
        die;
    }

    /**
     * Redirect system to restricted page
     *
     * @param string $message Message
     *
     *
     */
    function restricted($message)
    {
        $this->restricted = true;
        $this->assign('message', $message);
    }

    /**
     * Get system trace array
     *
     * @return mixed
     */
    public function getPage()
    {
        $arr = array();
        if ($this->trace) {
            $arr['sys_version'] = $this->sys_version;
        }
        $arr['hostname'] = self::$hostname;
        if ($this->trace) {
            $arr['crypt_key'] = $this->crypt_key;
        }
        $arr['title'] = $this->title;
        $arr['doctype'] = $this->doctype;
        $arr['html_tag'] = $this->html_tag;
        $arr['body_tag'] = $this->body_tag;
        $arr['content_type'] = $this->content_type;
        $arr['live'] = $this->live;
        $arr['trace'] = $this->trace;
        $arr['page'] = $this->page;
        $arr['multi_language'] = $this->multi_language;
        $arr['meta_tags'] = $this->meta_tags;
        $arr['query'] = $this->query;
        $arr['subquery'] = $this->subquery;
        $arr['skin'] = $this->skin;
        $arr['default_skin'] = $this->default_skin;
        $arr['module'] = $this->module;
        $arr['module_user_type'] = $this->module_user_type;
        $arr['content'] = $this->content;
        $arr['component'] = $this->component;
        $arr['subcomponent'] = $this->subcomponent;
        $arr['components'] = $this->components;
        $arr['page_no'] = $this->page_no;
        $arr['page_skip'] = $this->page_skip;
        $arr['page_offset'] = $this->page_offset;
        $arr['no_pages'] = $this->no_pages;
        $arr['no_total_rows'] = $this->no_total_rows;
        $arr['ispostback'] = $this->ispostback;
        $arr['pagination'] = $this->pagination;
        if ($this->no_pages) {
            for ($i = 1; $i <= $this->no_pages; $i++) {
                $arr['pages'][$i] = $i;
            }
        }
        $arr['actions'] = $this->actions;
        $arr['actions_executed'] = $this->actions_executed;
        $arr['errors'] = $this->errors;
        $arr['messages'] = $this->messages;
        $arr['session_cookie'] = $this->session_cookie;
        $arr['session'] = $this->session;
        $arr['state'] = $this->state;
        $arr['check_login'] = $this->check_login;
        $arr['logged'] = $this->logged;
        $arr['user'] = $this->user;
        $arr['history'] = $this->history;
        $arr['server'] = $this->server;
        $arr['paths'] = $this->paths;
        $arr['objects'] = $this->objects;
        $arr['valid'] = $this->valid;
        $arr['settings'] = $this->settings;
        $arr['response_type'] = $this->response_type;
        if ($this->db_conn_enabled && is_a($this->db_conn->tables, 'TablesManager')) {
            if ($this->trace) {
                $arr['dns'] = $this->db_conn->get_dns();
                $arr['db_no_valid_queries'] = $this->db_conn->num_valid_queries;
                $arr['db_no_invalid_queries'] = $this->db_conn->num_invalid_queries;
                $arr['db_queries'] = $this->db_conn->queries;
            }
            $arr['tables'] = $this->db_conn->tables;
        }
        $arr['user_types_tables'] = $this->user_types_tables;
        $arr['js_files'] = $this->js_files;
        $arr['css_files'] = $this->css_files;
        $arr['ajax'] = $this->ajax;
        return $arr;
    }

    /**
     * loads libraries defined in configuration file
     *
     * @param string $library Library to load
     *
     * @return bool
     */
    public function loadLibrary($library)
    {
        if (!isset($this->loaded_libraries[$library])) {
            if (!$this->loadFile(dirname(__FILE__) . '/libraries/' . $library . '/import.php')) {
                $this->logger->log('loadLibrary', 'Import file for library "' . $library . '" was not found at: "' . dirname(__FILE__) . '/lib/libraries/' . $library . '/import.php"');
                return false;
            }
            $this->loaded_libraries[$library] = 1;
        }
        return true;
    }

    /**
     * Load class for given model
     *
     * @param string $model Model name
     *
     * @return bool
     */
    public function loadModel($model)
    {
        if (!$this->models->import($model)) {
            $this->logger->log('load_dal', 'File for model "' . $model . '" was not found in any models folders.');
            return false;
        }
        return true;
    }

    /**
     * Load class from php files
     *
     * @param object $class Class name
     * @param string $class_name
     *
     * @return bool
     */
    public function loadClass($class, $class_name = '')
    {
        if (!$class_name)
            $class_name = $class;
        if (!class_exists($class_name)) {
            $paths = explode('.', $class);
            $file_path = $class . '.php';
            if (count($paths) > 1) {
                $paths[count($paths) - 1] = $paths[count($paths) - 1] . '.php';
                $file_path = implode('/', $paths);
            }
            if (!$this->loadFile(dirname(__FILE__) . '/classes/' . $file_path)) {
                $this->logger->log('load_class', 'File for class "' . $class . '" was not found at: "' . dirname(__FILE__) . '/lib/classes/' . $file_path . '"');
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * Load a PHP file given.
     *
     * @param string $file path to the file
     *
     * @return bool
     */
    public function loadFile($file)
    {
        if (file_exists($file)) {
            try {
                include $file;
                return true;
            } catch (Exception $ex) {
                System::triggerError('Error loading file "' . $file . '": ' . $ex->getMessage());
            }
        }
        $this->logger->log('load_file', 'File "' . $file . '" was not found!');
        return false;
    }

    /**
     * Disconnect from database
     *
     *
     */
    function disconnect()
    {
        if (is_object($this->db_conn)) {
            $this->db_conn->disconnect();
        }
    }

    /**
     * To string magic method
     *
     * @return string
     */
    public function __toString()
    {
        return 'System - Class';
    }

    /**
     * Returns the hostname of the website
     *
     * @return string
     */
    static function get_hostname()
    {
        if (self::$hostname != '') {
            return self::$hostname;
        }
        self::$hostname = get_hostname();
        return self::$hostname;
    }

    /**
     * Header status codes return
     *
     * @param string $statusCode Header code
     *
     * @return string
     */
    private function _headerStatus($statusCode)
    {
        static $status_codes = null;

        if ($status_codes === null) {
            $status_codes = array(
                100 => 'Continue',
                101 => 'Switching Protocols',
                102 => 'Processing',
                200 => 'OK',
                201 => 'Created',
                202 => 'Accepted',
                203 => 'Non-Authoritative Information',
                204 => 'No Content',
                205 => 'Reset Content',
                206 => 'Partial Content',
                207 => 'Multi-Status',
                300 => 'Multiple Choices',
                301 => 'Moved Permanently',
                302 => 'Found',
                303 => 'See Other',
                304 => 'Not Modified',
                305 => 'Use Proxy',
                307 => 'Temporary Redirect',
                400 => 'Bad Request',
                401 => 'Unauthorized',
                402 => 'Payment Required',
                403 => 'Forbidden',
                404 => 'Not Found',
                405 => 'Method Not Allowed',
                406 => 'Not Acceptable',
                407 => 'Proxy Authentication Required',
                408 => 'Request Timeout',
                409 => 'Conflict',
                410 => 'Gone',
                411 => 'Length Required',
                412 => 'Precondition Failed',
                413 => 'Request Entity Too Large',
                414 => 'Request-URI Too Long',
                415 => 'Unsupported Media Type',
                416 => 'Requested Range Not Satisfiable',
                417 => 'Expectation Failed',
                422 => 'Unprocessable Entity',
                423 => 'Locked',
                424 => 'Failed Dependency',
                426 => 'Upgrade Required',
                500 => 'Internal Server Error',
                501 => 'Not Implemented',
                502 => 'Bad Gateway',
                503 => 'Service Unavailable',
                504 => 'Gateway Timeout',
                505 => 'HTTP Version Not Supported',
                506 => 'Variant Also Negotiates',
                507 => 'Insufficient Storage',
                509 => 'Bandwidth Limit Exceeded',
                510 => 'Not Extended'
            );
        }

        if ($status_codes[$statusCode] !== null) {
            $status_string = $statusCode . ' ' . $status_codes[$statusCode];
            header($_SERVER['SERVER_PROTOCOL'] . ' ' . $status_string, true, $statusCode);
            return $status_string;
        }
        return '';
    }

    /**
     * Add new environment
     *
     * @param string $name Name of the enviroment
     * @param mixed $hostnames Hostnames to map to
     *
     */
    public function addConfig($name, $hostnames)
    {
        if (!isset($this->environments[$name])) {
            $this->environments[$name] = array();
        }
        if (is_array($hostnames)) {
            foreach ($hostnames as $host) {
                $this->environments[$name][] = $host;
            }
        } else {
            $this->environments[$name][] = $hostnames;
        }
    }

    /**
     * Get the current environments
     *
     * @return mixed
     */
    private function _getConfigs()
    {
        $found = array();
        self::get_hostname();
        foreach ($this->environments as $name => $hosts) {
            foreach ($hosts as $host) {
                if (is_callable($host) && $host($this)) {
                    $found[$name] = $name;
                } elseif ($host == self::$hostname) {
                    $found[$name] = $name;
                }
            }
        }
        return $found;
    }

    /**
     * Get custom response
     *
     * @return string
     */
    public function getResponse()
    {
        if ($this->response_type == 'json') {
            $arr = $this->response_data;
            $arr['executed'] = 1;
            if ($this->messages) {
                $this->clearMessages();
                $arr['messages'] = $this->messages;
            }
            if (count($this->errors)) {
                $arr['errors'] = $this->errors;
            }
            if ($this->trace) {
                $this->time->end('system');
                TraceManager::generate();
            }
            echo json_encode($arr);
            die;
        }
    }

    /**
     * Trigger Error
     *
     * @param string $message
     * @param int $type
     * @param string $file
     */
    public static function triggerError($message, $type = E_USER_NOTICE, $file = '')
    {
        if(!$file) {
            $bt = debug_backtrace();
            if ($bt[0]) {
                $file = $bt[0]['file'];
            }
        }
        trigger_error('[File] ' . $file . '] ' . $message, $type);
    }

    /**
     * Get db tables form the global
     *
     *
     */
    public function addTables()
    {
        if (is_array($this->tables)) {
            $tables = $this->tables;
            $this->tables = new TablesManager();
            foreach ($tables as $k => $v) {
                $this->tables[$k] = $v;
            }
        }
    }
}