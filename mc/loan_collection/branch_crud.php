<?php
	header('Content-Type: application/json');
	session_start();
	require ('../config.php');
	
	$user = $_SESSION['USER_CODE'];
	$op = $_REQUEST['operation'];
	$id = $_REQUEST['id'];

	$branch_name = $_REQUEST['branch_name'];
	$branch_code = $_REQUEST['branch_code'];
	$branch_comment = $_REQUEST['branch_comment'];
	$start_date = $_REQUEST['start_date'];
	$status = $_REQUEST['status'];
	
	$query = "";
	$result = true;
	$message = "";
	$debug = "";
	$responce = array();
	
	if ($op == "insert"){
	   $profile_query = "INSERT INTO branch(
	`branch_name`,
	`branch_code`,
	`branch_comment`,
	`branch_date`,
	`status`
)
VALUES
	(
		'$branch_name',
		'$branch_code',
		'$branch_comment',
		'$start_date',
		'$status'
	);";

		
	}else if ($op == "update"){
		$profile_query = "UPDATE branch
SET 
    `branch_code` = '$branch_code',
	`branch_name` = '$branch_name',
	`branch_comment` = '$branch_comment',
	`branch_date` = '$branch_date',
	`status` = '$status'
WHERE
	(`branch_id` = '$id');";
	}



	 $profile_sql = mysqli_query($con_main, $profile_query);

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