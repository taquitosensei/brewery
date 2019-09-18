<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8"); 

include_once '../config/core.php'; 
include_once '../shared/utilities.php'; 
include_once '../config/database.php'; 
include_once '../objects/fermenting.php'; 

$utilities = new Utilities(); 
$database = new Database(); 
$db=$database->getConnection(); 

$fermenting = new Fermenting($db);
$stmt = $fermenting->readPaging($from_record_num, $records_per_page); 
$num = $stmt->rowCount(); 
if($num > 0) { 
				$fermentings_arr = array(); 
				$fermentings_arr['records']=array(); 
				$fermentings_arr['paging']=array(); 

				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
								extract($row); 
								$fermenting_item = array(
												"id"=>$id,
											  "recipe_id"=>$recipe_id, 
												"recipe_name"=>$recipe_name, 
												"pos_id"=>$pos_id,
												"pos"=>$pos, 
												"gpio"=>$gpio, 
												"temp_serial"=>$temp_serial,
												"start_date"=>$start_date

								); 
								array_push($fermentings_arr['records'], $fermenting_item);
				}
				$total_rows = $fermenting->count(); 
				$page_url="{$home_url}fermenting/read_paging.php?"; 
				$paging = $utilities->getPaging($page,$total_rows,$records_per_page,$page_url);
				$fermentings_arr['paging']=$paging; 
				http_response_code(200);
				echo json_encode($fermentings_arr);
} else { 
				http_response_code(404); 
				echo json_encode(array("message"=>"No fermentings found."));
}
