<?php
/**
 * System helper functions
 */

/**
 * Display array formated
 * @param $arr
 * @param bool $return if true return value instead of writing it
 * @package WebLauncher\Functions
 * @return string
 */
function echopre($arr, $return = false) {
	$text = '<pre class="debug">';
	$text .= print_r($arr,true);
	$text .= '</pre>';
	if ($return)
		return $text;
	echo $text;
	return '';
}

/**
 * Return formated display for array
 * @param $arr
 * @package WebLauncher\Functions
 * @return string
 */
function echopre_r($arr) {
	return echopre($arr, true);
}

/**
 * Echo and return value
 * @param $str
 * @package WebLauncher\Functions
 * @return string
 */
function echo_r($str) {
	ob_start();
	echo $str;
	$value = ob_get_contents();
	ob_end_clean();
	return $value;
}

/**
 * The system error handler
 * @package WebLauncher\Functions
 * @param $errno
 * @param $errstr
 * @param $errfile
 * @param $errline
 * @param $errcontext
 */
function the_error_handler($errno = '', $errstr = '', $errfile = '', $errline = '', $errcontext = '') {
	if (defined('PHP_SAPI') && PHP_SAPI == 'cli') {
		echo "($errno) $errstr ([$errline] $errfile)\n";
	} else {
		$errortype = array(1 => array('code' => '_ERR_ERROR', 'name' => 'Error', 'back' => 'ffcccc', 'color' => '990000', 'line' => '660000'), 2 => array('code' => '_ERR_WARNING', 'name' => 'Warning', 'back' => 'FFD5BF', 'color' => 'CC3300', 'line' => 'FF9966'), 4 => array('code' => '_ERR_PARSE', 'name' => 'Parse Error', 'back' => 'D7EBFF', 'color' => '003366', 'line' => '71B8FF'), 8 => array('code' => '_ERR_NOTICE', 'name' => 'Notice', 'back' => 'EAEAEA', 'color' => '333333', 'line' => '999999'), 16 => array('code' => '_ERR_CORE_ERROR', 'name' => 'Core Error', 'back' => 'ffcccc', 'color' => '990000', 'line' => '660000'), 32 => array('code' => '_ERR_CORE_WARNING', 'name' => 'Core Warning', 'back' => 'FFD5BF', 'color' => 'CC3300', 'line' => 'FF9966'), 64 => array('code' => '_ERR_COMPILE_ERROR', 'name' => 'Compile Error', 'back' => 'ffcccc', 'color' => '990000', 'line' => '660000'), 128 => array('code' => '_ERR_COMPILE_WARNING', 'name' => 'Compile Warning', 'back' => 'FFD5BF', 'color' => 'CC3300', 'line' => 'FF9966'), 256 => array('code' => '_ERR_USER_ERROR', 'name' => 'User Error', 'back' => 'FFB7B7', //ffcccc',
		'color' => '333333', //990000',
		'line' => '660000'), 512 => array('code' => '_ERR_USER_WARNING', 'name' => 'User Warning', 'back' => 'FFD5BF', 'color' => 'CC3300', 'line' => 'FF9966'), 1024 => array('code' => '_ERR_USER_NOTICE', 'name' => 'User Notice', 'back' => 'EAEAEA', 'color' => '333333', 'line' => '999999'));
		$default = array('code' => '_ERR_UNDEFINED', 'name' => 'Error Undefined', 'back' => 'EAEAEA', 'color' => '333333', 'line' => '999999');

		$raw = debug_backtrace();
		$hash = base64_encode(microtime());
		$backtrace = '<div id="_php_error_' . $hash . '" style="display:none;"><table cellspacing="0" cellpadding="0" width="100%" style="color:#' . isset_or($errortype[$errno]['color'], $default['color']) . ';background:#' . isset_or($errortype[$errno]['color'], $default['color']) . ';">
        	<tr style="background:#' . isset_or($errortype[$errno]['color'], $default['color']) . '; color:#' . isset_or($errortype[$errno]['back'], $default['back']) . ';">
        		<td>Trace</td><td>File</td><td>Line</td><td>Function</td>
        	</tr>
        ';
		$no = 0;
		$method = '';
        $class = '';
		if (isset($raw[1])){
			$method = $raw[1]['function'];
            $class = isset_or($raw[1]['class']);
		}
		$raw = array_reverse($raw);
		foreach ($raw as $entry) {
			if (isset_or($entry['function']) != 'the_error_handler') {
				$backtrace .= '<tr style="background:#' . isset_or($errortype[$errno]['back'], $default['back']) . ';"><td>' . $no . '</td>';
				$backtrace .= "<td>" . isset_or($entry['file']) . "</td><td>" . isset_or($entry['line']) . "</td>";
				$backtrace .= "<td><b>" . isset_or($entry['function']) . "</b></td>";
				$no++;
				$backtrace .= '</tr>';
			}
		}
		$backtrace .= '</table></div>';

		$output = '';
		if (error_reporting() & $errno) {
			$output .= '<div>';
			$output .= '<table cellspacing="0" cellpadding="0" width="100%" style="font-family:arial,lucida console,courier new;font-size:12px;color:#' . isset_or($errortype[$errno]['color'], $default['color']) . ';background-color:#' . isset_or($errortype[$errno]['back'], $default['back']) . ';margin:0px;padding:0px;border:1px solid #' . isset_or($errortype[$errno]['line'], $default['line']) . ';margin-bottom:2px;">';
			$output .= '<tr><td style="width:30%;vertical-align:top;padding:2px;">';
			$output .= '<table cellspacing="0" cellpadding="0" width="100%" style="color:#' . isset_or($errortype[$errno]['color'], $default['color']) . ';">';
			$output .= '<tr>';
			$output .= '<td><b>PHP ' . isset_or($errortype[$errno]['name'], $default['name']) . '</b> No:' . $errno . ' <br/><small>[' . isset_or($errortype[$errno]['code'], $default['code']) . ']</small></td>';
			$output .= '';
			$output .= '';
			$output .= '<td colspan=2 style="color:#' . isset_or($errortype[$errno]['color'], $default['color']) . ';padding:2px 4px ;background:#fff;"><b>' . $errstr . '</b></td>';
			$output .= '';
			$output .= '';
			$output .= '<td style="padding:2px;">' . 'File (Line)' . ': ' . $errfile . ' (' . $errline . ')' . ($method ? '<br/>Function: ' . $method : '') . ' (<a href="#" onclick="document.getElementById(\'_php_error_' . $hash . '\').style.display = \'block\';return false;">show trace</a>)</td>';
			$output .= '</tr>';
			$output .= '</table>';
			$output .= '</td></tr><tr><td style="vertical-align:top;padding:2px;">';
			$output .= '' . $backtrace;
			$output .= '</td></tr>';
			$output .= '</table>';
			$output .= '</div>';
			$output = trim($output);
			$output = str_replace("\n", "", $output);
			$output = str_replace("\r", "", $output);
			global $page;
			if (isset_or($page -> debug))
				echo $output;

			if (!is_writable(isset_or($page -> error_log_path) . 'errs.log.csv')) {
				$handle = @fopen(isset_or($page -> error_log_path) . 'errs.log.csv', 'w');
				@fclose($handle);
			}
			if (is_writable(isset_or($page -> error_log_path) . 'errs.log.csv')) {
				$handle = fopen(isset_or($page -> error_log_path) . 'errs.log.csv', 'a');
				fwrite($handle, '\'' . print_r($errortype[$errno], true) . "','$errfile','$errline','$errstr','" . date('Y-m-d\',\'H:i:s') . "'\n");
				fclose($handle);
			}
            
            if (!is_writable(isset_or($page -> error_log_path) . 'errs.log.json')) {
                $handle = @fopen(isset_or($page -> error_log_path) . 'errs.log.json', 'w');
                @fclose($handle);
            }
            if (is_writable(isset_or($page -> error_log_path) . 'errs.log.json')) {
                $handle = fopen(isset_or($page -> error_log_path) . 'errs.log.json', 'a');
                $array=array(
                    'error'=>$errortype[$errno],
                    'file'=>$errfile,
                    'line'=>$errline,
                    'text'=>$errstr,
                    'method'=>$method,
                    'class'=>$class,
                    'date'=>date('Y-m-d H:i:s')
                );
                fwrite($handle, json_encode($array) . ",\n");
                fclose($handle);
            }
		}
	}
}

