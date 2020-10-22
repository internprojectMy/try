<?php
	header('Content-Type: application/json');
	
	include ('../config.php');
	
	$result_array = array();
	
	$draw = $_REQUEST['draw'];
	$length = $_REQUEST['length'];
	$start = $_REQUEST['start'];
	$columns = $_REQUEST['columns'];
	$order_cols = $_REQUEST['order'];
	$search = $_REQUEST['search'];
	$data = array();
	
	$col_set = array('author_details.AUTHOR_ID,author_details.AUTHOR_NAME');

	$order_by = "";
	$where = "";
	
	$where1 .= "WHERE author_details.STATUS ='1' ";
	foreach ($order_cols as $order_col){
		$order_by .= (empty($order_by)) ? " ORDER BY " : ", ";
		
		$order_col_index = $order_col['column']; 
		$order_col_dir = $order_col['dir']; 
		
		$order_by .= $col_set[$order_col_index]." ".$order_col_dir." ";
	}
	
	if (empty($order_by)){
	    $order_by = " ORDER BY author_details.AUTHOR_ID DESC ";
	}

	if (!empty($search['value'])){
		$term = $search['value'];
		$i = 0;
		foreach ($columns as $column){
			
			$col_name = $column['name'];
			$col_searchable = $column['searchable'];
			
			if ($col_searchable == "true"){
				$where .= (empty($where)) ? " AND " : " OR ";
				$where .= ($col_set[$i]." LIKE '%$term%' ");
			}
			
			$i = $i + 1;
		}
	}

$query =   "SELECT
author_details.AUTHOR_ID,
author_details.AUTHOR_NAME,
author_details.DISPLAY_NAME,
author_details.AUTHOR_NIC,
author_details.`STATUS`,
author_details.DOB,
author_details.EMPLOYEE_STATUS
FROM `author_details` ".$where1." ".$where." ".$order_by."
									LIMIT ".$start.", ".$length;
	
	$sql = mysqli_query($con_main, $query);
	
	$i = 0;

	$result_array['data'] = "";
	
	while ($row = mysqli_fetch_assoc($sql)){
		
		$data['DT_RowId'] = "row_".$row['AUTHOR_ID'];
		$data['AUTHOR_ID'] = $row['AUTHOR_ID'];
		$data['AUTHOR_NAME'] = $row['AUTHOR_NAME'];

		$result_array['data'][$i] = $data;
		$i = $i + 1;
	}
    	$filtered_row_count_query = "SELECT
									COUNT(author_details.AUTHOR_ID) AS ROW_COUNT
									FROM author_details ".$where1." ".$where;

$filtered_row_count_sql = mysqli_query($con_main, $filtered_row_count_query);
$filtered_row_count = mysqli_fetch_assoc($filtered_row_count_sql);
$filtered_records = $filtered_row_count['ROW_COUNT'];
 
$full_row_count_sql = mysqli_query($con_main, "SELECT
												COUNT(author_details.AUTHOR_ID) AS C
												FROM
												author_details ".$where1);
$full_row_count = mysqli_fetch_array($full_row_count_sql);

$total_records = $full_row_count['C']; 

	$result_array['draw'] = $draw; // Return same draw id received from datatable client request
	$result_array['recordsTotal'] = $total_records; // Return total record count in table
	$result_array['recordsFiltered'] = (!empty($search['value'])) ? $filtered_records : $total_records; // If search term is available return filtered records 
	$result_array['query'] = $query; 
	$result_array['filter'] = $filtered_row_count_query; 
	$result_array['full'] = $full_query; 
	
	mysqli_close($con_main);
	
	echo (json_encode($result_array));
?>