<?php
	header('Content-Type: application/json');
	session_start();
	require ('../config.php');
	
	$op = $_REQUEST['operation'];
	$id = $_REQUEST['id'];

	$branch_id = $_REQUEST['branch_name'];
	$center_name = $_REQUEST['center_name'];
	$center_code = $_REQUEST['center_code'];
	$cash_name = $_REQUEST['cash_name'];
	$cash_day = $_REQUEST['cash_day'];
	$status = $_REQUEST['status'];
	
	$query = "";
	$result = true;
	$message = "";
	$debug = "";
	$responce = array();
	
	if ($op == "insert"){
	 echo	$profile_query = "INSERT INTO center (
				`branch_id`,
				`center_name`,
				`center_code`,
				`cash_name`,
				`cash_day`,
				`status`
			)
			VALUES
				(
					'$branch_id',
					'$center_name',
					'$center_code',
					'$cash_name',
					'$cash_day',
					'$status'
				);";

		
	}else if ($op == "update"){
		$profile_query = "UPDATE center
					SET 
						 `branch_id` = '$branch_id',
						 `center_name` = '$center_name',
						`center_code` = '$center_code',
						 `cash_name` = '$cash_name',
						 `cash_day` = '$cash_day',
						 `status` = '$status'
							WHERE
								(`center_id` = '$id');";
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
	$responce['debug'] = $debug;
	
	echo (json_encode($responce));
	
	mysqli_close($con_main);
?>