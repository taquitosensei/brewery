<?php
class Fermenter{
				private $conn; 
				private $table_name="fermenter"; 
				public $id; 
				public $name;
				public function __construct($db) { 
								$this->conn = $db; 
				}
				function read(){
								$query = "select f.active,f.id,f.pos,f.gpio,f.temp_serial from ".$this->table_name." f order by f.pos ASC";
								$stmt = $this->conn->prepare($query); 
								$stmt->execute(); 
								return($stmt); 
				}

				function create() {
								$query ="insert into ".$this->table_name." set pos=:pos,gpio=:gpio,temp_serial=:temp_serial, active=true"; 
								$stmt = $this->conn->prepare($query);
							  $this->pos=(int)$this->name; 
								$this->gpio=(int)$this->name; 	
								$this->temp_serial=htmlspecialchars(strip_tags($this->temp_serial));

								$stmt->bindParam(":pos",$this->pos); 
								$stmt->bindParam(":gpio", $this->gpio); 
								$stmt->bindParam(":temp_serial", $this->temp_serial); 
								if($stmt->execute()) { 
												return true;
								}
								return false; 
				}
				function readOne() {
								$query="select f.active, f.pos,f.gpio,f.temp_serial from ".$this->table_name." f where f.id = ? LIMIT 0,1";
								$stmt = $this->conn->prepare($query); 
								$stmt->bindParam(1,$this->id); 
								$stmt->execute(); 
								$row = $stmt->fetch(PDO::FETCH_ASSOC); 
								$this->pos = $row['pos']; 
								$this->gpio = $row['gpio']; 
								$this->temp_serial = $row['temp_serial'];
				}
				function update() { 
								$query = "update ".$this->table_name." set pos= :pos ,gpio= :gpio ,temp_serial = :temp_serial, active = :active where id = :id";
								$stmt = $this->conn->prepare($query);
								$this->id=(int)$this->id; 
								$this->pos=(int)$this->pos; 
								$this->gpio=(int)$this->gpio; 
								$this->temp_serial=htmlspecialchars(strip_tags($this->temp_serial));
								$this->active=is_bool($this->active)?false:true; 
								$stmt->bindParam(":id", $this->id); 
								$stmt->bindParam(":pos", $this->pos);
								$stmt->bindParam(":gpio", $this->gpio); 
								$stmt->bindParam(":temp_serial", $this->temp_serial);
							  $stmt->bindParam(":active", $this->active); 	
								if($stmt->execute()) {
												return true;
								}
								return false; 
				}
				function search($keywords) { 
								$query = "select f.active, f.id, f.pos, f.gpio, fp.temp_serial from ".$this->table_name." f where f.id = ? or f.pos = ? or f.gpio = ? or f.temp_serial like ? order by r.name DESC"; 
								$stmt = $this->conn->prepare($query); 
				
								$keywords = htmlspecialchars(strip_tags($keywords)); 
								$keywords_like = "%{$keywords}%"; 
								$stmt->bindParam(1, $keywords); 
								$stmt->bindParam(2, $keywords); 
								$stmt->bindParam(3, $keywords); 
								$stmt->bindParam(4, $keywords_like); 
								$stmt->execute(); 
								return $stmt; 
				}
				public function readPaging($from_record_num, $records_per_page) { 
								$query = "select f.active, f.id,f.pos,f.gpio,f.temp_serial from ".$this->table_name." f order by f.pos DESC limit ?,?"; 
								$stmt = $this->conn->prepare($query); 
								$stmt->bindParam(1, $from_record_num, PDO::PARAM_INT); 
								$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
							  $stmt->execute(); 
							  return $stmt; 	
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
