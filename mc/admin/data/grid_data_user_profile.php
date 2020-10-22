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
	// $col_set = array('T0.EMP_NO','T0.FIRST_NAME','T0.LAST_NAME','T2.DESIGNATION','T1.LOCATION','T3.DEPARTMENT','T0.MOBILE_NO','T0.EMAIL');
	$col_set = array('T0.EMP_NO','EMP_NAME','T2.DESIGNATION','T1.LOCATION','T3.DEPARTMENT','T0.MOBILE_NO','T0.EMAIL');
	
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

				if ($i == 1){
					// Convert column index to table column + LIKE + 'search term'
					$where .= " (T0.FIRST_NAME LIKE '%$term%' OR  T0.LAST_NAME LIKE '%$term%') ";
				}else{
					$where .= $col_set[$i]." LIKE '%$term%' ";
				}
			}
			
			$i = $i + 1;
		}
	}
	
	$query = "SELECT
	T0.USER_CODE,
	T0.EMP_NO,
	T0.FIRST_NAME,
	T0.LAST_NAME,
	CONCAT_WS(' ',T0.FIRST_NAME,T0.LAST_NAME) AS EMP_NAME,
	T0.MOBILE_NO,
	T0.EMAIL,
	T0.`STATUS`,
	T1.LOCATION,
	T2.DESIGNATION,
	T3.DEPARTMENT
	FROM
	mas_user AS T0
	LEFT JOIN mas_location AS T1 ON T1.LOC_CODE = T0.LOCATION
	LEFT JOIN mas_designation AS T2 ON T2.DES_CODE = T0.DESIGNATION
	LEFT JOIN mas_department AS T3 ON T3.DEP_CODE = T0.DEPARTMENT".$where." ".$order_by."
	LIMIT ".$start.", ".$length;
	
	$sql = mysqli_query($con_main, $query);
	
	$i = 0;

	$result_array['data'] = "";
	
	while ($row = mysqli_fetch_assoc($sql)){
		$data['DT_RowId'] = "row_".$row['USER_CODE'];
		$data['emp_no'] = $row['EMP_NO'];
		$data['emp_name'] = $row['EMP_NAME'];
		/*$data['first_name'] = $row['FIRST_NAME'];
		$data['last_name'] = $row['LAST_NAME'];*/
		$data['location'] = $row['LOCATION'];
		$data['designation'] = $row['DESIGNATION'];
		$data['department'] = $row['DEPARTMENT'];
		$data['phone'] = $row['MOBILE_NO'];
		$data['email'] = $row['EMAIL'];
		$data['status'] = ($row['STATUS'] == 1) ? "Active" : "Inactive";
		
		$result_array['data'][$i] = $data;
		
		$i = $i + 1;
	}

	$filtered_row_count_query = "SELECT
	COUNT(T0.USER_CODE) AS ROW_COUNT
	FROM
	mas_user AS T0
	LEFT JOIN mas_location AS T1 ON T1.LOC_CODE = T0.LOCATION
	LEFT JOIN mas_designation AS T2 ON T2.DES_CODE = T0.DESIGNATION
	LEFT JOIN mas_department AS T3 ON T3.DEP_CODE = T0.DEPARTMENT".$where;
	
	$filtered_row_count_sql = mysqli_query($con_main, $filtered_row_count_query);
	$filtered_row_count = mysqli_fetch_assoc($filtered_row_count_sql);
	$filtered_records = $filtered_row_count['ROW_COUNT'];
	
	$full_row_count_sql = mysqli_query($con_main, "SELECT COUNT(T0.USER_CODE) AS C FROM mas_user AS T0");
	$full_row_count = mysqli_fetch_array($full_row_count_sql);
	
	$total_records = $full_row_count['C'];
	
	$result_array['draw'] = $draw; // Return same draw id received from datatable client request
	$result_array['recordsTotal'] = $total_records; // Return total record count in table
	$result_array['recordsFiltered'] = (!empty($search['value'])) ? $filtered_records : $total_records; // If search term is available return filtered records count or else total record count
	//$result_array['query'] = $query; //For debugging
	
	mysqli_close($con_main);
	
	echo (json_encode($result_array));
?>