<?php
	header('Content-Type: application/json');
	
	session_start();
	
	require_once ('../config.php');
	
	$op = $_REQUEST['operation'];
	$id = $_REQUEST['id'];
	$modules = $_REQUEST['mod_id'];
	$user = $_SESSION['USER_CODE'];
	
	$query = "";
	$result = true;
	$message = "";
	$debug = "";
	$responce = array();
	
	if ($op == "insert"){
		// Flush permissions
		$flush_query = "DELETE FROM `mas_permission` WHERE ACCESS_CODE=$id";
		$flush_sql = mysqli_query($con_main, $flush_query);

		if (!$flush_sql){
			$result = false;
			$debug .= "\nFlush Error SQL: (".mysqli_errno($con_main).") ".mysqli_error($con_main);
		}

		// Add new permissions
		foreach ($modules as $mod_code) {
			$grant_query = "INSERT INTO `mas_permission` (
				`ACCESS_CODE`,
				`MOD_CODE`,
				`ADDED_BY`,
				`ADDED_ON`
			)
			VALUES
			('$id', '$mod_code', '$user', NOW());";

			$grant_sql = mysqli_query ($con_main, $grant_query);

			if (!$grant_sql){
				$result = false;
				$debug .= "\nGrant Error SQL: (".mysqli_errno($con_main).") ".mysqli_error($con_main);
			}
		}
	}
	
	if ($result){
		$message .= "Permission granted successfully.";
	}else{
		$message = "Permission grant failed.";
	}
	
	$responce['operation'] = $op;
	$responce['result'] = $result;
	$responce['id'] = $id;
	$responce['message'] = $message;
	$responce['debug'] = $debug;
	
	echo (json_encode($responce));
	
	mysqli_close($con_main);
?>