set_error_handler('the_error_handler');

/**
 * Register shutdown method
 * @package WebLauncher\Functions
 */
function the_register_shutdown() {
	global $page;
	session_write_close();
	# Getting last error
	$error = error_get_last();
	if ($page -> debug){
        the_error_handler($error['type'], $error['message'], $error['file'], $error['line']); 
		# Checking if last error is a fatal error
		if (($error['type'] === E_ERROR) || ($error['type'] === E_USER_ERROR)) {

			if ($page -> error_log_email) {
				$page -> import('library', 'mail');
				$mail = new Mail();
				$message = 'Found error: <br/>' . echopre_r($error);
				$mail -> send_mail($page -> error_log_email, 'Fatal error on server ' . $page::$hostname, $message, $page -> error_log_email, 'Fatal Errors Sender');
			}
		}
    }
}

register_shutdown_function('the_register_shutdown');

/**
 * The system exception handler
 * @package WebLauncher\Functions
 * @param Exception $exception
 */
function the_exception_handler($exception) {
	echo "Uncaught exception: ", $exception -> getMessage(), "\n";
}

set_exception_handler('the_register_shutdown');

/**
 * Check if isset else return alternate
 * @package WebLauncher\Functions
 * @param $check
 * @param $alternate
 * @return null
 */
