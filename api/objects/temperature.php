<?php
class Temp{
				private $conn; 
				private $table_name="fermenting_temp"; 
				private $dev_folder ="/sys/bus/w1/devices/"; 
				public $id; 
				public $temp; 
				public $date; 
				public $gpio; 
				public $valve_state='close';
				public $degrees_f; 
				public $degrees_c;
			  public $fermenting_id;	
				public function __construct($db) { 
								$this->conn = $db; 
				}	
				function readTemp() {
					$gpio = (int)$this->gpio; 
					$temp_serial = $this->temp_serial;
					$f = $this->dev_folder.$temp_serial."/w1_slave"; 
					if(is_file($f)) { 
					$lines = file($f); 
					$c=0; 
					foreach($lines as $line) { 
						$line=trim($line); 
						if(substr($line,-3)=='YES') {
							$temp_line=$lines[$c+1]; 
							$temp_line_split=explode(" ",$temp_line); 
							$searchword="t="; 
							foreach($temp_line_split as $search_field) {
								if(strpos($search_field,$searchword)!==false) { 
									$search_exp=explode("=", $search_field); 
									$this->degrees_c=$search_exp[1]/1000; 
									$this->degrees_f=($this->degrees_c*9/5)+32; 
								}
							}
						}
						$c++; 
					}
					}
				}
				function addTemp() {
								$query = "insert into fermenting_temp set temp = :temp,date = :date,fermenting_id = :fermenting_id"; 
								$stmt = $this->conn->prepare($query); 
								$fermenting_id = (int)$this->fermenting_id; 
								$temp = (int)$this->degrees_f; 
								$date = $this->date;

								$stmt->bindParam(":temp", $temp); 
								$stmt->bindParam(":date", $date); 
								$stmt->bindParam(":fermenting_id", $fermenting_id); 
								if($stmt->execute()) { 
												return true;
								}
								return false; 
				}
				function valve() { 
								$gpio_lock_file = "/var/www/html/cron/gpio_".$this->gpio.".lock";
							 	echo $gpio_lock_file; 	
								switch($this->valve_state) {
									case "open": 
										if(!is_file($gpio_lock_file)) {
											exec('sudo /var/www/html/cron/php-gpio/openvalve '.$this->gpio.' open'); 
											file_put_contents($gpio_lock_file,"1");
										} 
									break; 
									case "closed": 
										if(is_file($gpio_lock_file)) { 
											exec('sudo /var/www/html/cron/php-gpio/openvalve '.$this->gpio.' closed');
											unlink($gpio_lock_file); 
										}
								  break; 
								}
				}
}
