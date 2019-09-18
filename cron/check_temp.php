<?php
	require_once '../api/objects/temperature.php'; 
	require_once '../api/objects/fermenting.php'; 
	require_once '../api/objects/fermenter.php'; 
	require_once '../api/objects/interval.php'; 
	require_once '../api/config/database.php'; 

	$database = new Database(); 
	$db_t = $database->getConnection(); 
	$db_f = $database->getConnection(); 
	$db_i = $database->getConnection(); 

	$temp = new Temp($db_t); 
	$fermenting = new Fermenting($db_f);
	$interval = new Interval($db_i); 
	$today = date("Y-m-d H:i:s"); 
  $temp->date=$today; 	
	$ferm_stmt = $fermenting->read();
	
	while($ferm = $ferm_stmt->fetch(PDO::FETCH_ASSOC)) {
					$temp->fermenting_id=$ferm['fermenting_id']; 
					$interval->id=$ferm['recipe_id']; 
					$stmt = $interval->read(); 
					$days = 0; 
					$old_days = 0;
					while($int = $stmt->fetch(PDO::FETCH_ASSOC)) {

									$days=$days+$int['days']; 
									$start = new DateTime($ferm['start_date']); 
									$end = new DateTime($today); 
									$days_diff = $start->diff($end); 
									$days_diff = $days_diff->format('%a'); 
									echo $days." : ".$days_diff." : ".$old_days."\r\n"; 
									if($days_diff <= $days && $days_diff >=$old_days) {
													$temp->gpio=$ferm['gpio']; 
													$temp->temp_serial=$ferm['temp_serial']; 
													$temp->readTemp();
													if($temp->degrees_f > $int['end_temp']) {
																	$temp->valve_state="open"; 
																	$temp->valve();
													} else if($temp->degrees_f <= $int['end_temp']) {
																	$temp->valve_state="closed"; 
																	$temp->valve(); 
													}
													$temp->addTemp(); 
									}
									$old_days=$days; 
					}	
	}
?>
