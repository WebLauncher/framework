<?php
	/**
	 * Tables Manager Class
	 */
	/**
	 * DB Tables Manager
	 * @package WebLauncher\Managers
	 */
	class TablesManager implements ArrayAccess{
		/**
		 * ArrayAccess set
		 * @param string $offset 
		 * @param string $value
		 */
		public function offsetSet($offset, $value) {
			global $page;        
	        $page->tables->{$offset} = $this->_cleanValue($value);
	    }
		/**
		 * ArrayAccess exists
		 * @param string $offset
		 */
	    public function offsetExists($offset) {
	    	global $page;
            $offset=$this->_cleanValue($offset);
			if(!isset($page->tables->{$offset}))
				$page->tables->{$offset}=$offset;
	        return isset($page->tables->{$offset});
	    }
		/**
		 * ArrayAccess unset
		 * @param string $offset
		 */
	    public function offsetUnset($offset) {
	    	global $page;
            $offset=$this->_cleanValue($offset);
	        unset($page->tables->{$offset});
	    }
		/**
		 * ArrayAccess get
		 * @param string $offset
		 */
	    public function offsetGet($offset) {
	    	global $page;
            $offset=$this->_cleanValue($offset);
	        return isset($page->tables->{$offset}) ? $page->tables->{$offset} : $offset;
	    }
		/**
		 * Magic method get
		 * @param string $name
		 */
		public function __get($name){
			global $page;
            $name=$this->_cleanValue($name);
			return $this[$name];
		}
		/**
		 * Magic method set
		 * @param string $name
		 * @param string $value
		 */
		public function __set($name,$value){
            $name=$this->_cleanValue($name);
            $value=$this->_cleanValue($value);
			$this[$name]=$value;
		}	
        /**
         * Clean old tbl_ and trigger error
         * @param string $value
         */
        private function _cleanValue($value){
            return substr( $value, 0, 4 )=='tbl_'?substr($value,4):$value;
        }
	}
?>
