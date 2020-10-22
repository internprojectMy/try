<?php
	header('Content-Type: application/json');
	
	session_start();
	
	require_once ('../config.php');
	
	$op = $_REQUEST['operation'];
	$group = $_REQUEST['group'];
	$remark = $_REQUEST['remark'];
	
	$query = "";
	$success = true;
	$id = 0;
	$message = "";
	$responce = array();
	
	$query = "INSERT INTO `mobi_group` (`GROUP`, `REMARK`, `ADDED_DATE`) 
	VALUES ('$group', '$remark', NOW())";
	
	$sql2 = mysqli_query ($con_main, $query);
	
	$id = mysqli_insert_id($con_main);
	
	if ($sql2){
		$success = true;
		$message = "Success";
	}else{
		$success = false;
		$message = "Error SQL. (".mysqli_errno($con_main).") ".mysqli_error($con_main)." Query: ".$query;
	}
	
	$responce['operation'] = $op;
	$responce['result'] = $success;
	$responce['id'] = $id;
	$responce['message'] = $message;
	
	echo (json_encode($responce));
	
	mysqli_close($con_main);
?>