<?php
	
	require_once 'Controller.php';
	require_once 'GpioFudge.php';
	require_once 'Session.php';
	
	$counter = Session::getSession();
	$counter->cleanSession();
	$gpio = new GpioFudge(2);
	$pins = $gpio->getPins();
	var_dump($pins);
	$counter->count = $counter->count+1;
	$gpio->export($pins[$counter->count]);
	$gpio->setup($pins[$counter->count], GpioFudge::DIRECTION_OUT);
	$gpio->output($pins[$counter->count], 1);
	echo $pins[$counter->count];
	//$controller = new Controller();
	//$controller->callApiAction();
	
	/*
	
	 1 0 0 0 0 0 0 0 0 0
	 
	 OR
	 
	 1 0 1
	 
	 OR
	 
	 1 0 1 1
	 
	 NAND
	 
	 1 0 1 1 0
	 
	 OR
	 
	 1 0 1 1 0 1
	 
	 OR
	 
	 1 0 1 1 0 1 1
	 
	 NAND
	 
	 1 0 1 1 0 1 1 0
	 
	 AND
	 
	 1 0 1 1 0 1 1 0 0
	 
	 NAND
	 
	 1 0 1 1 0 1 1 0 0 1
	 
	 */