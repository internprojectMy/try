<?php
	header('Content-Type: application/json');
	
	session_start();
	
	require_once ('../config.php');

	$user = $_SESSION['USER_CODE'];
	$op = $_REQUEST['operation']; 
	$id = $_REQUEST['id'];  
	$colcode = $_REQUEST['colcode']; 
	$status = $_REQUEST['status']; 
	$colname = $_REQUEST['colname'];
	$username = $_REQUEST['username'];
	$pass = $_REQUEST['pass'];

	$query = "";
	$success = true;
	$message = "";
	$responce = array();

	$flag=0;
	
	if ($op == "insert"){

$query = "INSERT INTO `loan_collector` (
	`collector_code`,
	`collector_name`,
	`user_name`,
	`password`,
	`status`
)
VALUES
	('$colcode','$colname','$username','$pass','$status');";
}
	else if ($op == "update"){
		$query = "UPDATE `loan_collector`
SET 
 `collector_code` = '$colcode',
 `collector_name` = '$colname',
 `user_name` = '$username',
 `password` = '$pass',
 `status` = '$status'
WHERE
	(`id` = '$id');";
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
	$responce['debug'] = $query;

	
	echo (json_encode($responce));

	
	mysqli_close($con_main);
?>