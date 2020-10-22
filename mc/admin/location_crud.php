<?php
	header('Content-Type: application/json');
	
	session_start();
	
	require_once ('../config.php');

	$query = "";
	$system_specific_flag = 0;
	$success = true;
	$message = "";
	$responce = array();

	$user = $_SESSION['USER_CODE'];
	
	$op = $_REQUEST['operation'];
	$location = $_REQUEST['location'];
	$line01 = $_REQUEST['line01'];
	$line02 = $_REQUEST['line02'];
	$line03 = $_REQUEST['line03'];
	$city = $_REQUEST['city'];
	$tp1 = $_REQUEST['tp1'];
	$tp2 = $_REQUEST['tp2'];
	$fax1 = $_REQUEST['fax1'];
	$fax2 = $_REQUEST['fax2'];
	$email = $_REQUEST['email'];
	$system_specific = $_REQUEST['system_specific'];
	$status = $_REQUEST['status'];
	$latitude = $_REQUEST['latitude'];
	$longitude = $_REQUEST['longitude'];
	$id = $_REQUEST['id'];

	$system_specific_flag = (!empty($system_specific) && $system_specific != NULL && $system_specific != 0) ? 1 : 0;
	
	if ($op == "insert"){
		$query = "INSERT INTO `mas_location` (
			`LOCATION`,
			`ADDRESS_LINE1`,
			`ADDRESS_LINE2`,
			`ADDRESS_LINE3`,
			`CITY`,
			`TEL1`,
			`TEL2`,
			`FAX1`,
			`FAX2`,
			`EMAIL`,
			`LATITUDE`,
			`LONGITUDE`,
			`SYSTEM_SPECIFIC`,
			`SYSTEM_ID`,
			`DATE_CREATED`,
			`USER_CREATED`,
			`STATUS`
		)
		VALUES
		(
			'$location',
			'$line01',
			'$line02',
			'$line03',
			'$city',
			'$tp1',
			'$tp2',
			'$fax1',
			'$fax2',
			'$email',
			'$latitude',
			'$longitude',
			'$system_specific_flag',
			'$system_specific',
			CURDATE(),
			'$user',
			'$status'
		)";
	}else if ($op == "update"){
		$query = "UPDATE `mas_location`
		SET `LOCATION` = '$location',
		`ADDRESS_LINE1` = '$line01',
		`ADDRESS_LINE2` = '$line02',
		`ADDRESS_LINE3` = '$line03',
		`CITY` = '$city',
		`TEL1` = '$tp1',
		`TEL2` = '$tp2',
		`FAX1` = '$fax1',
		`FAX2` = '$fax2',
		`EMAIL` = '$email',
		`LATITUDE` = '$latitude',
		`LONGITUDE` = '$longitude',
		`SYSTEM_SPECIFIC` = '$system_specific_flag',
		`SYSTEM_ID` = '$system_specific',
		`STATUS` = '$status'
		WHERE
		(`LOC_CODE` = '$id')";
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