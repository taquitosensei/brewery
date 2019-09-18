<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Headers: access"); 
header("Access-Control-Allow-Methods: GET"); 
header("Access-Control-Allow-Credentials: true"); 
header("Content-Type: application/json"); 

include_once '../config/database.php'; 
include_once '../objects/fermenting.php'; 

$database = new Database(); 
$db = $database->getConnection(); 

$fermenting = new Fermenting($db); 

$fermenting->id = isset($_GET['id'])?$_GET['id']:die();
$fermenting->readOne(); 

if($fermenting->id!=null) { 
				$fermenting_arr = array(
								"id"=>$fermenting->id,
							  "recipe_id"=>$fermenting->recipe_id, 	
								"recipe_name"=>$fermenting->recipe_name, 
								"pos_id"=>$fermenting->pos_id, 
								"pos"=>$fermenting->pos, 
								"gpio"=>$fermenting->gpio, 
								"temp_serial"=>$fermenting->temp_serial, 
								"start_date"=>$fermenting->start_date
				);

				http_response_code(200); 
				echo json_encode($fermenting_arr);
} else {
				http_response_code(404); 
				echo json_encode(array("message" => "Fermenting does not exist.")); 
}	
?>
