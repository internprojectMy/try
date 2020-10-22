<?php
	require ('../../config.php');
	
	$term = $_GET['term'];
	
	$result_array = array();
	$debug = "";
	
	$emp_query =  "SELECT
						loan_lending.id,
                        loan_lending.loanid,
                        loan_customer.calling_name
				  FROM
                        loan_lending
                  INNER JOIN loan_customer ON loan_lending.customer_id = loan_customer.id
				  WHERE
						loan_customer.calling_name LIKE '%$term%'
				  OR    loan_customer.nic LIKE '%$term%'
				  OR    loan_lending.loanid LIKE '%$term%'
				  ORDER BY
                        loan_lending.loan_date ASC";
	
	$emp_sql = mysqli_query($con_main, $emp_query);
	
	$count = 0;
	
	while ($emp = mysqli_fetch_array($emp_sql)){
		$name = $emp['loanid']." - ".$emp['calling_name'];
		
		$result_array[$count] = array('id' => $emp['id'],'name' => $name);
		
		$count++;
	}
	
	mysqli_close($con_main);
	$result_array['debug'] = $emp_query;
	
	echo (json_encode($result_array));
?>