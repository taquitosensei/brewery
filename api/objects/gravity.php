<?php
class Gravity{
				private $conn;
				private $table_name="fermenting_gravity"; 
				public $id; 
				public $fermenting_id; 
				public $gravity; 
				public $yeast_gal;
				public $date; 
				public function __construct($db) { 
								$this->conn = $db; 
				}
				function read() { 
								$query="select r.name,p.pos,g.id,g.fermenting_id,g.gravity,g.yeast_gal,g.date from ".$this->table_name." g JOIN fermenting f on g.fermenting_id=f.id JOIN fermenter p on f.ferm_pos=p.id JOIN recipe r on f.recipe_id=r.id";
								if(!empty($this->fermenting_id)) { 
												$query.=" where g.fermenting_id = ?"; 
								}	
								$query.=" order by date DESC";
								$stmt = $this->conn->prepare($query);
								if(!empty($this->fermenting_id)) { 
												$stmt->bindParam(1,$this->fermenting_id); 
								}
								$stmt->execute();
							 return($stmt); 	
				}
				function create() { 
								$query="insert into ".$this->table_name." set fermenting_id = :fermenting_id, gravity = :gravity, yeast_gal = :yeast_gal,date = :date";

								$stmt = $this->conn->prepare($query);
								$fermenting_id = (int)$this->fermenting_id;
								$gravity = (double)$this->gravity; 
								$yeast_gal = (int)$this->yeast_gal; 
								$date = $this->date; 

								$stmt->bindParam(":fermenting_id", $fermenting_id); 
								$stmt->bindParam(":gravity", $gravity); 
								$stmt->bindParam(":yeast_gal", $yeast_gal); 
								$stmt->bindParam(":date", $date);
								if($stmt->execute()) {
												return true; 
								}	
								return false; 
				}
				function update() { 
								$query = "update ".$this->table_name." set gravity = :gravity, yeast_gal = :yeast_gal, date = :date  where id = :id";
								$stmt = $this->conn->prepare($query); 
							
								$id = (int)$this->id; 
								$gravity = (double)$this->gravity; 
								$yeast_gal = (int)$this->yeast_gal; 
								$date = date("Y-m-d H:i:s");

								$stmt->bindParam(":gravity", $gravity); 
								$stmt->bindParam(":yeast_gal", $yeast_gal); 
								$stmt->bindParam(":id", $id);
								$stmt->bindParam(":date", $date); 

								if($stmt->execute()) { 
												return true; 
								}
								return false; 
				}
				function delete() { 
								$query ="delete from ".$this->table_name." where id = :id"; 
								$stmt = $this->conn->prepare($query);
							  $stmt->bindParam(":id", $this->id); 
								if($stmt->execute()) { 
									return true; 
								}	
								return false; 

				}
}
