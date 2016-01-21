<?php
	/**
	 * Browser Info
	 */
	/**
	 * Browser Info Class
	 * @package WebLauncher\Infos
	 * @example $this->system->browser
	 */
	class BrowserInfo
	{
		/**
		 * The user agent of the request
		 */
		static $USER_AGENT = ''; // STRING - USER_AGENT_STRING
		static $INFO=false;
		
		/**
		 * Get browser info
		 * @param string $UA
		 * @return array
		 */
		public static function get($UA){
			if(!self::$INFO) {
				$info = get_browser($UA, true);

				self::$USER_AGENT = $UA;

				$arr = array();
				$arr['user_agent'] = self::$USER_AGENT;
				$arr['os'] = $info['platform'];
				$arr['os_version'] = $info['platform'];
				$arr['browser'] = $info['browser'];
				$arr['browser_version'] = $info['version'];
				$arr['net_clr'] = strpos(self::$USER_AGENT, 'NET CLR') !== FALSE;
				$arr['resolved'] = 1;
				$arr['type'] = $info['device_type'];

				self::$INFO=array_merge($info,$arr);
			}
			return self::$INFO;
		}
		
		/**
		 * Get user ip
		 */
		public static function get_user_ip(){
			if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		    {
		      $ip=$_SERVER['HTTP_CLIENT_IP'];
		    }
		    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		    {
		      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		    }
		    else
		    {
		      $ip=isset_or($_SERVER['REMOTE_ADDR']);
		    }
		    return $ip;
		}
	}
?>
