<?php
	header('Content-Type: application/json');
	
	include ('../../config.php');
	
	$result_array = array();
	
	$draw = $_REQUEST['draw'];
	$length = $_REQUEST['length'];
	$start = $_REQUEST['start'];
	$columns = $_REQUEST['columns'];
	$order_cols = $_REQUEST['order'];
	$search = $_REQUEST['search'];
	$data = array();
	
	// Column arrangement in grid. index to table column mapping array
	$col_set = array('T0.category');
	
	// Where and Order By Clause string
	$order_by = "";
	$where = "";
	
	// Generate order by string
	// Loop over all ordered fields (inside array) received from datatable client
	foreach ($order_cols as $order_col){
		// if order by string is empty start order by clause with ORDER BY else append order by with comma
		$order_by .= (empty($order_by)) ? " ORDER BY " : ", ";
		
		$order_col_index = $order_col['column']; // Order column index no
		$order_col_dir = $order_col['dir']; // Order direction (asc/desc)
		
		// Generate order by string (convert index to table column + direction)
		$order_by .= $col_set[$order_col_index]." ".$order_col_dir." ";
	}
	
	// Generate where clause if search term is not empty (received with client's request)
	if (!empty($search['value'])){
		// get search term
		$term = $search['value'];
		
		$i = 0;
		
		// Loop over available columns
		foreach ($columns as $column){
			// Get current column name and searchable (true/false)
			$col_name = $column['name'];
			$col_searchable = $column['searchable'];
			
			// If current column is searchable
			if ($col_searchable == "true"){
				// if where string is empty start where clause with WHERE else append where string with OR
				$where .= (empty($where)) ? " WHERE " : " OR ";

				// Convert column index to table column + LIKE + 'search term'
				$where .= $col_set[$i]." LIKE '%".$term."%' ";
				$where .= $col_set[$i]." LIKE '%$term%' ";
			}
			
			$i = $i + 1;
		}
	}	

	$query = "SELECT
				loan_collector.id,
				loan_collector.collector_code,
				loan_collector.collector_name,
				loan_collector.user_name,
				loan_collector.password,
				loan_collector.`status`
			FROM
	           `loan_collector`";
	
	$sql = mysqli_query($con_main, $query);
	
	$i = 0;

	$result_array['data'] = "";
	$status;
	while ($row = mysqli_fetch_assoc($sql)){
		if($row['status']==1){
			$status = "Active";
		}else{
			$status = "Inactive";
		}

		$data['DT_RowId'] = "row_".$row['id'];
		$data['status'] = $status;
		$data['collectorname'] = $row['collector_name'];
		$data['collectorcode'] = $row['collector_code'];
		$data['username'] = $row['user_name'];
		$data['pass'] = $row['password'];
		$result_array['data'][$i] = $data;
		
		$i = $i + 1;
	}
	
	$result_array['draw'] = $draw; // Return same draw id received from datatable client request
	$result_array['recordsTotal'] = $total_records; // Return total record count in table
	$result_array['recordsFiltered'] = (!empty($search['value'])) ? $filtered_records : $total_records; // If search term is available return 
	
	mysqli_close($con_main);
	
	echo (json_encode($result_array));
?>