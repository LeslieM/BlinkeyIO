<?php

	require_once 'Tools.php';
	require_once 'Processor.php';

	class Controller  {
		
		protected $request;
		protected $requestedPath;
		/**
		 * The processor object
		 * @var Processor
		 */
		protected $processor;
		
		protected static $template = '../templates/index.php';
		
		public function __construct() {
			$this->request = Tools::arrayToObject($_REQUEST);
			$this->requestedPath = explode('/', $_SERVER['REQUEST_URI']);
			$this->processor = Processor::getSession();
		}
		
		/**
		 * Calls the requested action
		 * @param string $action
		 */
		public function callAction($action = null, $parameters = null) {
			
			if(!method_exists($this, $action.'Action'))
				$action = 'index';
			
			$this->{$action.'Action'}($parameters);
			
			require_once self::$template;
			exit;
			
		}
		
		
		
		//
		// Actions
		//
		
		protected function indexAction() {
			
			
			
		}
		
		protected function executeAction() {
			
			if(!isset($this->request->instructions))
				$this->callAction('index'); // Script terminates
			
			// Set up the instructions
			$instructions = (array)$this->request->instructions;
			foreach($instructions as $instruction)
				$this->processor->addInstruction($instruction);
			
			$this->processor->stepThroughInstructionsWithGpioOutput();
			
		}
		
		/**
		 * Resets the processor
		 */
		protected function resetAction() {
			
			$this->processor->cleanSession();
			$this->processor = Processor::getSession();
			
		}
		
		/**
		 * @deprecated
		 * @param unknown_type $instruction
		 */
		protected function addAction($instruction) {
			
			
			
		}
		
		
		
	}