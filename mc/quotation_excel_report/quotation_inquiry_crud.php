<?php
	header('Content-Type: application/json');
	
	session_start();
	
	require_once ('../config.php');
	
	$op = $_REQUEST['operation'];
	$cr=$_REQUEST['crn'];
	$cra=$_REQUEST['cus_auth'];
	$cid=$_REQUEST['cus'];
	$date=$_REQUEST['date'];
	$time=$_REQUEST['usr_time'];
	$erq=$_REQUEST['erq'];
	$arq=$_REQUEST['arq'];
	$user = $_SESSION['USER_CODE'];

	// $sales_person = ($_REQUEST['sales_person']=="" || $_REQUEST['sales_person']==null)? "-" : $_REQUEST['sales_person']; 
	// $details = $_REQUEST['details']; 
 //    $name = ($_REQUEST['name']=="" || $_REQUEST['name']==null)? "-" : $_REQUEST['name'];
 //    $email = ($_REQUEST['email']=="" || $_REQUEST['email']==null)? "-" : $_REQUEST['email'];
 //    $phone = ($_REQUEST['phone']=="" || $_REQUEST['phone']==null)? "-" : $_REQUEST['phone'];
 //    $status = $_REQUEST['status']; 
    
    
	$query = "";
	$success = true;
	$message = "";
	$responce = array();
	
	if ($op == "insert"){
$query = "INSERT INTO `customer_return_note`
					 	(					
						
					
						`crn`,
						`cra_id`,
						`cus_id`,
						`date`,
						`time`,
						`arc`,
						`entered_by`,
						`entered_date`
						


						
					)
					VALUES
						(
						
							'$cr',
							'$cra',
							'$cid',
							'$date',
							'$time',
							'$arq',
							'$user',
							
							
							NOW()
						);";

	}else if ($op == "update"){
		$query = "UPDATE `mas_quotation_inquiry`
				  SET    `sales_type` = '$sales_type',
						 `sales_person` = '$sales_person',
						 `details` = '$details',
						 `name` = '$name',
						 `email` = '$email',
						 `contact_no` = '$phone',
						 `status` = '$status',
						 `entered_by` = '$user',
						 `entered_date` = NOW()
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
	$responce['crn'] = $cr;
	echo (json_encode($responce));
	mysqli_close($con_main);
?>