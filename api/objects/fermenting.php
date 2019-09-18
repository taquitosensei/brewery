<?php

class Fermenting{
				private $conn; 
				private $table_name="fermenting"; 
				public $id; 
				public $recipe_id;
				public $pos_id; 
				public $start_date;
				public function __construct($db) { 
								$this->conn = $db; 
				}
				function read(){
								$query = "select
											  f.id as fermenting_id,	
												r.id as recipe_id,
												r.name as recipe_name,
												pos.id as pos_id,
												pos.pos,
												pos.gpio,
												pos.temp_serial,
												f.id,
												f.ferm_pos,
												f.start_date
								from ".$this->table_name." f
								JOIN recipe r on f.recipe_id=r.id 
								JOIN fermenter pos on f.ferm_pos = pos.id; 
								order by pos.pos ASC";
								$stmt = $this->conn->prepare($query); 
								$stmt->execute();

								return($stmt); 
				}

				function create() {
								$query ="insert into ".$this->table_name." set ferm_pos= :pos_id ,recipe_id= :recipe_id ,start_date= :start_date, start_gal = :start_gal"; 
								$stmt = $this->conn->prepare($query);
								$this->pos_id=(int)$this->pos_id;
								$this->recipe_id=(int)$this->recipe_id; 
								$this->start_gal = (int)$this->start_gal; 
								$this->gravity = (double)$this->gravity; 
								$this->start_date=$this->start_date; 	

								$stmt->bindParam(":pos_id",$this->pos_id); 
								$stmt->bindParam(":recipe_id", $this->recipe_id);
							  $stmt->bindParam(":start_gal", $this->start_gal); 	
								$stmt->bindParam(":start_date", $this->start_date); 
								if($stmt->execute()) {
												$fermenting_id = $this->conn->lastInsertId();
												$query_gravity = "insert into fermenting_gravity set fermenting_id = :fermenting_id, gravity = :gravity, yeast_gal=0, date = :date";
												$stmt = $this->conn->prepare($query_gravity); 
												$stmt->bindParam(":fermenting_id", $fermenting_id);
												$stmt->bindParam(":gravity", $this->gravity); 
												$stmt->bindParam(":date", $this->start_date);
												if($stmt->execute()) { 
													return true;
												}
								}
								return false; 
				}
				function readOne() {
								$query="select
												r.id as recipe_id,
												r.name as recipe_name, 
												pos.id as pos_id, 
												pos.pos, 
												pos.gpio, 
												pos.temp_serial, 
												f.id, 
												f.ferm_pos, 
												f.start_date
								from ".$this->table_name." f
								JOIN recipe r on f.recipe_id=r.id
								JOIN fermenter pos on f.ferm_pos = pos.id
								where f.id = ? LIMIT 0,1";
								$stmt = $this->conn->prepare($query); 
								$stmt->bindParam(1,$this->id); 
								$stmt->execute(); 
								$row = $stmt->fetch(PDO::FETCH_ASSOC);
								$this->id = $row['id']; 
							 	$this->recipe_id = $row['recipe_id']; 
								$this->recipe_name = $row['recipe_name']; 
								$this->pos_id = $row['pos_id']; 
								$this->pos = $row['pos']; 
								$this->gpio = $row['gpio']; 
								$this->temp_serial = $row['temp_serial'];
								$this->start_date = $row['start_date']; 
								
				}
				function update() {
								if(!empty($this->id)) { 
									$query = "update ".$this->table_name; 
									$sep = " set"; 
									if(!empty($this->pos_id)) {
												$query.=$sep." ferm_pos = :pos_id"; 
												$sep=","; 
									}	
									if(!empty($this->recipe_id)) { 
												$query.=$sep." recipe_id = :recipe_id"; 
												$sep=","; 
									}				
									if(!empty($this->start_date)) { 
												$query.=$sep." start_date = :start_date"; 
									}			
									$query.=" where id = :id"; 
									$stmt = $this->conn->prepare($query);
									$this->id=(int)$this->id; 
									$this->pos_id=(int)$this->pos_id; 
									$this->recipe_id=(int)$this->recipe_id; 
						
									$stmt->bindParam(":id", $this->id); 
									if(!empty($this->pos_id)) $stmt->bindParam(":pos_id", $this->pos_id);
									if(!empty($this->recipe_id)) $stmt->bindParam(":recipe_id", $this->recipe_id); 
									if(!empty($this->start_date)) $stmt->bindParam(":start_date", $this->start_date); 
									if($stmt->execute()) {
												return true;
									}
								}
								return false; 
				}
				function search($keywords) { 
								$query = "select 
												r.id as recipe_id, 
												r.name as recipe_name, 
												pos.id as pos_id, 
												pos.pos,
												pos.gpio, 
												pos.temp_serial, 
												f.id, 
												f.ferm_pos, 
												f.start_date
								from ".$this->table_name." f 
								JOIN recipe r on f.recipe_id = r.id
								JOIN fermenter pos on f.ferm_pos = pos.id
								where r.name like ? order by f.ferm_pos ASC";
								$stmt = $this->conn->prepare($query); 
				
								$keywords = htmlspecialchars(strip_tags($keywords)); 
								$keywords = "%{$keywords}%"; 
								$stmt->bindParam(1, $keywords); 
								$stmt->execute();
								return $stmt; 
				}
				public function readPaging($from_record_num, $records_per_page) { 
								$query = "select 
												r.id as recipe_id,
												r.name as recipe_name,
												pos.id as pos_id, 
												pos.pos,
												pos.gpio, 
												pos.temp_serial, 
												f.id, 
												f.ferm_pos,
												f.start_date
								from ".$this->table_name." f 
								JOIN recipe r on f.recipe_id = r.id 
								JOIN fermenter pos on f.ferm_pos = pos.id
								order by f.ferm_pos DESC limit ?,?"; 
								$stmt = $this->conn->prepare($query); 
								$stmt->bindParam(1, $from_record_num, PDO::PARAM_INT); 
								$stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
							  $stmt->execute(); 
							  return $stmt; 	
				}
				public function count(){ 
								$query="SELECT COUNT(*) as total_rows 
												FROM ".$this->table_name; 
								$stmt = $this->conn->prepare($query); 
								$stmt->execute(); 
								$row = $stmt->fetch(PDO::FETCH_ASSOC);
								return $row['total_rows']; 
				}
}
