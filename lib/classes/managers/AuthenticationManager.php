<?php
/**
 * Authentication Manager Class
 */

/**
 * The manager class for authenticating users
 * @example In page: $this->system->authentication
 * @package WebLauncher\Managers
 */
class AuthenticationManager
{
    /**
     * @var array $settings Setting for the manager
     */
    var $settings = array();
    /**
     * @var string $username_field Username field in POST
     */
    var $username_field = '_username';
    /**
     * @var string $password_field Password field in POST
     */
    var $password_field = '_password';
    /**
     * @var string $type_field User type field in POST
     */
    var $type_field = '_type';
    /**
     * @var string $remmember_field Remmember field in post
     */
    var $remmember_field = '_remmember';
    /**
     * @var array $messages Messages to be returned
     */
    var $messages = array();
    /**
     * @var bool $show_messages If messages should be displayed
     */
    var $show_messages = true;
    /**
     * @var string $redirect_field redirect url field in POST
     */
    var $redirect_field = 'goto';
    /**
     * @var bool $logins_logs_enabled if visits log is enabled
     */
    var $logins_logs_enabled = false;
    /**
     * @var string $visits_model
     */
    var $logins_logs_model = 'logins';
    /**
     * @var string $module_user_type Module user type to check
     */
    var $module_user_type = '';
    /**
     * @var bool $logged If Logged in
     */
    var $logged = 0;

    /**
     * Login user in the system
     * @param string|int $user_id Id of the user to log in the system
     * @param string $type Type of the user that is configured in configuration file
     * This method will redirect to the proper url
     */
    function login($user_id = '', $type = '')
    {
        

        $username = isset_or($_REQUEST[$this->username_field]);
        $password = isset_or($_REQUEST[$this->password_field]);
        $type = isset_or($_REQUEST[$this->type_field], $type);

        $this->logged = 0;

        if (($username != '' && $password != '' || $user_id != '') && $type != '' && (($this->module_user_type != '' && $this->module_user_type == $type) || $this->module_user_type == '')) {
            $row = '';
            // get user
            if ($user_id != '') {
                $query = 'SELECT * FROM ' . $this->settings[$type]['table'] . ' WHERE id=' . $user_id . ' LIMIT 1';
                $row = System::getInstance()->db_conn->getRow($query);
            } else {
                if (is_array($this->settings[$type]['username'])) {
                    foreach ($this->settings[$type]['username'] as $user_field)
                        if (!$row) {
                            $query = 'SELECT * FROM ' . $this->settings[$type]['table'] . ' WHERE (lower(' . $user_field . ')=lower("' . $username . '")) LIMIT 1';
                            $row = System::getInstance()->db_conn->getRow($query);
                        }
                } else {
                    $query = 'SELECT * FROM ' . $this->settings[$type]['table'] . ' WHERE (lower(' . $this->settings[$type]['username'] . ')=lower("' . $username . '")) LIMIT 1';
                    $row = System::getInstance()->db_conn->getRow($query);
                }
            }
            if ($row) {
                $this->logged = 1;
                // check password
                if ($row[$this->settings[$type]['password']] != (isset($this->settings[$type]['crypting']) ? $this->settings[$type]['crypting'](trim($password)) : trim($password))) {
                    $this->logged = 0;
                    if ($this->show_messages)
                        System::getInstance()->add_message('error', $this->messages['no_pass']);
                }

                // valid field if required
                if (isset($this->settings[$type]['valid']) && $this->settings[$type]['valid'] != '') {
                    if (!$row[$this->settings[$type]['valid']]) {
                        $this->logged = 0;
                        if ($this->show_messages)
                            System::getInstance()->add_message('error', $this->messages['valid']);
                    }
                }

                // active field if required
                if (isset($this->settings[$type]['active']) && $this->settings[$type]['active'] != '')
                    if (!$row[$this->settings[$type]['active']]) {
                        $this->logged = 0;
                        if ($this->show_messages)
                            System::getInstance()->add_message('error', $this->messages['active']);
                    }

                // deleted field if required
                if (isset($this->settings[$type]['deleted']) && $this->settings[$type]['deleted'] != '') {
                    if ($row[$this->settings[$type]['deleted']]) {
                        $this->logged = 0;
                        System::getInstance()->add_message('error', $this->messages['deleted']);
                    }
                }

                if ($this->logged) {
                    $this->login_user($row['id'], $type, isset($_POST[$this->remmember_field]));
                    if ($this->messages['success'])
                        System::getInstance()->add_message('success', $this->messages['success']);
                }
            } else {
                unset(System::getInstance()->session['user_id']);
                unset(System::getInstance()->session['user_type']);
                unset(System::getInstance()->session['remmember']);
                System::getInstance()->add_message('error', $this->messages['no_user']);
            }
        }
        if (System::getInstance()->ajax) {
            System::getInstance()->response_data['logged'] = $this->logged;
            System::getInstance()->response_type = 'json';
            System::getInstance()->get_response();
        } else {
            $goto = isset($_POST[$this->redirect_field]) ? $_POST[$this->redirect_field] : '';
            if ($this->logged == 1) {
                if ($goto != '')
                    System::getInstance()->redirect($goto);
                else
                    System::getInstance()->redirect(System::getInstance()->paths['current']);
            } else {
                System::getInstance()->redirect(System::getInstance()->paths['current'] . '?e=login');
            }
        }
    }

