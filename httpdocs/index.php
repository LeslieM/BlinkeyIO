<?php
	
	require_once 'Controller.php';
	
	
	$controller = new Controller();
	$controller->callApiAction();
	
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