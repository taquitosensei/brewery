<?php
ini_set('display_errors',1); 
error_reporting(E_ALL); 
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Headers: access"); 
header("Access-Control-Allow-Methods: GET"); 
header("Access-Control-Allow-Credentials: true"); 
header("Content-Type: application/json"); 

include_once '../config/database.php'; 
include_once '../objects/fermenter.php'; 
include_once '../objects/temperature.php'; 
$database = new Database(); 
$db_f = $database->getConnection(); 
$db_t = $database->getConnection(); 

$fermenter = new Fermenter($db_f); 
$temp = new Temp($db_t); 

$fermenter->id = isset($_GET['id'])?$_GET['id']:die();
$fermenter->readOne(); 

if($fermenter->id!=null) { 
				$temp->gpio = $fermenter->gpio; 
				$temp->temp_serial = $fermenter->temp_serial; 
				$temp->readTemp(); 
				$fermenter_arr = array(
								"id"=>$fermenter->id, 
								"pos"=>$fermenter->pos, 
								"gpio"=>$fermenter->gpio, 
								"temp_serial"=>$fermenter->temp_serial,
								"temp" => $temp->degrees_f 
				);

				http_response_code(200); 
				echo json_encode($fermenter_arr);
} else {
				http_response_code(404); 
				echo json_encode(array("message" => "Fermenter does not exist.")); 
}	
?>
