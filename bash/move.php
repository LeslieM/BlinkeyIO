<?php

	$startLocation = '/var/gpio';
	$endLocation = '/sys/class/gpio';
	
	function microseconds($seconds) {
		return $seconds * 1000000;
	}
	
	function isReadable($filename) {
		return (fileperms($filename)&0x0100 > 0); 
	}
	
	function isWriteable($filename) {
		return (fileperms($filename)&0x0080 > 0);
	}
	
	function copyFilesToGpio() {
		
		global $startLocation, $endLocation;
		
		$copied = array();
		
		foreach (
				$iterator = new RecursiveIteratorIterator(
						new RecursiveDirectoryIterator($startLocation, RecursiveDirectoryIterator::SKIP_DOTS),
						RecursiveIteratorIterator::SELF_FIRST) as $inFile
		) {
			$outFile = "$endLocation/{$iterator->getSubPathName()}";
			//echo "input: $inFile - ". (file_exists($inFile) ? 'exists' : 'doesn\'t exist') . "\n";
			//echo "output: $outFile - ". (file_exists($outFile) ? 'exists' : 'doesn\'t exist') . "\n";
			$copyPossible = is_file($inFile) && file_exists($outFile);
			if($copyPossible && !in_array($inFile, $copied)) {
				//echo "$outFile: ".(isReadable($outFile))." ".isWriteable($outFile)."\n";
				echo $inFile."\n";
				if(!isReadable($outFile) || file_get_contents($inFile) != file_get_contents($outFile)) {
					file_put_contents($outFile, file_get_contents($inFile));
					$copied[] = $inFile;
					echo $inFile."\n";
				}
				
				/**/
			}
		}
		
	}
	
	while(!file_exists("$startLocation/stop")) {
		
		copyFilesToGpio();
		
		usleep(microseconds(2));
		
	}