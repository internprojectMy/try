<?php
	require ('../../config.php');
	
	$term = $_GET['term'];
	
	$result_array = array();
	$debug = "";
	
	$emp_query =  "SELECT
						loan_customer.id,
						loan_customer.calling_name,
						loan_customer.nic,
						loan_customer.registered_date
				  FROM
                        loan_customer
				  WHERE
						loan_customer.calling_name LIKE '%$term%'
				  OR    loan_customer.nic LIKE '%$term%'
				  ORDER BY
                        loan_customer.registered_date ASC";
	
	$emp_sql = mysqli_query($con_main, $emp_query);
	
	$count = 0;
	
	while ($emp = mysqli_fetch_array($emp_sql)){
		$name = $emp['nic']." - ".$emp['calling_name'];
		
		$result_array[$count] = array('id' => $emp['id'], 'register' => $emp['registered_date'], 'name' => $name);
		
		$count++;
	}
	
	mysqli_close($con_main);
	$result_array['debug'] = $emp_query;
	
	echo (json_encode($result_array));
?>