<?php 
	class GPIO {

		const DIRECTION_IN  = 'in';
		const DIRECTION_OUT = 'out';
		
		const REVISION_1 = 'R1';
		const REVISION_2 = 'R2';
		
		// Using BCM pin numbers.
		private $pins;
		
		private $pinsR1 = array('0', '1', '4', '7', '8', '9', '10', '11', '14', '15', '17', '18', '21', '22', '23', '24', '25');
		//                       |    |                                                            || 
		private $pinsR2 = array('2', '3', '4', '7', '8', '9', '10', '11', '14', '15', '17', '18', '27', '22', '23', '24', '25');
		
		public function __construct($revision = null) {
			if(!isset($this->{'pinsR'.$revision}))
				$revision = 1;
			$this->pins = $this->{'pinsR'.$revision};
		}

		// exported pins for when we unexport all
		private $exportedPins = array();

		// Setup pin, takes pin number and direction (in or out)
		public function setup($pinNo, $direction) {
			// Check if valid BCM number
			if($this->isValidPin($pinNo)) {
				// if exported, unexport it first
				if($this->isExported($pinNo)) {
					$this->unexport($pinNo);
				}

				// Export pin
				file_put_contents('/sys/class/gpio/export', $pinNo);

				// if valid direction then set direction
				if($this->isValidDirection($direction)) {
					file_put_contents('/sys/class/gpio/gpio'.$pinNo.'/direction', $direction);
				}

				// Add to exported pins array
				$exportedPins[] = $pinNo;
			} else {
				throw new Exception('Error! Not a valid pin!');
			}
		}

		public function input($pinNo) {
			if($this->isExported($pinNo)) {
				//if($this->currentDirection($pinNo) != "out") {
					return file_get_contents('/sys/class/gpio/gpio'.$pinNo.'/value');
				//}
			}
		}

		// Value == 1 or 0, where 1 = on, 0 = off
		public function output($pinNo, $value) {
			if($this->isExported($pinNo)) {
				if($this->currentDirection($pinNo) != "in") {
					if(file_put_contents('/sys/class/gpio/gpio'.$pinNo.'/value', $value) === false)
						echo 'Argh!';
				} else {
					echo 'Error! Wrong Direction for this pin! Meant to be out while it is ' . $this->currentDirection($pinNo);
				}
			}
		}

		public function unexport($pinNo) {
			if($this->isExported($pinNo)) {
				file_put_contents('/sys/class/gpio/unexport', $pinNo);
				foreach ($this->exportedPins as $key => $value) {
					if($value == $pinNo) unset($key);
				}
			}
		}

		//public function unexportAll() {
		//	foreach ($this->exportedPins as $key => $pinNo) file_put_contents('/sys/class/gpio/unexport', $pinNo);
		//	$this->exportedPins = array();
		//}

		// Check if exported
		public function isExported($pinNo) {
			return file_exists('/sys/class/gpio/gpio'.$pinNo);
		}

		public function currentDirection($pinNo) {
			return file_get_contents('/sys/class/gpio/gpio'.$pinNo.'/direction');
		}

		// Check for valid direction, in or out
		public function isValidDirection($direction) {
			return (($direction == "in") || ($direction == "out"));
		}

		// Check for valid pin
		public function isValidPin($pinNo) {
			return in_array($pinNo, $this->pins);
		}
		
		public function unexportAll() {
			foreach($pins as $pin) {
				if($this->isExported($pin))
					$this->unexport($pin);
			}
		}
		
		/**
		 * Get the current list of pins
		 */
		public function getPins() {
			return $this->pins;
		}
	}
?>