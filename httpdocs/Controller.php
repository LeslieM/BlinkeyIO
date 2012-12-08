<?php

	require_once 'Tools.php';
	require_once 'Session.php';

	class Controller  {
		
		protected $request;
		protected $requestedPath;
		protected $instructions;
		
		protected static $template = '../templates/index.php';
		
		public function __construct() {
			$this->request = Tools::arrayToObject($_REQUEST);
			$this->requestedPath = explode('/', $_SERVER['REQUEST_URI']);
			$this->session = Session::getSession();
		}
		
		/**
		 * Calls the requested action
		 * @param string $action
		 */
		public function callAction($action = null) {
			
			if(!method_exists($this, $action.'Action'))
				$action = 'index';
			
			$this->{$action.'Action'}();
			
			require_once self::$template;
			
		}
		
		//
		// Actions
		//
		
		protected function indexAction() {
			
			echo 'index';
			
		}
		
		protected function addAction() {
			
			echo 'add';
			
		}
		
		
		
	}