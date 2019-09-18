<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);
//required headers
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8"); 
include_once '../config/database.php'; 
include_once '../objects/fermenter.php';
include_once '../objects/temperature.php'; 


$database = new Database();
$db_f = $database->getConnection(); 
$db_t = $database->getConnection(); 

$fermenter = new Fermenter($db_f); 
$temp = new Temp($db_t); 

$stmt = $fermenter->read(); 
$num = $stmt->rowCount();
$fermenter_arr=array(); 
$fermenter_arr['records']=array();
if($num>0) { 
				$fermenter_arr=array(); 
				$fermenter_arr['records'] = array();

				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								
								extract($row);
								$temp->degrees_f = 0; 
								$fermenter->temp_serial=$temp_serial;
								/*	
								$fermenter_item = array(
												"id"=>$id,
												"pos"=>$pos,
												"gpio"=>$gpio,
												"temp_serial"=>$temp_serial,
												"temp"=>round($fermenter->getTemp())
								);
								 */
								if($active) {
								$temp->gpio = $gpio; 
								$temp->temp_serial = $temp_serial; 
								$temp->readTemp(); 
								$fermenter_item = array(
												"id"=>$id, 
												"pos"=>$pos, 
												"gpio"=>$gpio, 
												"temp_serial"=>$temp_serial, 
												"temp"=>round($temp->degrees_f)
								); 	
								array_push($fermenter_arr['records'],$fermenter_item);
								}
				}
				http_response_code(200); 
				echo json_encode($fermenter_arr); 
}
?>
