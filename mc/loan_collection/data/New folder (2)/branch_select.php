<?php
	require ('../../config.php');
	
	$term = $_GET['term'];
	
	$result_array = array();
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
						branch.branch_name LIKE '%$term%'
				  OR    branch.branch_code LIKE '%$term%'
				  ORDER BY
                        branch.branch_date ASC";
	
	$emp_sql = mysqli_query($con_main, $emp_query);
	
	$count = 0;
	
	while ($emp = mysqli_fetch_array($emp_sql)){
		$name = $emp['branch_name']." - ".$emp['branch_code'];
		
		$result_array[$count] = array('id' => $emp['branch_id'], 'register' => $emp['branch_date'], 'name' => $branch_name);
		
		$count++;
	}
	
	mysqli_close($con_main);
	$result_array['debug'] = $emp_query;
	
	echo (json_encode($result_array));
?>