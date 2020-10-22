<?php 
	
	header('Content-Type: application/json');

	include ('../../config.php');


	$nic = $_REQUEST['nic'];

	$responce = array();
	$massege = "";

	$main_query = "SELECT
		loan_customer.id,
		loan_customer.branch_name,
		loan_customer.center_name,
		loan_customer.group_name,
		loan_customer.registered_date,
		loan_customer.member_number,
		loan_customer.name_full,
		loan_customer.name_initial,
		loan_customer.dob,
		loan_customer.nic,
		loan_customer.spouse_name,
		loan_customer.spouse_contact,
		loan_customer.spouse_dob,
		loan_customer.spouse_nic,
		loan_customer.spouse_income,
		loan_customer.customer_home_address,
		loan_customer.customer_mobile1,
		loan_customer.customer_fixed1,
		loan_customer.customer_business_address,
		loan_customer.customer_mobile2,
		loan_customer.customer_fixed2,
		loan_customer.`status`,
		center.center_name,
		center.cash_day,
		center.cash_name
	FROM
		loan_customer
	INNER JOIN center ON loan_customer.center_name = center.center_id
	WHERE
		loan_customer.nic = '$nic'";

	$result = mysqli_query($con_main, $main_query);
	$row_data = mysqli_fetch_array($result);

	$responce['cash_day'] = $row_data['cash_day'];
	$responce['cash_name'] = $row_data['cash_name'];
	$responce['center_name'] = $row_data['center_name'];
	echo json_encode($responce);

	mysqli_close($con_main);

 ?>