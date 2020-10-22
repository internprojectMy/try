<?php
	header('Content-Type: application/json');
	session_start();
	require ('../config.php');
	
	// $member_num_code = $menuberc;
	// $member_number  = $menumbern;
/*
	$member_num_code = $_REQUEST['member_num_code'];
	$member_number = $_REQUEST['member_number'];

	$member_number_add = $member_num_code+$member_number;*/

	$member_num_code = $_REQUEST['member_num_code'];
	
	$op = $_REQUEST['operation'];
	$id = $_REQUEST['id'];
    $branch_name = $_REQUEST['branch_name'];
	$center_name = $_REQUEST['center_name'];
	$group_name = $_REQUEST['group_name'];
	$date = $_REQUEST['registered'];
	$member_number = $_REQUEST['member_number'];
	$fulname = $_REQUEST['fullname'];
	$ininame = $_REQUEST['initialname'];
	$dob = $_REQUEST['dob'];
	$nic = $_REQUEST['nic'];
	$spouse = $_REQUEST['spousename'];
	$scontact = $_REQUEST['spousecontact'];
	$sdob = $_REQUEST['spousedob'];
	$snic = $_REQUEST['spouseid'];
	$sincome = $_REQUEST['spouseincome'];
	$homeadd = $_REQUEST['homeaddress'];
	$businessadd = $_REQUEST['businessadd'];
	$mobile1 = $_REQUEST['mobile1'];
	$mobile2 = $_REQUEST['mobile2'];
	$fixed1 = $_REQUEST['fixed1'];
	$fixed2 = $_REQUEST['fixed2'];
	$status = $_REQUEST['status'];

	$center_query = "SELECT
		center.center_id,
		center.branch_id,
		center.center_name,
		center.center_code,
		center.cash_name,
		center.cash_day,
		center.`status`
	FROM
		`center`
	WHERE
		center.center_id = $center_name
	AND center.`status` = 1";


	$branch_query = "SELECT
				branch.branch_id,
				branch.branch_name,
				branch.branch_code,
				branch.branch_comment,
				branch.branch_date,
				branch.`status`
			FROM
				branch
			WHERE
				branch.branch_id = '$branch_name'";

	$profile_sql = mysqli_query ($con_main, $center_query);
	$prof_result = mysqli_fetch_array($profile_sql);

	$profile_sql1 = mysqli_query ($con_main, $branch_query);
	$prof_result1 = mysqli_fetch_array($profile_sql1);


    $set1 = $prof_result1['branch_code'];
	$set = $prof_result['center_code'];

	$mem_num = $set1.'/'.$set.'/'.$member_number;


	$query = "";
	$result = true;
	$message = "";
	$debug = "";
	$responce = array();

	$check_value = "SELECT mc_main FROM loan_customer WHERE nic = '$nic'";

	$result = mysqli_query ($con_main, $check_value);

	$count = mysqli_num_rows($result);


	if($count > 0){
		echo "fail";
	}



	
	 if($op == "insert"){
		$profile_query = "INSERT INTO loan_customer (
	`branch_name`,
	`center_name`,
	`group_name`,
	`registered_date`,
	`member_number`,
	`name_full`,
	`name_initial`,
	`dob`,
	`nic`,
	`spouse_name`,
	`spouse_contact`,
	`spouse_dob`,
	`spouse_nic`,
	`spouse_income`,
	`customer_home_address`,
	`customer_mobile1`,
	`customer_fixed1`,
	`customer_business_address`,
	`customer_mobile2`,
	`customer_fixed2`,
	`status`
)
VALUES
	(
		'$branch_name',
		'$center_name',
		'$group_name',
		'$date',
		'$mem_num',
		'$fulname',
		'$ininame',
		'$dob',
		'$nic',
		'$spouse',
		'$scontact',
		'$sdob',
		'$snic',
		'$sincome',
		'$homeadd',
		'$mobile1',
		'$fixed1',
		'$businessadd',
		'$mobile2',
		'$fixed2',
		'$status'
	);";

		
	}else if ($op == "update"){
		$profile_query = "UPDATE `loan_customer`
SET
 `branch_name` = '$branch_name',
 `center_name` = '$center_name',
 `group_number` = '$group_number',
 `registered_date` = '$date',
 `member_number` = '$member_number',
 `name_full` = '$fulname',
 `name_initial` = '$ininame',
 `dob` = '$dob',
 `nic` = '$nic',
 `spouse_name` = '$spouse',
 `spouse_contact` = '$scontact',
 `spouse_dob` = '$sdob',
 `spouse_nic` = '$snic',
 `spouse_income` = '$sincome',
 `customer_home_address` = '$homeadd',
 `customer_mobile1` = '$mobile1',
 `customer_fixed1` = '$fixed1',
 `customer_business_address` = '$businessadd',
 `customer_mobile2` = '$mobile2',
 `customer_fixed2` = '$fixed2',
 `status` = '$status'
WHERE
	(`id` = '$id');";
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
	// $responce['member_number'] = $member_number;
	// $responce['center_name'] = $center_name;
	$responce['mem_num'] = $mem_num;
	
	echo (json_encode($responce));
	
	mysqli_close($con_main);
?>