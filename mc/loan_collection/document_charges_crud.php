<?php
	header('Content-Type: application/json');
	
	session_start();
	
	require_once ('../config.php');

	$user = $_SESSION['USER_CODE'];
	$op = $_REQUEST['operation'];
	$type = $_REQUEST['type']; 
	$id = $_REQUEST['id'];  
	$loanno = $_REQUEST['loanno'];
	$loan_amount = $_REQUEST['loan_amount'];
	$document_rate = $_REQUEST['document_rate'];
	$document_amount = $_REQUEST['document_amount'];
	$status = $_REQUEST['status'];
	$doc_date = date("Y-m-d");

	$query = "";
	$success = true;
	$message = "";
	$responce = array();

	$flag=0;
	
	if ($op == "insert"){

$query = "INSERT INTO document_charges(
							`loanno`,
							`loan_amount`,
							`document_rate`,
							`document_amount`,
							`status`,
							`doc_date`,
							`type`
						)
						VALUES
	('$loanno', '$loan_amount', '$document_rate', '$document_amount', '$status', '$doc_date', 'Document_charges');";
}
	else if ($op == "update"){
		$query = "UPDATE document_charges
SET 
 `loanno` = '$loanno',
  `loan_amount` = '$loan_amount',
 `document_rate` = '$document_rate',
 `document_amount` = '$document_amount'
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