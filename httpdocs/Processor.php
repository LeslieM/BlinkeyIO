<?php

	require_once 'Instruction.php';
	require_once 'Session.php';
	require_once 'GpioFudge.php';

	class Processor extends Session {
		
		//
		// Properties
		//
		
		/**
		 * The current position in instruction list
		 * @var integer
		 */
		protected $currentPosition = 0;
		
		/**
		 * An array of instruction objects
		 * @var Instruction[]
		 */
		protected $instructions = array();
		
		/**
		 * What are the starting two lights
		 * @var integer[]
		 */
		protected $startPosition = array();
		
		/**
		 * What do the lights need to look like
		 * @var integer[]
		 */
		protected $goalPosition = array();
		
		/**
		 * What do the lights actually look like
		 * @var integer[]
		 */
		protected $actualPositions = array();
		
		/**
		 * Number of lights being used
		 * @var integer
		 */
		protected $nLights = 7;
		
		
		/**
		 * GPIO controller object
		 * @var GpioFudge
		 */
		protected $gpio;
		
		/**
		 * Has this object been initialised
		 * @var unknown_type
		 */
		public $initialised;
		
		//
		// Metheds
		//
		
		/**
		 * Initialise the device
		 */
		
		public function initialise() {
			
			$this->gpio = new GpioFudge();
			
			// Choose the statring two lights
			$this->startPosition = array();
			$this->startPosition[0] = $this->getRandomSetting();
			if($this->startPosition[0] == 0)
				$this->startPosition[1] = 1;
			else
				$this->startPosition[] = $this->getRandomSetting();
			
			// Choose the ending positions
			$this->goalPosition = array();

			// The starting lights are still the same at the end
			$this->goalPosition[0] = $this->startPosition[0];
			$this->goalPosition[1] = $this->startPosition[1];
			
			// Randomise the rest of the lights
			for($i = 2; $i < $this->nLights; $i++)
				$this->goalPosition[$i] = $this->getRandomSetting();
			
		}
		
		public function stepThroughInstructionsWithGpioOutput() {
			
			$this->actualPositions = array();
			$this->actualPositions[0] = $this->startPosition[0];
			$this->actualPositions[1] = $this->startPosition[1];
			
			$end = ($this->nLights < count($this->instructions)) ? $this->nLights : count($this->instructions);
			
			for($i = 2; $i < $end; $i++) {
				/* @var $instruction Instruction */
				$instruction = $this->instructions[$i-2];
				$this->actualPositions[$i] = $instruction->compare($this->actualPositions[$i-2], $this->actualPositions[$i-1]);
				
				$pinNo = $this->getGpioPinForPosition($i);
				$this->gpio->output($pinNo, $this->actualPositions[$i]);
				
				sleep(1);
			}
			
		}
		
		public function hasWon() {
			foreach($this->goalPosition as $i => $goal)
				if($this->actualPositions[$i] != $goal)
					return false;
			return true;
		}
		
		/**
		 * Creates an instruction from a string and 
		 * @param $instruction
		 */
		public function addInstruction($instruction) {
			$instructionObject = new Instruction();
			if($instructionObject->setInstruction($instruction)) {
				$this->addInstructionObject($instructionObject);
				return true;
			}
			return false;
		}
		
		/**
		 * Add an instruction object to the end of the list
		 * @param Instruction $instruction
		 * @return integer How many instructions are in the list.
		 */
		public function addInstructionObject(Instruction $instruction) {
			$this->instructions[] = $instruction;
			return count($this->instructions);
		}
		
		/**
		 * Change the instruction at a given position
		 * @param integer $position
		 * @param Instruction $newInstruction
		 */
		public function changeInstruction($position, Instruction $newInstruction) {
			if((int)$position == $position) {
				$this->instructions[$position] = $newInstruction;
				return true;
			}
			return false;
		}
		
		/**
		 * Delete the instruction in the given position
		 * If no position is given the last one is deleted
		 * @param integer position
		 */
		public function deleteInstruction($position = null) {
			if($position === null)
				$position = count($this->instructions) - 1;
			if($position >= 0) {
				$newInstructions = array(); 
				foreach($this->instructions as $i => $instruction) {
					if($i != $position)
						$newInstructions[] = $instruction;
				}
			}
		}
		
		/**
		 * Get the current instruction object
		 * @param integer $postion
		 * @return Instruction
		 */
		public function getInstruction($postion) {
			return $this->instructions[(int)$position];
		}
		
		/**
		 * Compares two values with the instruction at a given position
		 * If no position is given it will use the current position
		 * @param boolean $valueA
		 * @param boolean $valueB
		 * @param integer $position
		 */
		public function compareValues($valueA, $valueB, $position = null) {
			if($position === null)
				$position = $this->currentPosition;
			$result = $this->getInstruction($postion)->compare($valueA, $valueB);
			$this->currentPosition = $position + 1;
			if($this->currentPosition >= count($this->instructions))
				$this->currentPosition = 0;
			return $result;
		}
		
		/**
		 * Returns either a 0 or 1
		 */
		protected function getRandomSetting() {
			return mt_rand(0, 1);
		}
		
		/**
		 * Returns the gpio number for the given pin position
		 * @param integer $position
		 */
		protected function getGpioPinForPosition($position) {
			$pins = $this->gpio->getPins();
			return $pins[$position+10];
		}
		
	}