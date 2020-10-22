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
	
	$col_set = array('branch_name','center_name','center_code','group_name','group_code','group_date');
	
	$order_by = "";
	$where = "";

	foreach ($order_cols as $order_col){

		$order_by .= (empty($order_by)) ? " ORDER BY " : ", ";

		$order_col_index = $order_col['column']; 

		$order_col_dir = $order_col['dir']; 

		$order_by .= $col_set[$order_col_index]." ".$order_col_dir." ";
	}

	if (empty($order_by)){
	    $order_by = " ORDER BY group_id DESC ";
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
branch.branch_id,
branch.branch_name,
branch.branch_code,
center.center_name,
center.center_code,
`group`.group_name,
`group`.group_code
FROM
branch
INNER JOIN center ON branch.branch_id = center.branch_id
INNER JOIN `group` ON center.center_id = group.center_id
 ".$where." ".$order_by."
			LIMIT ".$start.", ".$length;
	
	$sql = mysqli_query($con_main, $query);
	
	$i = 0;

	$result_array['data'] = "";
	
	while ($row = mysqli_fetch_assoc($sql)){
		
		$data['DT_RowId'] = "row_".$row['center_id'];
		$data['branch_name'] = $row['branch_name'];
		$data['center_name'] = $row['center_name'];
		$data['center_code'] = $row['center_code'];
		$data['center_date'] = $row['center_date'];
		$data['group_name'] = $row['group_name'];
		$data['group_code'] = $row['group_code'];
		
		$result_array['data'][$i] = $data;
		$i = $i + 1;
	}

  $filtered_row_count_query = "SELECT
								COUNT(center_id) AS ROW_COUNT,
								branch.branch_id,
								branch.branch_name,
								branch.branch_code,
								center.center_name,
								center.center_code,
								`group`.group_name,
								`group`.group_code
								FROM
								branch
								INNER JOIN center ON branch.branch_id = center.branch_id
								INNER JOIN `group` ON center.center_id = group.center_id".$where;

	$filtered_row_count_sql = mysqli_query($con_main, $filtered_row_count_query);
	$filtered_row_count = mysqli_fetch_assoc($filtered_row_count_sql);
	$filtered_records = $filtered_row_count['ROW_COUNT'];

	$full_row_count_sql = mysqli_query($con_main, "SELECT COUNT(center_id) AS C FROM group");
	$full_row_count = mysqli_fetch_array($full_row_count_sql);

	$total_records = $full_row_count['C'];

	$result_array['draw'] = $draw;
	$result_array['recordsTotal'] = $total_records;
	$result_array['recordsFiltered'] = (!empty($search['value'])) ? $filtered_records : $total_records;
	$result_array['query'] = $query;
	mysqli_close($con_main);
	
	echo (json_encode($result_array));
?>