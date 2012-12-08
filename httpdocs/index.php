<?php

	require_once 'GPIO.php';
	
	$gpio = new GPIO(GPIO::REVISION_2);
	
	$gpio->unexportAll();
//	$gpio->setup(27, 'out');
//	$gpio->output(27, 0);