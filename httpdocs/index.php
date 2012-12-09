<?php
	echo 'hi';
	require_once 'Controller.php';
	require_once 'GPIO.php';
	
	$gpio = new GPIO();
	$gpio->unexportAll();
	
	$gpio->setup(27, 'out');
	$gpio->output(27, 1);
	
	/*
	$controller = new Controller();
	$controller->callAction();
	
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