<?php
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *"); 
header("Content-Type: application/json; charset=UTF-8"); 

include_once '../config/core.php'; 
include_once '../shared/utilities.php'; 
include_once '../config/database.php'; 
include_once '../objects/fermenter.php'; 

$utilities = new Utilities(); 
$database = new Database(); 
$db=$database->getConnection(); 

$fermenter = new Fermenter($db);
$stmt = $fermenter->readPaging($from_record_num, $records_per_page); 
$num = $stmt->rowCount(); 
if($num > 0) { 
				$fermenters_arr = array(); 
				$fermenters_arr['records']=array(); 
				$fermenters_arr['paging']=array(); 

				while($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
								extract($row); 
								$fermenter_item = array(
												"id"=>$id, 
												"pos"=>$pos, 
												"gpio"=>$gpio, 
												"temp_serial"=>$temp_serial
								); 
								array_push($fermenters_arr['records'], $fermenter_item);
				}
				$total_rows = $fermenter->count(); 
				$page_url="{$home_url}fermenter/read_paging.php?"; 
				$paging = $utilities->getPaging($page,$total_rows,$records_per_page,$page_url);
				$fermenters_arr['paging']=$paging; 
				http_response_code(200);
				echo json_encode($fermenters_arr);
} else { 
				http_response_code(404); 
				echo json_encode(array("message"=>"No fermenters found."));
}
