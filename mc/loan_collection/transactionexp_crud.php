<?php
	header('Content-Type: application/json');
	
	session_start();
	
	require_once ('../config.php');

	$user = $_SESSION['USER_CODE'];
	$op = $_REQUEST['operation']; 
	$id = $_REQUEST['id'];
	 
	$branch_name = $_REQUEST['branch_name']; 
	$category = $_REQUEST['exptype'];
	$amount = $_REQUEST['amount'];
	$amount = str_replace(',', '', $amount);
	$expencestype = $_REQUEST['expencestype'];
	$comment = $_REQUEST['comment'];
	$other = $_REQUEST['other'];
	$today = date("Y-m-d");

	$query = "";
	$success = true;
	$message = "";
	$responce = array();

	$flag=0;

	$type_select = "SELECT
					pl_expense.category 
					FROM
					loan_expenses
					INNER JOIN pl_expense ON loan_expenses.type_id = pl_expense.id 
					WHERE
					loan_expenses.id = '$category'";
	
	$type_sql = mysqli_query ($con_main, $type_select);
	$type_rows = mysqli_fetch_assoc ($type_sql);
	$expcat = $type_rows['category'];
	
	if ($op == "insert"){

$query = "INSERT INTO loan_transactionexp(
    `branch_name`,
	`category`,
	`amount`,
	`expencestype`,
	`comment`,
	`other`,
	`expcat`,
	`entered_date`,
	`entered_by`
)

VALUES
	('$branch_name','$category', '$amount','$expencestype', '$comment', '$other', '$expcat', '$today', '$user')";
}
	else if ($op == "update"){
		$query = "UPDATE `loan_transactionexp`
SET 
 `category` = '$category',
 `amount` = '$amount',
  `expencestype` = '$expencestype',
  `$comment` = '$comment',
  `other` = '$other',
 `entered_date` = '$today',
 `entered_by` = '$user'
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