function isset_or(&$check, $alternate = NULL) {
	return (isset($check)) ? $check : $alternate;
}

/**
 * Clean database insertion fields
 * @package WebLauncher\Functions
 * @param $string
 */
function sat($string) {
	global $dal;
	return $dal -> db -> stringEscape(stripslashes(addslashes(trim($string))));
}

/**
 * Serialize array
 * @package WebLauncher\Functions
 * @param $array
 * @return string
 */
function ser($array) {
	if (is_array($array))
		return @serialize($array);
	return $array;
}

/**
 * Unserialize array
 * @package WebLauncher\Functions
 * @param $string
 * @return mixed
 */
function unser($string) {
	if (is_string($string)) {
		return @unserialize($string);
	}
	return $string;
}

/**
 * validate numeric string structure
 *@package WebLauncher\Functions
 * @return true if ok false if not
 *
 * @param $value
 *
 * @author silviu
 */
function checkNumericString($value) {
	$exp = '^[0-9]*$';
	if (!eregi($exp, $value)) {
		return false;
	} else {
		return true;
	}//end if (!eregi($exp, $value))
}//end function checkNumericString($value)

/**
 * transform the date to the age of the user
 * @package WebLauncher\Functions 
 * @return string the number of years or unknown
 *
 * @param string $birthday the data used to calculate the age
 *
 * @author alex
 */
function date2birthday($birthday) {
	if (($birthday != '0000-00-00') AND ($birthday != '0000-00-00 00:00:00') AND ($birthday != '')) {
		list($year, $month, $day) = explode("-", $birthday);
		$year_diff = date("Y") - $year;
		$month_diff = date("m") - $month;
		$day_diff = date("d") - $day;
		if ($day_diff < 0 || $month_diff < 0) {
			$year_diff--;
		}//end if ($day_diff < 0 || $month_diff < 0)
		return $year_diff;
	} else {
		return 'unknown';
	}//end if (($birthday != '0000-00-00') AND ($birthday != '0000-00-00 00:00:00') AND ($birthday != ''))
}//end function date2birthday ($birthday)

/**
 * Encrypt data
 * @package WebLauncher\Functions
 * @param string $plain_text
 * @return string
 */
function encrypt($plain_text) {
	global $page;
	$salt = $page -> crypt_key;

	$mcrypt_iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $mcrypt_iv = mcrypt_create_iv($mcrypt_iv_size, MCRYPT_RAND);

    $mcrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $plain_text, MCRYPT_MODE_ECB, $mcrypt_iv);

    $encoded = base64_encode($mcrypted);

    return $encoded;
}

/**
 * Decrypt data
 * @package WebLauncher\Functions
 * @param string $crypted_text
 * @return string
 */
function decrypt($crypted_text) {
	global $page;
	$salt = $page -> crypt_key;
	
	$mcrypt_iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $mcrypt_iv = mcrypt_create_iv($mcrypt_iv_size, MCRYPT_RAND);

    $basedecoded = base64_decode($crypted_text);

    $mcrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, $basedecoded, MCRYPT_MODE_ECB, $mcrypt_iv);

    return $mcrypted;
}

/**
 * Translate function
 * @package WebLauncher\Functions
 * @param string $content
 * @param int $language_id
 * @param string $tags
 * @return string
 */
