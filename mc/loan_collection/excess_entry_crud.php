<?php
	header('Content-Type: application/json');
	session_start();
	require ('../config.php');
	
	$user = $_SESSION['USER_CODE'];
	$op = $_REQUEST['operation'];
	$id = $_REQUEST['id'];

	$category = $_REQUEST['category'];
	$text = $_REQUEST['text'];
	$status = $_REQUEST['status'];
	$date = $_REQUEST['date'];
	
	$query = "";
	$result = true;
	$message = "";
	$debug = "";
	$responce = array();
	
	if ($op == "insert"){
	   $profile_query = "INSERT INTO excess_entry(
	`category`,
	`text`,
	`date`,
	`status`
)
VALUES
	(
		'$category',
		'$text',
		'$date',
		'$status'
	);";

		
	}else if ($op == "update"){
		$profile_query = "UPDATE excess_entry
SET 
    `category` = '$category',
	`status` = '$status'
WHERE
	(`id` = '$id');";
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