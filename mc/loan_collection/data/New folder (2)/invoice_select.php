<?php
	require ('../../config.php');
	
	$term = $_GET['term'];
	$today = date("Y-m-d");	

	$result_array = array();
	$debug = "";
	
// 	$emp_query =  "SELECT
// 						loan_collecting.id,
// 						loan_lending.loanid,
// 						loan_collecting.collector_name
// 					FROM
// 						loan_collecting
// 					INNER JOIN loan_lending ON loan_collecting.loan_id = loan_lending.id
// 					WHERE
// 						loan_collecting.collect_date = '$today'
// 					AND loan_lending.loanid LIKE '%$term%'
// 					OR loan_collecting.collector_name LIKE '%$term%'";

   $emp_query = "SELECT
					loan_collecting.id,
					loan_lending.loanid,
					loan_collecting.collector_name
				FROM
					loan_collecting
				INNER JOIN loan_lending ON loan_collecting.loan_id = loan_lending.id
				WHERE
					loan_collecting.collect_date LIKE '%$term%'
				ORDER BY
					loan_lending.loanid ASC"; 
						
	$emp_sql = mysqli_query($con_main, $emp_query);
	
	$count = 0;
	
	while ($emp = mysqli_fetch_array($emp_sql)){
		$name = $emp['loanid']." - ".$emp['collector_name'];
		
		$result_array[$count] = array('id' => $emp['id'], 'register' => $emp['registered_date'], 'name' => $name);
		
		$count++;
	}
	
	mysqli_close($con_main);
	$result_array['debug'] = $emp_query;
	
	echo (json_encode($result_array));
?>