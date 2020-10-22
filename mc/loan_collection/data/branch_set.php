<?php
	require ('../../config.php');
	
	$crn_id = $_REQUEST['id'];
	
	$result_array = array();
	$result = false;
	$message = "";
	$debug = "";
	
	$emp_query =  "SELECT
			branch.branch_id,
			branch.branch_name,
			branch.branch_code,
			branch.branch_comment,
			branch.branch_date,
			branch.`status`
			FROM
			branch
			WHERE
			branch.branch_id = 'branch.branch_id'";
	
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