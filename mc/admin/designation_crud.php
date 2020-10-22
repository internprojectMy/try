<?php
	header('Content-Type: application/json');
	
	session_start();
	
	require_once ('../config.php');

	$user = $_SESSION['USER_CODE'];
	
	$op = $_REQUEST['operation'];
	$status = $_REQUEST['status'];
	$des = $_REQUEST['designation'];
	$id = $_REQUEST['id'];
	
	$query = "";
	$success = true;
	$message = "";
	$responce = array();
	
	if ($op == "insert"){
		$query = "INSERT INTO `mas_designation` (
		`DESIGNATION`,
		`DATE_CREATED`,
		`USER_CREATED`,
		`STATUS`
		)
		VALUES
		('$des', NOW(), '$user', '$status')";
	}else if ($op = "update"){
		$query = "UPDATE `mas_designation`
		SET `DESIGNATION` = '$des',
		`STATUS` = '$status'
		WHERE
		(`DES_CODE` = '$id')";
	}
	
	$sql = mysqli_query ($con_main, $query);
	
	$id = ($op == 'insert') ? mysqli_insert_id($con_main) : $id;
	
	if ($sql){
		$success = true;
		$message = "Success";
	}else{
		$success = false;
		$message = "Error SQL. (".mysqli_errno($con_main).") ".mysqli_error($con_main);
	}
	
	$responce['operation'] = $op;
	$responce['result'] = $success;
	$responce['id'] = $id;
	$responce['message'] = $message;
	
	echo (json_encode($responce));
	
	mysqli_close($con_main);
?>