function tr($content, $language_id = 0, $tags = 'site') {
    global $page;
	if ($content != "" && $page->multi_language) {
		$language = $language_id ? $language_id : isset($page -> session['language_id']) ? $page -> session['language_id'] : 0;
		$quer = $content;

		if ($page && $page -> db_conn_enabled) {
			$hostname = '';
			if ($page -> admin)
				$key = sha1($content);
			else {
				$hostname = System::get_hostname();
				$key = sha1($content . '_' . $hostname);
			}
			if (!isset($page -> translations))
				$page -> translations = array();
			if (isset($page -> translations[$key])) {
				$content = $page -> translations[$key];
			} else {
				$query = "select " . $page->libraries_settings['wbl_locale']['texts_table'] . ".id," . $page->libraries_settings['wbl_locale']['texts_table'] . ".tags," . $page->libraries_settings['wbl_locale']['texts_table'] . ".query," . $page->libraries_settings['wbl_locale']['texts_table'] . ".value," . $page->libraries_settings['wbl_locale']['translations_table'] . ".value as translation from " . $page->libraries_settings['wbl_locale']['texts_table'] . " left join " . $page->libraries_settings['wbl_locale']['translations_table'] . " on " . $page->libraries_settings['wbl_locale']['translations_table'] . ".text_id=" . $page->libraries_settings['wbl_locale']['texts_table'] . ".id where " . $page->libraries_settings['wbl_locale']['texts_table'] . ".key=" . sat($key) . "";

				$text = $page -> db_conn -> getRow($query);
				if ($text) {
					$text['tags'] = explode(" ", $text['tags']);
					if (sat($text['query']) != sat($quer))
						$page -> db_conn -> query("update " . $page->libraries_settings['wbl_locale']['texts_table'] . " set query=" . sat($quer) . " where id=" . $text['id']);
					if (count(array_diff($text['tags'], explode(" ", $tags)))) {
						$tags = implode(" ", array_merge(array_diff(explode(" ", $tags), $text['tags']), $text['tags']));

						$page -> db_conn -> query("update " . $page->libraries_settings['wbl_locale']['texts_table'] . " set tags=" . sat($tags) . " where id=" . $text['id']);
					}
					if ($language > 0 && isset_or($text['translation']))
						$text['value'] = $text['translation'];
					$content = $text['value'];
				} else {
					$query = "INSERT INTO `" . $page->libraries_settings['wbl_locale']['texts_table'] . "` (
				`id` ,
				`key` ,
				`value`,
				`query`,
				`tags`,
				`hostname`,
				`admin`
				)
				VALUES (
				NULL , " . sat($key) . ", " . sat($content) . "," . sat($quer) . "," . sat($tags) . "," . sat($hostname) . "," . $page -> admin . "
				);";
					$text = $page -> db_conn -> query($query);
				}
				$page -> translations[$key] = $content;
			}
		}
	}
	return $content;
}

/**
 * Execute and wait a system command
 * @package WebLauncher\Functions
 * @param string $path
 * @param string $exe
 * @param string $args
 */
function execute_wait($path, $exe, $args = "") {
	if (is_file($path . $exe)) {
		$oldpath = getcwd();
		chdir($path);

		if (substr(php_uname(), 0, 7) == "Windows") {
			$cmd = $path . $exe;
			$cmdline = "cmd /c $cmd " . $args;
			$WshShell = new COM("WScript.Shell");
			$oExec = $WshShell -> Run($cmdline, 0, true);
		} else {
			exec("./" . $exe . " " . $args);
		}
		chdir($oldpath);
	}
}

/**
 * Current date and time formated a database
 * @package WebLauncher\Functions
 */
function nowfull() {
	return date("Y-m-d H:i:s");
}

/**
 * Current date formated as database
 * @package WebLauncher\Functions
 */
function now() {
	return date("Y-m-d");
}

/**
 * Get number of days
 * @package WebLauncher\Functions
 * @param string $start
 * @param string $end
 * @return int
 */
function getNoDays($start, $end) {
	// Vars
	$day = 86400;
	// Day in seconds
	$format = 'Y-m-d';
	// Output format (see PHP date function)
	$sTime = strtotime($start);
	// Start as time
	$eTime = strtotime($end);
	// End as time
	$numDays = round(($sTime - $eTime) / $day) + 1;
	return intval($numDays);
}

/**
 * Parse date from string
 * @package WebLauncher\Functions
 * @param string $str
 * @param string $format
 * @param string $target_format
 * @return bool|string
 */
