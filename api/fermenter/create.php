<?php
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); 
header("Access-Control-Max-Age: 3600"); 
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With"); 

include_once '../config/database.php'; 
include_once '../objects/fermenter.php'; 
include_once '../utilities.php'; 

$database = new Database(); 
$db = $database->getConnection(); 

$fermenter = new Fermenter($db); 

$data = json_decode(file_get_contents("php://input")); 

if(
				!empty($data->pos) || !empty($data->gpio) || !empty($data->temp_serial)
){
	$fermenter->name = $data->name;
	if($fermenter->create()) { 
		http_response_code(201); 
		echo json_encode(array("message" => "Fermenter was created.")); 
	} else { 
		http_response_code(503); 
		echo json_encode(array("message" => "Unable to create fermenter")); 
	} 
} else { 
				http_response_code(400);
				echo json_encode(array("message" => "Unable to create fermenter. Data incomplete"));
}
