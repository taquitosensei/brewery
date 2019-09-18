<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8"); 

include_once '../config/core.php'; 
include_once '../shared/utilities.php'; 
include_once '../config/database.php'; 
include_once '../objects/recipe.php'; 

$utilities = new Utilities(); 
$database = new Database(); 
$db=$database->getConnection(); 

$recipe = new Recipe($db);
$stmt = $recipe->readPaging($from_record_num, $records_per_page); 
$num = $stmt->rowCount(); 
if($num > 0) { 
				$recipes_arr = array(); 
				$recipes_arr['records']=array(); 
				$recipes_arr['paging']=array(); 

				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
								extract($row); 
								$recipe_item = array(
												"id"=>$id, 
												"name"=>$name
								); 
								array_push($recipes_arr['records'], $recipe_item);
				}
				$total_rows = $recipe->count(); 
				$page_url="{$home_url}recipe/read_paging.php?"; 
				$paging = $utilities->getPaging($page,$total_rows,$records_per_page,$page_url);
				$recipes_arr['paging']=$paging; 
				http_response_code(200);
				echo json_encode($recipes_arr);
} else { 
				http_response_code(404); 
				echo json_encode(array("message"=>"No recipes found."));
}
