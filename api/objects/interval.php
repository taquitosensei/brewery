<?php
class Interval{
				private $conn; 
				private $table_name="recipe_intervals"; 
				public $id;
				public $days; 
				public $start_temp;
				public $end_temp; 
				public $recipe_id; 
				public function __construct($db) { 
								$this->conn = $db; 
				}
				function read(){
								$query = "select i.id, i.days, i.start_temp, i.end_temp,i.recipe_interval,r.name,i.recipe_id,i.recipe_interval from ".$this->table_name." i JOIN recipe r on i.recipe_id = r.id";
								if(!empty($this->id)) {
												$query.=" where i.recipe_id = ?"; 
								}	
								$query.=" order by r.id,i.recipe_interval";
								$stmt = $this->conn->prepare($query);
								if(!empty($this->id)) { 
									$stmt->bindParam(1,$this->id); 
								}
								$stmt->execute(); 
								return($stmt); 
				}

				function create() {
								$query ="insert into ".$this->table_name." set days = :days ,start_temp = :start_temp ,end_temp = :end_temp, recipe_id = :recipe_id, recipe_interval = :recipe_interval"; 
								$stmt = $this->conn->prepare($query);
							  $this->days=(int)$this->days; 
								$this->start_temp=(int)$this->start_temp; 	
								$this->end_temp=(int)$this->end_temp;
								$this->recipe_id=(int)$this->recipe_id; 
								$this->recipe_interval=(int)$this->recipe_interval;

								$stmt->bindParam(":days",$this->days); 
								$stmt->bindParam(":start_temp", $this->start_temp); 
								$stmt->bindParam(":end_temp", $this->end_temp); 
								$stmt->bindParam(":recipe_id", $this->recipe_id); 
								$stmt->bindParam(":recipe_interval", $this->recipe_interval); 
								if($stmt->execute()) { 
												return true;
								}
								return false; 
				}
				function readOne() {
								$query="select i.id, i.days, i.start_temp,i.end_temp,i.recipe_interval, r.name, i.recipe_id from ".$this->table_name." i JOIN recipe r on i.recipe_id = r.id where i.id = ? LIMIT 0,1";
								$stmt = $this->conn->prepare($query); 
								$stmt->bindParam(1,$this->id); 
								$stmt->execute(); 
								$row = $stmt->fetch(PDO::FETCH_ASSOC);
							  $this->name = $row['name']; 	
								$this->days = $row['days']; 
								$this->start_temp = $row['start_temp']; 
								$this->end_temp = $row['end_temp'];
								$this->recipe_id = $row['recipe_id']; 
								$this->recipe_interval = $row['recipe_interval']; 
				}
				function update() {
								$query = "update ".$this->table_name." set days = :days, start_temp = :start_temp, end_temp = :end_temp, recipe_interval = :recipe_interval where id =  :id"; 
								$stmt = $this->conn->prepare($query);
								$this->id=(int)$this->id; 
								$this->days=(int)$this->days; 
								$this->start_temp=(int)$this->start_temp;
							  $this->end_temp=(int)$this->end_temp; 
								$this->recipe_interval=(int)$this->recipe_interval; 

								$stmt->bindParam(":id", $this->id); 
								$stmt->bindParam(":days", $this->days);
								$stmt->bindParam(":start_temp", $this->start_temp); 
								$stmt->bindParam(":end_temp", $this->end_temp); 
								$stmt->bindParam(":recipe_interval", $this->recipe_interval); 
								if($stmt->execute()) {
												
												return true;
								}
								return false; 
				}
				function delete() { 
								$query = "delete from ".$this->table_name." where id = :id";
								$stmt = $this->conn->prepare($query); 
								$this->id=(int)$this->id; 
								$stmt->bindParam(":id", $this->id); 
								if($stmt->execute()) { 
												return true; 
								} 
								return false; 
				}
				public function count(){ 
								$query="SELECT COUNT(*) as total_rows FROM ".$this->table_name; 
								$stmt = $this->conn->prepare($query); 
								$stmt->execute(); 
								$row = $stmt->fetch(PDO::FETCH_ASSOC);
								return $row['total_rows']; 
				}
				/*
				function getTemp() {
								if(!empty($this->temp_serial)) {
									$dev_folder="/sys/bus/w1/devices/"; 
									$f=$dev_folder.$this->temp_serial."/w1_slave"; 
									$lines = file($f); 
									$c=0; 
									foreach($lines as $line) { 
										$line=trim($line); 
										if(substr($line,-3)==='YES') { 
														$temp_line = $lines[$c+1]; 
														$temp_line_split = explode(" ", $temp_line); 
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
								}
								return false; 
				}
				 */
}
