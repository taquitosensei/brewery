<?php
function getTemp($serial) {	
				if(!empty($serial)) {
				$dev_folder="/sys/bus/w1/devices/"; 
				$f=$dev_folder.$serial."/w1_slave"; 
				$lines = file($f); 
				$c=0; 
				foreach($lines as $line) { 
								$line=trim($line); 
								if(substr($line,-3)==='YES') {
												$temp_line = $lines[$c+1]; 
												$temp_line_split=explode(" ",$temp_line); 
												$s="t="; 
												foreach($temp_line_split as $search_field) { 
																if(strpos($search_field, $s)!== false) { 
																	$search_exp=explode("=", $search_field); 
																	$degrees_c=$search_exp[1]/1000; 
																	$degrees_f=($degrees_c*9/5)+32; 
																	return $degrees_f; 					
																}
												}
								}
				}
				} else {
					return "na"; 
				}
}
