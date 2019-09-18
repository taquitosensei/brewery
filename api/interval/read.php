<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);
//required headers
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8"); 
include_once '../config/database.php'; 
include_once '../objects/interval.php'; 

$database = new Database();
$db = $database->getConnection(); 

$interval = new Interval($db); 
$interval->id = isset($_GET['id'])?$_GET['id']:"";
$stmt = $interval->read(); 
$num = $stmt->rowCount();
$interval_arr=array(); 
$interval_arr['records'] = array(); 
if($num>0) { 

				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								extract($row);
								//$interval->temp_serial=$temp_serial;
									
								$interval_item = array(
												"id"=>$id,
												"name"=>$name,
												"recipe_interval"=>$recipe_interval,
												"days"=>$days,
												"start_temp"=>$start_temp,
												"end_temp"=>$end_temp,
												"recipe_id"=>$recipe_id
								);
							 	
								array_push($interval_arr['records'],$interval_item);
				}
				http_response_code(200); 
}
echo json_encode($interval_arr); 
?>
