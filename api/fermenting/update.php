<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8"); 
header("Access-Control-Allow-Methods: POST"); 
header("Access-Control-Max-Age: 3600"); 
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); 

include_once '../config/database.php'; 
include_once '../shared/utilities.php'; 
include_once '../objects/fermenting.php'; 

$database = new Database(); 
$db = $database->getConnection(); 

$fermenting = new Fermenting($db); 

$data = json_decode(file_get_contents("php://input"));
$fermenting->id = (int)$data->id; 
if(!empty($data->recipe_id)) $fermenting->recipe_id = (int)$data->recipe_id; 
if(!empty($data->pos_id)) $fermenting->pos_id = (int)$data->pos_id; 
if(!empty($data->start_date)) $fermenting->start_date = DateTime::createFromFormat("Y-m-d H:i:s", $data->start_date);
if($fermenting->update()) { 
	http_response_code(200); 
	echo json_encode(array("message" => "Fermenting was updated.")); 
} else { 
			http_response_code(503); 
			echo json_encode(array("message"=>"Unable to update product.")); 
}

