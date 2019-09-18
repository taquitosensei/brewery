<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); 
header("Access-Control-Max-Age: 3600"); 
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With"); 

include_once '../config/database.php'; 
include_once '../objects/fermenting.php'; 
include_once '../shared/utilities.php'; 

$database = new Database(); 
$db = $database->getConnection(); 
$utilities = new Utilities(); 
$fermenting = new Fermenting($db); 

$data = json_decode(file_get_contents("php://input")); 

if(
				!empty($data->pos_id) || !empty($data->recipe_id) || !empty($data->start_gal) || !empty($data->gravity)
){
				$fermenting->pos_id = $data->pos_id;
				$fermenting->recipe_id = $data->recipe_id; 
				$fermenting->start_gal = $data->start_gal; 
				$fermenting->gravity = $data->gravity;
				$fermenting->start_date = date("Y-m-d H:i:s");


	if($fermenting->create()) { 
		http_response_code(201); 
		echo json_encode(array("message" => "Fermenting was created.")); 
	} else { 
		http_response_code(503); 
		echo json_encode(array("message" => "Unable to create fermenting")); 
	} 
} else { 
				http_response_code(400);
				echo json_encode(array("message" => "Unable to create fermenting. Data incomplete"));
}
