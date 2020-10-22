<?php
	require ('../../config.php');
	
	$crn_id = $_REQUEST['id'];
	
	$result_array = array();
	$result = false;
	$message = "";
	$debug = "";
	
	$emp_query =  "SELECT
						loan_lending.id,
						loan_lending.loanid,
						loan_lending.loan_date,
						loan_lending.customer_id,
						loan_lending.loan_amount,
						loan_lending.interest_amount,
						loan_lending.net_payment,
						loan_lending.total_due,
						loan_lending.due_amount,
						loan_lending.loan_type,
						loan_lending.loan_day,
						loan_lending.start_date,
						loan_lending.end_date,
						loan_lending.duration,
						loan_lending.collector_id
                  FROM
	                   `loan_lending`
				WHERE
					loan_lending.id = '$crn_id'";
	
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