<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);
//required headers
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8"); 
include_once '../config/database.php'; 
include_once '../shared/functions.php'; 
include_once '../objects/fermenting.php'; 

$database = new Database();
$db = $database->getConnection(); 

$fermenting = new Fermenting($db); 

$stmt = $fermenting->read(); 
$num = $stmt->rowCount(); 

if($num>0) { 
				$fermenting_arr=array(); 
				$fermenting_arr['records'] = array();

				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								extract($row); 
								$fermenting_item = array(
												"id"=>$id,
												"recipe_id"=>$recipe_id,
												"recipe_name"=>$recipe_name, 
												"pos_id"=>$pos_id,
												"pos"=>$pos,
												"gpio"=>$gpio,
												"temp_serial"=>$temp_serial,
												"start_date"=>$start_date,
												"temp"=>round(getTemp($temp_serial))
								); 
								array_push($fermenting_arr['records'],$fermenting_item);
				}
				http_response_code(200); 
				echo json_encode($fermenting_arr); 
}
?>
