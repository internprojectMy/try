<?php
	require ('../../config.php');
	
	$crn_id = $_REQUEST['id'];
	
	$result_array = array();
	$result = false;
	$message = "";
	$debug = "";
	
	$emp_query =  "SELECT
						loan_customer.id,
						loan_customer.calling_name,
						loan_customer.nic,
						loan_customer.registered_date,
						loan_customer.name_full,
						loan_customer.name_initial,
						loan_customer.dob,
						loan_customer.income,
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
						loan_customer.gurantor1_name,
						loan_customer.gurantor1_nic,
						loan_customer.gurantor1_address,
						loan_customer.gurantor1_occupation,
						loan_customer.gurantor1_income,
						loan_customer.gurantor1_tele,
						loan_customer.gurantor2_name,
						loan_customer.gurantor2_nic,
						loan_customer.gurantor2_address,
						loan_customer.gurantor2_occupation,
						loan_customer.gurantor2_income,
						loan_customer.gurantor2_tele,
						loan_customer.`status`
				FROM
					loan_customer
				WHERE
					loan_customer.id = '$crn_id'";
	
	$emp_sql = mysqli_query($con_main, $emp_query);
	
	$emp = mysqli_fetch_assoc($emp_sql);
	$debug = $emp_query;

	if ($emp_sql){
		$result = true;
		$message = "Success";

		$result_array['data'] = $emp;
	}else{
		$result = false;
		$message = "Error results";
	}

	$result_array['result'] = $result;
	$result_array['message'] = $message;
	$result_array['debug'] = $debug;
	
	mysqli_close($conn);
	
	echo (json_encode($result_array));
?>