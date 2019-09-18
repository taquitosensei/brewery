<?php
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); 
header("Access-Control-Max-Age: 3600"); 
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With"); 

include_once '../config/database.php'; 
include_once '../objects/interval.php'; 
include_once '../utilities.php'; 

$database = new Database(); 
$db = $database->getConnection(); 

$interval = new Interval($db); 

$data = json_decode(file_get_contents("php://input")); 

if(
!empty($data->days) || !empty($data->start_temp) || !empty($data->end_temp) || !empty($data->recipe_id)
){
	$interval->recipe_interval = $data->recipe_interval; 
	$interval->days = $data->days;
	$interval->start_temp = $data->start_temp; 
	$interval->end_temp = $data->end_temp; 
	$interval->recipe_id = $data->recipe_id; 

	if($interval->create()) { 
		http_response_code(201); 
		echo json_encode(array("message" => "Interval was created.")); 
	} else { 
		http_response_code(503); 
		echo json_encode(array("message" => "Unable to create interval")); 
	} 
} else { 
	http_response_code(400);
	echo json_encode(array("message" => "Unable to create interval. Data incomplete"));
}
