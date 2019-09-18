<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8"); 
header("Access-Control-Allow-Methods: POST"); 
header("Access-Control-Max-Age: 3600"); 
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With"); 

include_once '../config/database.php'; 
include_once '../objects/gravity.php'; 

$database = new Database(); 
$db = $database->getConnection(); 
$gravity = new Gravity($db); 
$data = json_decode(file_get_contents("php://input")); 

$gravity->id = $data->gravity_id; 
$gravity->gravity = (int)$data->gravity; 
$gravity->yeast_gal = (int)$data->yeast_gal; 

if($gravity->update()) { 
				http_response_code(200); 
				echo json_encode(array("message" => "Gravity has been updated.")); 
} else {
				http_response_code(503); 
				echo json_encode(array("message" => "Unable to update gravity.")); 
}
