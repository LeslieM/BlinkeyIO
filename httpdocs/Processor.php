<?php

	require_once 'Instruction.php';

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
		
		protected $startPosition = array();
		
		protected $goalPosition = array();
		
		//
		// Metheds
		//
		
		/**
		 * Add an instruction to the end of the list
		 * @param Instruction $instruction
		 * @return integer How many instructions are in the list.
		 */
		public function addInstruction(Instruction $instruction) {
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
		
	}