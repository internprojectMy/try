<?php
	require ('../../config.php');
	
	$term = $_GET['term'];
	
	$result_array = array();
	$debug = "";
	
	$emp_query =  "SELECT
						E.crn_id AS ID,
						E.epf_no AS EPF,
						E.name_initial AS `NAME`,
						E.nic AS NIC
					FROM
						emp_registration AS E
					WHERE
						E.NIC LIKE '%$term%'
					OR E.name_initial LIKE '%$term%'
					AND E.active = '1'
					ORDER BY
						EPF ASC,
					   `NAME` ASC";
	
	$emp_sql = mysqli_query($conn, $emp_query);
	
	$count = 0;
	
	while ($emp = mysqli_fetch_array($emp_sql)){
		$name = $emp['NIC']." - ".$emp['NAME'];
		
		$result_array[$count] = array('crn_id' => $emp['ID'], 'epf' => $emp['EPF'], 'name' => $name);
		
		$count++;
	}
	
	mysqli_close($conn);
	$result_array['debug'] = $emp_query;
	
	echo (json_encode($result_array));
?>