<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Headers: access"); 
header("Access-Control-Allow-Methods: GET"); 
header("Access-Control-Allow-Credentials: true"); 
header("Content-Type: application/json"); 

include_once '../config/database.php'; 
include_once '../objects/recipe.php'; 

$database = new Database(); 
$db = $database->getConnection(); 

$recipe = new Recipe($db); 

$recipe->id = isset($_GET['id'])?$_GET['id']:die();
$recipe->readOne(); 

if($recipe->name!=null) { 
				$recipe_arr = array(
								"id"=>$recipe->id, 
								"name"=>$recipe->name
				);

				http_response_code(200); 
				echo json_encode($recipe_arr);
} else {
				http_response_code(404); 
				echo json_encode(array("message" => "Product does not exist.")); 
}	
?>
