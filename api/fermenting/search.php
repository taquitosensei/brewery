<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8"); 

include_once '../config/core.php'; 
include_once '../config/database.php'; 
require_once '../objects/fermenting.php'; 

$database = new Database(); 
$db = $database->getConnection(); 

$fermenting = new Fermenting($db); 

$keywords = isset($_GET["s"])?$_GET["s"]:""; 
$stmt = $fermenting->search($keywords); 
$num = $stmt->rowCount(); 

if($num > 0) {
				$fermentings_arr=array(); 
				$fermentings_arr['records'] = array(); 

				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								extract($row); 
								$fermenting_item = array(
												"id"=>$id, 
												"recipe_id"=>$recipe_id,
												"recipe_name"=>$recipe_name,
												"pos_id"=>$pos_id,
												"pos"=>$pos,
												"gpio"=>$gpio, 
												"temp_serial"=>$temp_serial
								); 
								array_push($fermentings_arr['records'], $fermenting_item); 
				}
				http_response_code(200); 
				echo json_encode($fermentings_arr); 
} else { 
				http_response_code(404); 
				echo json_encode(array("message"=>"No fermenting's found.")); 
}
?>
