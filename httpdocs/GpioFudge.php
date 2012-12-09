<?php

	class GpioFudge {
		
		//
		// Properties
		//
		
		/**
		 * Set this to a revision
		 * @var unknown_type
		 */
		protected $pins;
		
		protected $pinsR1 = array('0', '1', '4', '7', '8', '9', '10', '11', '14', '15', '17', '18', '21', '22', '23', '24', '25');
		//                         |    |                                                            || 
		protected $pinsR2 = array('2', '3', '4', '7', '8', '9', '10', '11', '14', '15', '17', '18', '27', '22', '23', '24', '25');
		
		const DIRECTION_IN = 'in';
		const DIRECTION_OUT = 'out';
		
		protected $validDirections = array(
				self::DIRECTION_IN,
				self::DIRECTION_OUT,
			);
		
		protected $outputLocation = '/sys/class/gpio';
		
		//
		// Methods
		//
		
		/**
		 * Create the GpioFudge object.
		 * @param integer $revision Which revision Pi are you using
		 */
		public function __construct($revision = null) {
			
			
			if(!isset($this->{'pinsR'.$revision}))
				$revision = 1;
			$this->pins = $this->{'pinsR'.$revision};
			
		}
		
		
		/**
		 * Set up a pin
		 * @param integer $pinNo
		 * @param string $direction 
		 * @throws Exception
		 */
		public function setup($pinNo, $direction) {
			// Check if valid BCM number
			if($this->isValidPin($pinNo)) {

				// Try unexporting the pin
				$this->unexport($pinNo);

				// Then export it
				$this->export($pinNo);
		
				// if valid direction then set direction
				if($this->isValidDirection($direction)) {
					if(!file_exists("$this->outputLocation/gpio$pinNo"))
						mkdir("$this->outputLocation/gpio$pinNo", 0770, true);
					file_put_contents("$this->outputLocation/gpio$pinNo/direction", $direction);
				}
		
			} else {
				throw new Exception('Error! Not a valid pin!');
			}
		}
		
		/**
		 * 
		 * @param unknown_type $pinNo
		 * @param unknown_type $value
		 */
		public function output($pinNo, $value) {
			if($this->isValidPin($pinNo)) {
				if(!$this->isExported($pinNo)) {
					$this->export($pinNo);
					$this->setup($pinNo, self::DIRECTION_OUT);
				}
				//if($this->currentDirection($pinNo) == self::DIRECTION_OUT) {
					if(!file_exists("$this->outputLocation/gpio$pinNo"))
						mkdir("$this->outputLocation/gpio$pinNo", 0770, true);
					file_put_contents("$this->outputLocation/gpio$pinNo/value", $value);
				//}
				//else {
				//	echo 'Error! Wrong Direction for this pin! Meant to be out while it is ' . $this->currentDirection($pinNo);
				//}
			}
		}
		
		/**
		 * Check the current value of the pin (does not need to be input)
		 * @param integer $pinNo
		 */
		public function input($pinNo) {
			if($this->isValidPin($pinNo)) {
				if(!$this->isExported($pinNo))
					$this->export($pinNo);
				if(file_exists("$this->outputLocation/gpio$pinNo/value"))
					return file_get_contents("$this->outputLocation/gpio$pinNo/value");
			}
		}
		
		/**
		 * Export this pin
		 * @param integer $pinNo
		 */
		public function export($pinNo) {
			if($this->isValidPin($pinNo))
				file_put_contents("$this->outputLocation/export", $pinNo);
		}
		
		/**
		 * Unexport this pin
		 * @param integer $pinNo
		 */
	//	public function unexport($pinNo) {
	//		if($this->isValidPin($pinNo))
	//			file_put_contents("$this->outputLocation/unexport", $pinNo);
	//	}
		
		/**
		 * Check this is a valid direction
		 * @param string $direction
		 * @return boolean
		 */
		public function isValidDirection($direction) {
			return in_array($direction, $this->validDirections);
		}
		
		/**
		 * Check this is a valid pin number
		 * @param integer $pinNo
		 * @return boolean
		 */
		public function isValidPin($pinNo) {
			return in_array($pinNo, $this->pins);
		}
		
		/**
		 * Almost certainly wont work
		 * @param integer $pinNo
		 */
		public function isExported($pinNo) {
			return file_exists("$this->outputLocation/gpio".$pinNo);
		}
		
		/**
		 * Unexports all the pins
		 */
		public function unexportAll() {
			foreach($pins as $pinNo) {
				if($this->isExported($pinNo))
					$this->unexport($pinNo);
			}
		}
		
		/**
		 * Might not work
		 * @param unknown_type $pinNo
		 */
		public function currentDirection($pinNo) {
			return file_get_contents("$this->outputLocation/gpio$pinNo/direction");
		}
		
		/**
		 * Get the current list of pins
		 */
		public function getPins() {
			return $this->pins;
		}
		
	}