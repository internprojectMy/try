<?php
	header('Content-Type: application/json');
	
	session_start();
	
	require_once ('../config.php');
	
	$op = $_REQUEST['operation'];
	$id = $_REQUEST['id'];
	$dep = $_REQUEST['department'];
	$loc = $_REQUEST['location'];
	$status = $_REQUEST['status'];
	$user = $_SESSION['USER_CODE'];
	
	$query = "";
	$success = true;
	$message = "";
	$responce = array();
	
	if ($op == "insert"){
		$query = "INSERT INTO `mas_department` (`DEPARTMENT`, `LOC_CODE`, `DATE_CREATED`, `USER_CREATED`, `STATUS`) VALUES ('$dep', '$loc', NOW(), '$user', '$status')";
	}else if ($op == "update"){
		$query = "UPDATE `mas_department`
		SET 
		`DEPARTMENT` = '$dep',
		`LOC_CODE` = '$loc',
		`STATUS` = '$status'
		WHERE
		(`DEP_CODE` = '$id')";
	}
	
	$sql = mysqli_query ($con_main, $query);
	
	$id = ($op == "insert") ? mysqli_insert_id($con_main) : $id;
	
	if ($sql){
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
	
	echo (json_encode($responce));
	
	mysqli_close($con_main);
?>