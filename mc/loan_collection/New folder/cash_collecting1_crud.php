<?php
	header('Content-Type: application/json');
	
	session_start();
	
	require_once ('../config.php');

	$user = $_SESSION['USER_CODE'];
	$op = $_REQUEST['operation']; 

	$id = $_REQUEST['id'];  
	$cusname = $_REQUEST['cusname']; 
	$loanno = $_REQUEST['loanno'];
	$collector = $_REQUEST['collector'];
	$amount = $_REQUEST['amount'];
	$type = $_REQUEST['type'];
	$received = $_REQUEST['received'];
	$dueamount = $_REQUEST['dueamount'];
	$lateamt = $_REQUEST['lateamt'];
	$billamt = $_REQUEST['billamt'];
	$totalamt = $_REQUEST['totalamt'];
	$today = date("Y-m-d");

	// if($op=="update"){
        

	// // }

     if($billamt==0){
         $status = 'PENDING';
     }else{
     	$status = 'DONE';
     }
	$query = "";
	$success = true;
	$message = "";
	$responce = array();

	$flag=0;
	
	if ($op == "insert"){

$query = "INSERT INTO `loan_collecting` (
	`collect_date`,	
	`loan_id`,
	`collector_name`,
	`loan_received`,
	`late_amount`,
	`bill_amount`,
	`total_amount`,
	`status`

)
VALUES
	(
		'$today',
		'$loanno',
		'$collector',
		'$received',
		'$lateamt',
		'$billamt',
		'$totalamt',
		'$status'
	);";
}
	else if ($op == "update"){
		$query = "UPDATE `mobiman_main`.`loan_collecting`
SET `collect_date` = '$today',
 `loan_id` = '$loanno',
 `collector_name` = '$collector',
 `loan_received` = '$received',
 `late_amount` = '$lateamt',
 `bill_amount` = '$billamt',
 `total_amount` = '$totalamt',
 `status` = 'DONE'
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