<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8"); 
header("Access-Control-Allow-Methods: POST"); 
header("Access-Control-Allow-Max-Age: 3600"); 
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With"); 

include_once '../config/database.php'; 
include_once '../objects/gravity.php'; 

$database = new Database(); 
$db = $database->getConnection(); 
$gravity = new Gravity($db); 

$data = json_decode(file_get_contents("php://input")); 
if(!empty($data->fermenting_id) || !empty($data->gravity) || !empty($data->yeast_gal)) { 
				$gravity->gravity = $data->gravity; 
				$gravity->yeast_gal = $data->yeast_gal; 
				$gravity->date = date("Y-m-d H:i:s"); 
				$gravity->fermenting_id = $data->fermenting_id; 

				if($gravity->create()) { 
								http_response_code(201); 
								echo json_encode(array("message"=>"Gravity created")); 
				} else {
					http_response_code(503); 
					echo json_encode(array("message"=>"Unable to create gravity.")); 
				}
}	else {
	http_response_code(400); 
	echo json_encode(array("message"=>"Unable to create gravity. Data incomplete.")); 
}
