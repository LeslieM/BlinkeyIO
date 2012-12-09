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
			if(!$this->processor->initialised)
				$this->processor->initialise();
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
		
		public function callApiAction() {
			
			if(isset($this->request->execute))
				$this->callAction('execute'); // Ends script
			
			$this->callAction('index'); // Ends script
			
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
			$this->processor->clearInstructions();
			$instructions = (array)$this->request->instructions;
			foreach($instructions as $instruction)
				$this->processor->addInstruction($instruction);
			var_dump($this->processor->getInstructions());
			$this->processor->stepThroughInstructionsWithGpioOutput();
			
			echo $this->processor->hasWon();
			exit;
			
		}
		
		/**
		 * Resets the processor
		 */
		protected function resetAction() {
			
			$this->processor->cleanSession();
			$this->processor = Processor::getSession();
			
		}
		
		
		
	}