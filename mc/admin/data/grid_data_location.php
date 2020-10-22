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
	$col_set = array('T0.LOCATION','T0.CITY','T0.TEL1','T0.SYSTEM_EFFECTED','T0.STATUS_TEXT');
	
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
				$where .= $col_set[$i]." LIKE '%$term%' ";
			}
			
			$i = $i + 1;
		}
	}
	
	$query = "SELECT
	T0.LOC_CODE,
	T0.LOCATION,
	T0.CITY,
	T0.TEL1 AS TEL,
	IF(T0.SYSTEM_ID = 0, 'All', T1.MOD_NAME) AS SYSTEM_EFFECTED,
	IF(T0.`STATUS` = 1, 'Active', 'Inactive') AS STATUS_TEXT
	FROM
	mas_location AS T0
	LEFT JOIN mas_module AS T1 ON T0.SYSTEM_ID = T1.MOD_CODE".$where." ".$order_by."
	LIMIT ".$start.", ".$length;
	
	$sql = mysqli_query($con_main, $query);
	
	$i = 0;

	$result_array['data'] = "";
	
	while ($row = mysqli_fetch_assoc($sql)){
		$data['DT_RowId'] = "row_".$row['LOC_CODE'];
		$data['location'] = $row['LOCATION'];
		$data['city'] = $row['CITY'];
		$data['tel'] = $row['TEL'];
		$data['system_effected'] = $row['SYSTEM_EFFECTED'];
		$data['status'] = $row['STATUS_TEXT'];
		
		$result_array['data'][$i] = $data;
		
		$i = $i + 1;
	}

	$filtered_row_count_query = "SELECT
	IFNULL(COUNT(T0.LOC_CODE), 0) AS ROW_COUNT
	FROM
	mas_location AS T0
	LEFT JOIN mas_module AS T1 ON T0.SYSTEM_ID = T1.MOD_CODE".$where;
	
	$filtered_row_count_sql = mysqli_query($con_main, $filtered_row_count_query);
	$filtered_row_count = mysqli_fetch_assoc($filtered_row_count_sql);
	$filtered_records = $filtered_row_count['ROW_COUNT'];
	
	$full_row_count_sql = mysqli_query($con_main, "SELECT COUNT(T0.LOC_CODE) AS C FROM mas_location AS T0");
	$full_row_count = mysqli_fetch_array($full_row_count_sql);
	
	$total_records = $full_row_count['C'];
	
	$result_array['draw'] = $draw; // Return same draw id received from datatable client request
	$result_array['recordsTotal'] = $total_records; // Return total record count in table
	$result_array['recordsFiltered'] = (!empty($search['value'])) ? $filtered_records : $total_records; // If search term is available return filtered records count or else total record count
	//$result_array['query'] = $query; //For debugging
	
	mysqli_close($con_main);
	
	echo (json_encode($result_array));
?>