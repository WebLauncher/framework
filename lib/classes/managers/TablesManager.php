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
	        $page->tables->{$offset} = $value;        
	    }
		/**
		 * ArrayAccess exists
		 * @param string $offset
		 */
	    public function offsetExists($offset) {
	    	global $page;
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
	        unset($page->tables->{$offset});
	    }
		/**
		 * ArrayAccess get
		 * @param string $offset
		 */
	    public function offsetGet($offset) {
	    	global $page;
	        return isset($page->tables->{$offset}) ? $page->tables->{$offset} : $offset;
	    }
		/**
		 * Magic method get
		 * @param string $name
		 */
		public function __get($name){
			global $page;
			return $this[$name];
		}
		/**
		 * Magic method set
		 * @param string $name
		 * @param string $value
		 */
		public function __set($name,$value){
			$this[$name]=$value;
		}	
	}
?>
