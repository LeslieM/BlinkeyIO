<?php

	while (true) {
		usleep(100000);
		exec('chmod 0777 /sys/class/gpio/gpio*/value');
	}