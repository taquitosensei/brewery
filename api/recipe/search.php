<?php
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8"); 

include_once '../config/core.php'; 
include_once '../config/database.php'; 
require_once '../objects/recipe.php'; 

$database = new Database(); 
$db = $database->getConnection(); 

$recipe = new Recipe($db); 

$keywords = isset($_GET["s"])?$_GET["s"]:""; 
$stmt = $recipe->search($keywords); 
$num = $stmt->rowCount(); 

if($num > 0) {
				$recipes_arr=array(); 
				$recipes_arr['records'] = array(); 

				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								extract($row); 
								$recipe_item = array(
												"id"=>$id, 
												"name"=>$name
								); 
								array_push($recipes_arr['records'], $recipe_item); 
				}
				http_response_code(200); 
				echo json_encode($recipes_arr); 
} else { 
				http_response_code(404); 
				echo json_encode(array("message"=>"No recipe's found.")); 
}
?>
