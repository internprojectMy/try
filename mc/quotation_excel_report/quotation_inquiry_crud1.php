<?php
	header('Content-Type: application/json');
	
	session_start();
	
	require_once ('../config.php');
	
	$op = $_REQUEST['operation'];

	// $cra=$_REQUEST['cus_auth'];
	$quot=$_REQUEST['qn'];
	$ca=$_REQUEST['cra_num'];
	$cid=$_REQUEST['cus'];
	$qid=$_REQUEST['qn'];
	$wid=$_REQUEST['wid'];
	$won_id=$_REQUEST['won_id'];
	$cment=$_REQUEST['cc'];
	$geo=$_REQUEST['go'];
	$moc=$_REQUEST['moc'];
	$doc=$_REQUEST['doc'];
	$time=$_REQUEST['usr_time'];
	$cb=$_REQUEST['cb'];
	$mdo=$_REQUEST['mdo'];
	$ifp=$_REQUEST['ifp'];
	$qtbr=$_REQUEST['qr'];
	$tcdq=$_REQUEST['tcdq'];
	$goods_ins=$_REQUEST['gi'];
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
$query = "INSERT INTO `customer_return_auth`
					 	(					
						
					
						`comment`,
						`cr_auth`,
						`cus_id`,
						`qid`,
						`wid`,
						`won_id`,
						`goods_exp_date`,
						`mode_of_communication`,
						`date_of_communication`,
						`time`,
						`communicated_by`,
						`marketing_dep_obs`,
						`ins_production`,
						`qtbr`,
						`tcdq`,
						`goods_inspected`,
						`entered_by`,
						`entered_date`


						
					)
					VALUES
						(
						
							'$cment',
							'$ca',
							'$cid',
							'$qid',
							'$wid',
							'$won_id',
							'$geo',
							'$moc',
							'$doc',
							'$time',
							'$cb',
							'$mdo',
							'$ifp',
							'$qtbr',
							'$tcdq',
							'$goods_ins',
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
	$responce['cra_num'] = $ca;
	echo (json_encode($responce));
	mysqli_close($con_main);
?>