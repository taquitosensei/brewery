<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);
//required headers
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8"); 
include_once '../config/database.php'; 
include_once '../objects/recipe.php'; 

$database = new Database();
$db = $database->getConnection(); 

$recipe = new Recipe($db); 

$stmt = $recipe->read(); 
$num = $stmt->rowCount(); 

if($num>0) { 
				$recipe_arr=array(); 
				$recipe_arr['records'] = array();

				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								extract($row); 
								$recipe_item = array(
												"id"=>$id,
												"name"=>$name
								); 
								array_push($recipe_arr['records'],$recipe_item);
				}
				http_response_code(200); 
				echo json_encode($recipe_arr); 
}
?>
