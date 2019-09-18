<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../config/database.php'; 
include_once '../objects/interval.php'; 


$database = new Database(); 
$db = $database->getConnection(); 

$interval = new Interval($db); 
$interval->id = isset($_GET['id'])?$_GET['id']:""; 

if($interval->delete()) {
	http_response_code(200);
	echo json_encode(array("message"=>"Interval was deleted. Hopefully that's what you wanted to do.")); 
} else { 
	http_response_code(503); 
	echo json_encode(array("message"=>"Unable to delete interval."));
}

