<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8"); 

include_once '../config/database.php'; 
include_once '../objects/gravity.php'; 

$database = new Database(); 
$db = $database->getConnection(); 

$gravity = new Gravity($db); 
$gravity->fermenting_id = isset($_GET['fermenting_id'])?$_GET['fermenting_id']:""; 
$stmt = $gravity->read();
$num = $stmt->rowCount(); 
$gravity_arr=array(); 
$gravity_arr['records'] = array();

if($num > 0) { 
				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
					extract($row); 
					$gravity_item = array(
									"id"=>$id,
								  "name"=>$name, 	
									"pos"=>$pos, 
									"fermenting_id"=>$fermenting_id, 
									"gravity"=>$gravity, 
									"yeast_gal"=>$yeast_gal, 
									"date"=>$date
					);
					array_push($gravity_arr['records'],$gravity_item);
				}
				http_response_code(200); 
}
echo json_encode($gravity_arr);
?>