function parse_date($str, $format = 'Y-m-d', $target_format = 'Y-m-d') {
	$date = date_parse_from_format($format, $str);
	return date($target_format, mktime(isset_or($date['hour'], 0), isset_or($date['minute'], 0), isset_or($date['second'], 0), isset_or($date['month'], 0), isset_or($date['day'], 0), isset_or($date['year'], 0)));
}

/**
 * Get current page url
 * @package WebLauncher\Functions
 * @return String URL
 */
function page_url() {
	$pageURL = 'http';
	if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {$pageURL .= 's';
	}
	$pageURL .= '://';
	$pageURL .= isset_or($_SERVER['SERVER_NAME']) . isset_or($_SERVER['REQUEST_URI']);
	if ($url_parts = parse_url($pageURL)) {
		if (isset($url_parts['path'])) {
			if (substr($url_parts['path'], strlen($url_parts['path']) - 1, 1) != '/')
				$url_parts['path'] .= '/';
			$pageURL = $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . (isset_or($url_parts['query']) ? '?' . $url_parts['query'] : '');
		}
	}
	return $pageURL;
}

/**
 * Get hostname
 * @package WebLauncher\Functions
 */
function get_hostname() {
	$server_host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : (defined("RHOST") ? RHOST : '');
	if (strpos($server_host, 'www.') == 0)
		$server_host = str_replace('www.', '', $server_host);
	return $server_host;
}

/**
 * Generate seo link
 * @package WebLauncher\Functions
 * @param string $input
 * @param string $replace
 * @param bool $remove_words
 * @param array $words_array
 * @return mixed
 */
function generate_seo_link($input, $replace = '-', $remove_words = true, $words_array = array()) {
	//make it lowercase, remove punctuation, remove multiple/leading/ending spaces
	$return = trim(str_replace(' +', ' ', preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($input))));

	//remove words, if not helpful to seo
	//i like my defaults list in remove_words(), so I wont pass that array
	if ($remove_words) { $return = remove_words($return, $replace, $words_array);
	}

	//convert the spaces to whatever the user wants
	//usually a dash or underscore..
	//...then return the value.
	return str_replace(' ', $replace, $return);
}

/**
 * Remove words from string
 * @package WebLauncher\Functions
 * @param string $input
 * @param string $replace
 * @param array $words_array
 * @param bool $unique_words
 * @return string
 */
function remove_words($input, $replace, $words_array = array(), $unique_words = true) {
	//separate all words based on spaces
	$input_array = explode(' ', $input);

	//create the return array
	$return = array();

	//loops through words, remove bad words, keep good ones
	foreach ($input_array as $word) {
		//if it's a word we should add...
		if (!in_array($word, $words_array) && ($unique_words ? !in_array($word, $return) : true)) {
			$return[] = $word;
		}
	}

	//return good words separated by dashes
	return implode($replace, $return);
}

// PHP < 5.5.0
if (!function_exists('array_column')) {
	/**
	 * Array collumn function for php version < 5.5
	 * @package WebLauncher\Functions
	 * @param array $input
	 * @param string $column_key
	 * @param string $index_key
	 * @return array
	 */
	function array_column($input, $column_key, $index_key = null) {
		if ($index_key !== null) {
			// Collect the keys
			$keys = array();
			$i = 0;
			// Counter for numerical keys when key does not exist

			foreach ($input as $row) {
				if (array_key_exists($index_key, $row)) {
					// Update counter for numerical keys
					if (is_numeric($row[$index_key]) || is_bool($row[$index_key])) {
						$i = max($i, (int)$row[$index_key] + 1);
					}

					// Get the key from a single column of the array
					$keys[] = $row[$index_key];
				} else {
					// The key does not exist, use numerical indexing
					$keys[] = $i++;
				}
			}
		}

		if ($column_key !== null) {
			// Collect the values
			$values = array();
			$i = 0;
			// Counter for removing keys

			foreach ($input as $row) {
				if (array_key_exists($column_key, $row)) {
					// Get the values from a single column of the input array
					$values[] = $row[$column_key];
					$i++;
				} elseif (isset($keys)) {
					// Values does not exist, also drop the key for it
					array_splice($keys, $i, 1);
				}
			}
		} else {
			// Get the full arrays
			$values = array_values($input);
		}

		if ($index_key !== null) {
			return array_combine($keys, $values);
		}

		return $values;
	}

}

function ucwords_d($string,$delimiter=''){
	if($delimiter) {
		return implode('_',array_map('ucwords',explode($delimiter,$string)));
	}
	else {
		return ucwords($string);
	}
}