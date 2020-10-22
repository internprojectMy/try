<?php
	header('Content-Type: application/json');
	
	session_start();
	
	require_once ('../config.php');

	$user = $_SESSION['USER_CODE'];
	$op = $_REQUEST['operation']; 
	$id = $_REQUEST['id'];  
	$expenses_type = $_REQUEST['expenses_type']; 
	$status = $_REQUEST['status']; 
	$today = date("Y-m-d");

	$query = "";
	$success = true;
	$message = "";
	$responce = array();

	$flag=0;
	
	if ($op == "insert"){

$query = "INSERT INTO `expenses_type` (
    `expenses_type`,
	`status`	
)	
VALUES
	(
	    '$expenses_type',
		'$status'		
	);";
}
	else if ($op == "update"){
		$query = "UPDATE `expenses_type`
SET 
 `expenses_type` = '$expenses_type',
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