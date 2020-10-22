<?php
	header('Content-Type: application/json');
	session_start();
	require ('../config.php');
	
	$id = $_REQUEST['id'];
	$loanno = $_REQUEST['loanno'];
	$loandate = $_REQUEST['loandate'];
	$nic = $_REQUEST['nic'];
	$loanamount = $_REQUEST['loanamount'];
	$loanamount = str_replace(',', '', $loanamount);
	$interest = $_REQUEST['interest'];
	$loantype = $_REQUEST['loantype'];
	$loantypes = $_REQUEST['loantypes'];
	$duration = $_REQUEST['duration'];
	$net = $_REQUEST['net'];
	$dueamount = $_REQUEST['dueamount'];
	$collector_day = $_REQUEST['collector_day'];
	$startdate = $_REQUEST['startdate'];
	$enddate = $_REQUEST['enddate'];
	$collector = $_REQUEST['collector'];
	$center_name = $_REQUEST['center_name'];
	$status = $_REQUEST['status'];
	$op = $_REQUEST['operation'];

	$query = "";
	$result = true;
	$message = "";
	$debug = "";
	$responce = array();
	

	if ($op == "insert"){

	$profile_query = "INSERT INTO loan_lending(
									`loanid`,
									`loan_date`,
									`nic`,
									`loan_amount`,
									`interest_amount`,
									`loan_type`,
									`loantypes`,
									`duration`,
									`net_payment`,
									`due_amount`,
									`collector_day`,
									`startdate`,
									`enddate`,
									`collector_name`,
									`status`
								)
								VALUES
									(
										'$loanno',
										'$loandate',
										'$nic',
										'$loanamount',
										'$interest',
										'$loantype',
										'$loantypes',
										'$duration',
										'$net',
										'$dueamount',
										'$collector_day',
										'$startdate',
										'$enddate',
										'$collector',
										'$status'
									);";

	}else if ($op == "update"){
		$profile_query = "UPDATE loan_lending
SET 
		`loanid` = '$loanno',
		`loan_date` = '$loandate',
		`nic` =  '$nic',
		`loan_amount` = '$loanamount',
		`interest_amount` =  '$interest',
		`loan_type` = '$loantype',
		`loantypes` =  '$loantypes',
		`duration` = '$duration',
		`net_payment` =  '$net',
		`due_amount` =  '$dueamount',
		`collector_day` = '$collector_day',
		`startdate` =  '$startdate',
		`enddate` = '$enddate',
		 `collector_name` = '$collector',
		`status` =   '$status'
WHERE
	(`id` = '$id');";
	}								



	
		$profile_sql = mysqli_query ($con_main, $profile_query);

		$id = ($op == "insert") ? mysqli_insert_id($con_main) : $id;
	
	if ($profile_sql){
		$success = true;
		$message = "Success";
	}else{
		$success = false;
		$message = "Error SQL: (".mysqli_errno($con_main).") ".mysqli_error($con_main);
	}
	
	$responce['operation'] = $op;
	$responce['result'] = $success;
	$responce['id'] = $id;
	$responce['message'] = $message;
	$responce['debug'] = $profile_query;
	
	echo (json_encode($responce));
	?>
	<?php mysqli_close($con_main); ?>
	
 