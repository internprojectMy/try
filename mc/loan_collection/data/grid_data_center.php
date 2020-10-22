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
	
	$col_set = array('T1.branch_name','T0.center_name','T0.center_code','T0.cash_name','T0.cash_day','T0.status');
	
	$order_by = "";
	$where = "";

	foreach ($order_cols as $order_col){

		$order_by .= (empty($order_by)) ? " ORDER BY " : ", ";

		$order_col_index = $order_col['column']; 

		$order_col_dir = $order_col['dir']; 

		$order_by .= $col_set[$order_col_index]." ".$order_col_dir." ";
	}

	if (empty($order_by)){
	    $order_by = " ORDER BY T0.center_id DESC ";
	}
 
    if (!empty($search['value'])){
		// get search term
		$term = $search['value'];
		
		$i = 0;
		
		foreach ($columns as $column){
		    
			$col_name = $column['name'];
			$col_searchable = $column['searchable'];
			
			if ($col_searchable == "true"){
			
				$where .= (empty($where)) ? " WHERE " : " OR ";
				$where .= $col_set[$i]." LIKE '%$term%' ";
			}
			$i = $i + 1;
		}
	}


    $query ="SELECT
				T0.center_id,
				T0.branch_id,
				T0.center_name,
				T0.center_code,
				T0.cash_name,
				T0.cash_day,
				T0.status,
				T1.branch_name
			FROM
			center AS T0 
			INNER JOIN branch AS T1 ON T0.branch_id = T1.branch_id ".$where." ".$order_by."
			LIMIT ".$start.", ".$length;
	
	$sql = mysqli_query($con_main, $query);
	
	$i = 0;

	$result_array['data'] = "";
	
	while ($row = mysqli_fetch_assoc($sql)){
		
		$data['DT_RowId'] = "row_".$row['center_id'];
		$data['branch_name'] = $row['branch_name'];
		$data['center_name'] = $row['center_name'];
		$data['center_code'] = $row['center_code'];
		$data['cash_name'] = $row['cash_name'];
		$data['cash_day'] = $row['cash_day'];
		$data['status'] = $row['status'];
		$result_array['data'][$i] = $data;
		$i = $i + 1;
	}

  $filtered_row_count_query = "SELECT
								COUNT(T0.center_id) AS ROW_COUNT,
								T0.branch_id,
								T0.center_name,
								T0.center_code,
								T0.center_date,
								T0.cash_name,
								T0.cash_day,
								T0.status,
								T1.branch_name
							FROM
							center AS T0 
							INNER JOIN branch AS T1 ON T0.branch_id = T1.branch_id ".$where;

	$filtered_row_count_sql = mysqli_query($con_main, $filtered_row_count_query);
	$filtered_row_count = mysqli_fetch_assoc($filtered_row_count_sql);
	$filtered_records = $filtered_row_count['ROW_COUNT'];

	$full_row_count_sql = mysqli_query($con_main, "SELECT COUNT(T0.center_id) AS C FROM center	 AS T0");
	$full_row_count = mysqli_fetch_array($full_row_count_sql);

	$total_records = $full_row_count['C'];

	$result_array['draw'] = $draw;
	$result_array['recordsTotal'] = $total_records;
	$result_array['recordsFiltered'] = (!empty($search['value'])) ? $filtered_records : $total_records;
	$result_array['query'] = $query;
	mysqli_close($con_main);
	
	echo (json_encode($result_array));
?>