    /**
     * Login user in the system without processing request
     * @param int|string $user_id Id of the user
     * @param string $type Type od user configured in configuration file
     * @param bool $remmember Flag if user should be remmembered for a longer period set in the remmember offset
     */
    function login_user($user_id = '', $type = '', $remmember = 0)
    {
        
        if (!$type)
            $type = System::getInstance()->module_user_type;
        if ($this->settings[$type]['lastlogin']) {
            $query = 'update ' . $this->settings[$type]['table'] . ' set `' . $this->settings[$type]['lastlogin'] . '`=NOW() where id=' . $user_id;
            System::getInstance()->db_conn->query($query);
        }
        System::getInstance()->session['user_id'] = $user_id;
        System::getInstance()->session['user_type'] = $type;

        if (isset(System::getInstance()->session['user_logout']))
            unset(System::getInstance()->session['user_logout']);
        if ($this->logins_logs_enabled)
            $this->start_visit_log($user_id);

        if ($remmember)
            System::getInstance()->session['remmember'] = 1;
        else
            unset(System::getInstance()->session['remmember']);

        $this->init_user();
    }

    /**
     * Logout user
     */
    function logout_user()
    {
        
        unset(System::getInstance()->session['user_id']);
        unset(System::getInstance()->session['user_type']);
        unset(System::getInstance()->session['remmember']);
        unset(System::getInstance()->session['temp']);
        SessionManager::regenerate();
        System::getInstance()->session['user_logout'] = 1;
    }

    /**
     * Start visit log
     * @param string $user_id
     * @return string
     */
    function start_visit_log($user_id)
    {
        
        if ($this->logins_logs_enabled) {

            $params = array();
            $params['user_id'] = System::getInstance()->session['user_id'];
            $params['user_type'] = System::getInstance()->session['user_type'];
            $params['login_datetime'] = date('Y-m-d H:i:s');
            $params['refresh_datetime'] = date('Y-m-d H:i:s');
            $params['duration'] = 0;

            System::getInstance()->session['visit_log_id'] = System::getInstance()->models->{$this->logins_logs_model}->insert($params);
            if (class_exists('LoginLoggerExtension'))
                LoginLoggerExtension::start_visit_log(System::getInstance()->session['user_id'], System::getInstance()->session['visit_log_id']);
            return System::getInstance()->session['visit_log_id'];
        }
        return '';
    }

    /**
     * Update current visit log
     */
    function update_visit_log()
    {
        
        if ($this->logins_logs_enabled && System::getInstance()->logged && isset(System::getInstance()->session['visit_log_id'])) {
            $query = new QueryBuilder($this->logins_logs_model);
            $obj = $query->select()->where('id=' . sat(System::getInstance()->session['visit_log_id']))->first();
            $params = array();

            $params['refresh_datetime'] = @date('Y-m-d H:i:s');
            $params['duration'] = @strtotime($params['refresh_datetime']) - @strtotime($obj['login_datetime']);

            $query = new QueryBuilder($this->logins_logs_model);
            $query->update($params)->where('id=' . System::getInstance()->session['visit_log_id'])->execute();
            if (class_exists('LoginLoggerExtension'))
                LoginLoggerExtension::update_visit_log(System::getInstance()->session['user_id'], System::getInstance()->session['visit_log_id']);
            return System::getInstance()->session['visit_log_id'];
        }
        return '';
    }

    /**
     * Logout user by requst and redirect to the given url $goto
     * @param string $goto
     */
    function logout($goto = '')
    {
        
        $this->logout_user();
        if (System::getInstance()->ajax) {
            System::getInstance()->response_data['logged'] = $this->logged;
            System::getInstance()->response_type = 'json';
            System::getInstance()->get_response();
        } else {
            System::getInstance()->redirect($goto ? $goto : System::getInstance()->paths['current']);
        }
    }

    /**
     * Init user data
     */
    function init_user()
    {
        
        if (isset(System::getInstance()->session['user_id']) && System::getInstance()->session['user_id'] != '') {
            System::getInstance()->logged = true;
            $query = 'SELECT * FROM ' . System::getInstance()->user_types_tables[System::getInstance()->session['user_type']]['table'] . ' WHERE (id=' . System::getInstance()->session['user_id'] . ') LIMIT 1';
            $row = System::getInstance()->db_conn->getRow($query);
            System::getInstance()->user = $row;
        } else
            System::getInstance()->user = '';
    }

    /**
     * Get new password generated for the user
     * @param string $user_id [optional] Id of the user to generate password
     * @param int $length [optional] Length of the generated password
     * @param string $password [optional] Custom password you want to update the user
     * @param string $algorithm [optional] The algorithm to use for hashing
     * @return string New password
     */
    function new_password($user_id = '', $length = 6, $password = '', $algorithm = 'md5')
    {
        
        if (!$password)
            $password = substr($algorithm(encrypt(microtime())), 0, $length);
        if (!$user_id)
            $user_id = isset(System::getInstance()->session['user_id']) ? System::getInstance()->session['user_id'] : '';
        if ($user_id) {
            $query = 'UPDATE ' . System::getInstance()->user_types_tables[System::getInstance()->session['user_type']]['table'] . ' SET `' . $this->settings[System::getInstance()->session['user_type']]['password'] . '`=(' . sat($this->settings[System::getInstance()->session['user_type']]['crypting'] ? $this->settings[System::getInstance()->session['user_type']]['crypting']($password) : $password) . ') WHERE (`id`=' . System::getInstance()->session['user_id'] . ') LIMIT 1';
            System::getInstance()->db_conn->query($query);
        }
        return $password;
    }
}