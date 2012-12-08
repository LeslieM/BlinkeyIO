<?php

	require_once 'Instruction.php';

	class Instructions extends Session {
		
		public $currentPosition = 0;
		public $instructions = array();
		
		public function addInstruction(Instruction $instruction) {
			$this->instructions;
		}
		
		public function changeInstruction($position, Instruction $newInstruction) {
			
		}
		
	}