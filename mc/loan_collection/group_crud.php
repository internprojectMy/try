<?php
	header('Content-Type: application/json');
	session_start();
	require ('../config.php');
	
	$op = $_REQUEST['operation'];
	$id = $_REQUEST['id'];

	$branch_id = $_REQUEST['branch_name'];
	$center_id = $_REQUEST['center_name'];
	$group_name = $_REQUEST['group_name'];
	$group_code = $_REQUEST['group_code'];
	$group_date = $_REQUEST['group_date'];
	$status = $_REQUEST['status'];
	
	$query = "";
	$result = true;
	$message = "";
	$debug = "";
	$responce = array();
	
	if ($op == "insert"){
	 echo	$profile_query = "INSERT INTO group(
						`branch_id`,
						`center_id`,
						`group_name`,
						`group_code`,
						`group_date`,
						`status`
					)
					VALUES
						(
							'$branch_id',
							'$center_id',
							'$group_name',
							'$group_code',
							'$group_date ',
							'$status'
						);";

		
	}else if ($op == "update"){
		$profile_query = "UPDATE `weddingp_mc_main`.`center`
					SET 
						 `branch_id` = '$branch_id',
						 `center_id` = '$center_id',
						 `group_name` = '$group_name',
						`group_code` = '$center_code',
						 `group_date` = '$group_date',
						 `status` = '$status'
							WHERE
								(`group_id` = '$group_id');";
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