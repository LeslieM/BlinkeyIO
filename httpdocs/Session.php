<?php
	
	/**
	 * Loft_Util_Session
	 * @author Daniel Mason
	 * @copyright Loft Digital, 2012
	 * @package LiveObjects
	 * @example
	 * 
	 * class Counter extends Loft_Util_Session {
	 *     public $count;
	 * }
	 * 
	 * $count = Counter::getSession();
	 * echo $count->count++;
	 * $count2 = Counter::getSession('count2');
	 * echo $count2->count+=2;
	 * 
	 */

	class Session {
		
		/**
		 * The key into session where this object is stored.
		 * @var string
		 */
		protected $_namespace;
		
		/**
		 * This class can not be instantiated directly, use ::getSession()
		 * @param string $namespace
		 */
		protected function __construct($namespace) {
			$this->_namespace = $namespace;
		}
		
		/**
		 * Returns the object is already in the session, if not it will creat a new one.
		 * @param string $namespace Can be changed for new storage location
		 * @return Util_Session
		 */
		public static function getSession($namespace = null) {
		
			
			if(!session_id())
				session_start();
			
			$class = get_called_class();
			
			if(!$namespace)
				$namespace = $class;
			
			if(isset($_SESSION[$namespace])) {
				if(get_class($_SESSION[$namespace]) === $class) // Check the right thing is stored here
					return $_SESSION[$namespace];
				else
					throw new Exception('Object in session does not match object requested');
			}
			else {
				// Create the object in the session and return a reference to it
				$_SESSION[$namespace] = new $class($namespace);
				return $_SESSION[$namespace];
			}
		
		}
		
		/**
		 * Returns the namespace that this object is beign stored in.
		 */
		public function getNamespace() {
			return $this->_namespace;
		}
		
		/**
		 * Cleans the the object from the session.
		 * Note: This does not delete the class that calls this function
		 */
		public function cleanSession() {
			unset($_SESSION[$this->getNamespace()]);
		}
		
	}