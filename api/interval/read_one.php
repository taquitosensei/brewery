<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Headers: access"); 
header("Access-Control-Allow-Methods: GET"); 
header("Access-Control-Allow-Credentials: true"); 
header("Content-Type: application/json"); 

include_once '../config/database.php'; 
include_once '../objects/interval.php'; 

$database = new Database(); 
$db = $database->getConnection(); 

$interval = new Interval($db); 
$interval->id = isset($_GET['id'])?$_GET['id']:die();
$interval->readOne(); 
if($interval->id!=null) {
				$interval_arr = array(
								"id"=>$interval->id, 
								"days"=>$interval->days, 
								"start_temp"=>$interval->start_temp, 
								"end_temp"=>$interval->end_temp,
								"recipe_id"=>$interval->recipe_id,
								"recipe_interval"=>$interval->recipe_interval
				);

				http_response_code(200); 
				echo json_encode($interval_arr);
} else {
				http_response_code(404); 
				echo json_encode(array("message" => "Interval does not exist.")); 
}	
?>
