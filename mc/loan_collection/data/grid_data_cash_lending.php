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
	
	$col_set = array('loanid','loan_date','nic','loan_amount','interest_amount','loan_type','loantypes','duration','net_payment','due_amount','collector_day','startdate','enddate','collector','status');
	
	$order_by = "";
	$where = "";

	foreach ($order_cols as $order_col){

		$order_by .= (empty($order_by)) ? " ORDER BY " : ", ";

		$order_col_index = $order_col['column']; 

		$order_col_dir = $order_col['dir']; 

		$order_by .= $col_set[$order_col_index]." ".$order_col_dir." ";
	}

	if (empty($order_by)){
	    $order_by = " ORDER BY id DESC ";
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
			loan_lending.id,
			loan_lending.loanid,
			loan_lending.loan_date,
			loan_lending.nic,
			loan_lending.loan_amount,
			loan_lending.interest_amount,
			loan_lending.loan_type,
			loan_lending.loantypes,
			loan_lending.duration ,
			loan_lending.net_payment,
			loan_lending.due_amount,
			loan_lending.collector_day,
			loan_lending.startdate,
			loan_lending.enddate,
			loan_lending.collector_name,
			loan_lending.status
			FROM `loan_lending`
 				".$where." ".$order_by."
			LIMIT ".$start.", ".$length;
	
	$sql = mysqli_query($con_main, $query);
	
	$i = 0;

	$result_array['data'] = "";
	
	while ($row = mysqli_fetch_assoc($sql)){
		
		$data['DT_RowId'] = "row_".$row['id'];
		$data['loanid'] = $row['loanid'];
		$data['loan_date'] = $row['loan_date'];
		$data['nic'] = $row['nic'];
		$data['loan_amount'] = $row['loan_amount'];
		$data['interest_amount'] = $row['interest_amount'];
		$data['loan_type'] = $row['loan_type'];
		$data['loantypes'] = $row['loantypes'];
		$data['duration'] = $row['duration'];
		$data['net_payment'] = $row['net_payment'];
		$data['due_amount'] = $row['due_amount'];
		$data['collector_day'] = $row['collector_day'];
		$data['startdate'] = $row['startdate'];
		$data['enddate'] = $row['enddate'];
		$data['collector_name'] = $row['collector_name'];
		$data['status'] = $row['status'];
		$result_array['data'][$i] = $data;
		$i = $i + 1;
	}

  $filtered_row_count_query = "SELECT
  									COUNT(id) AS ROW_COUNT,
									loan_lending.loanid,
									loan_lending.loan_date,
									loan_lending.customer_id,
									loan_lending.loan_amount,
									loan_lending.interest_amount,
									loan_lending.loan_type,
									loan_lending.loantypes,
									loan_lending.duration,
									loan_lending.net_payment,
									loan_lending.due_amount,
									loan_lending.collector_day,
									loan_lending.startdate,
									loan_lending.enddate,
									loan_lending.collector_name,
									loan_lending.status
									FROM loan_lending".$where;

	$filtered_row_count_sql = mysqli_query($con_main, $filtered_row_count_query);
	$filtered_row_count = mysqli_fetch_assoc($filtered_row_count_sql);
	$filtered_records = $filtered_row_count['ROW_COUNT'];

	$full_row_count_sql = mysqli_query($con_main, "SELECT COUNT(id) AS C FROM loan_lending");
	$full_row_count = mysqli_fetch_array($full_row_count_sql);

	$total_records = $full_row_count['C'];

	$result_array['draw'] = $draw;
	$result_array['recordsTotal'] = $total_records;
	$result_array['recordsFiltered'] = (!empty($search['value'])) ? $filtered_records : $total_records;
	$result_array['query'] = $query;
	mysqli_close($con_main);
	
	echo (json_encode($result_array));
?>