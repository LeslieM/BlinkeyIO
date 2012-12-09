<?php

	/**
	 * A single instruction
	 * @author danielmason
	 */
	class Instruction {
		
		protected $instruction;
		
		const INSTRUCTION_AND          = 'and ';
		const INSTRUCTION_OR           = 'or'  ;
		const INSTRUCTION_XOR          = 'xor' ;
		const INSTRUCTION_EQUAL        = 'equal'  ;
		const INSTRUCTION_GREATER_THAN = 'greaterThan'  ;
		const INSTRUCTION_LESS_THAN    = 'lessThan'  ;
		
		protected static $acceptableInstructions = array(
				self::INSTRUCTION_AND,
				self::INSTRUCTION_OR,
				self::INSTRUCTION_XOR,
				self::INSTRUCTION_EQUAL,
				self::INSTRUCTION_GREATER_THAN,
				self::INSTRUCTION_LESS_THAN,
			);

		public function __construct($instruction = null) {
			$this->setInstruction($instruction);
		}
		
		public function setInstruction($instruction) {
			if(in_array($instruction, self::$acceptableInstructions)) {
				$this->instruction = $instruction;
				return true;
			}
			return false;
		}
		
		/**
		 * Gets the currently set instruction
		 */
		public function getInstruction() {
			return $this->instruction;
		}
		
		/**
		 * Compare valueA to valueB using the set instruction
		 * @param boolean $valueA
		 * @param boolean $valueB
		 * @return boolean or null if instruction was not found
		 */
		public function compare($valueA, $valueB) {
			if(method_exists($this, $this->instruction.'Values'))
				return $this->{$this->instruction.'Values'}($valueA, $valueB);
		}
		
		/**
		 * Are ValueA and ValueB true
		 * @param boolean $valueA
		 * @param boolean $valueB
		 * @return boolean
		 */
		protected function andValues($valueA, $valueB) {
			return ($valueA==1 && $valueB==1) ? 1 : 0;
		}
		
		/**
		 * Are neither ValueA or ValueB true
		 * @param boolean $valueA
		 * @param boolean $valueB
		 * @return boolean
		 */
		protected function nandValues($valueA, $valueB) {
			return !($valueA==1 && $valueB==1) ? 1 : 0;
		}
		
		/**
		 * Are either ValueA or ValueB true
		 * @param boolean $valueA
		 * @param boolean $valueB
		 * @return boolean
		 */
		protected function orValues($valueA, $valueB) {
			return ($valueA==1 || $valueB==1) ? 1 : 0;
		}
		
		/**
		 * Are either ValueA or ValueB (but not both) true
		 * @param boolean $valueA
		 * @param boolean $valueB
		 * @return boolean
		 */
		protected function xorValues($valueA, $valueB) {
			return ($valueA==1 ^ $valueB==1) ? 1 : 0;
		}
		
		/**
		 * Are ValueA and ValueB equal
		 * @param boolean $valueA
		 * @param boolean $valueB
		 * @return boolean
		 */
		protected function equalValues($valueA, $valueB) {
			return ($valueA == $valueB) ? 1 : 0;
		}
		
		/**
		 * Is valueA greater than ValueB
		 * @param boolean $valueA
		 * @param boolean $valueB
		 * @return boolean
		 */
		protected function greaterThanValues($valueA, $valueB) {
			return ($valueA > $valueB) ? 1 : 0;
		}
		
		/**
		 * Is valueA less than ValueB
		 * @param boolean $valueA
		 * @param boolean $valueB
		 * @return boolean
		 */
		protected function lessThanValues($valueA, $valueB) {
			return ($valueA < $valueB) ? 1 : 0;
		}
		
	}
	
	