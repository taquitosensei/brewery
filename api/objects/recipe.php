<?php
class Recipe{
				private $conn; 
				private $table_name="recipe"; 
				public $id; 
				public $name;
				public function __construct($db) { 
								$this->conn = $db; 
				}
				function read(){
								$query = "select r.id,r.name from ".$this->table_name." r order by r.name";
								$stmt = $this->conn->prepare($query); 
								$stmt->execute(); 
								return($stmt); 
				}

				function create() {
								$query ="insert into ".$this->table_name." set name=:name"; 
								$stmt = $this->conn->prepare($query); 
								$this->name=htmlspecialchars(strip_tags($this->name));

								$stmt->bindParam(":name",$this->name); 
								if($stmt->execute()) { 
												return true;
								}
								return false; 
				}
				function readOne() {
								$query="select r.name,r.id from ".$this->table_name." r where r.id = ? LIMIT 0,1";
								$stmt = $this->conn->prepare($query); 
								$stmt->bindParam(1,$this->id); 
								$stmt->execute(); 
								$row = $stmt->fetch(PDO::FETCH_ASSOC); 
								$this->name = $row['name']; 
								$this->id = $row['id']; 
				}
				function update() { 
								$query = "update ".$this->table_name." set name = :name where id = :id";
								$stmt = $this->conn->prepare($query); 
								$this->id=htmlspecialchars(strip_tags($this->id)); 
								$this->name=htmlspecialchars(strip_tags($this->name));
								$stmt->bindParam(":id", $this->id); 
								$stmt->bindParam(":name", $this->name);
								if($stmt->execute()) {
												return true;
								}
								return false; 
				}
				function search($keywords) { 
								$query = "select r.id, r.name from ".$this->table_name." r where r.name like ? or r.id like ? order by r.name DESC"; 
								$stmt = $this->conn->prepare($query); 
				
								$keywords = htmlspecialchars(strip_tags($keywords)); 
								$keywords = "%{$keywords}%"; 
								$stmt->bindParam(1, $keywords); 
								$stmt->bindParam(2, $keywords); 
								$stmt->execute(); 
								return $stmt; 
				}
				public function readPaging($from_record_num, $records_per_page) { 
								$query = "select r.id,r.name from ".$this->table_name." r order by r.name DESC limit ?,?"; 
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
}
