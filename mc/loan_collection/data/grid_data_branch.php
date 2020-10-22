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
		
		$col_set = array('branch_name','branch_code','branch_comment','branch_date');

		
		$order_by = "";
		$where = "";

		foreach ($order_cols as $order_col){

			$order_by .= (empty($order_by)) ? " ORDER BY " : ", ";

			$order_col_index = $order_col['column']; 

			$order_col_dir = $order_col['dir']; 

			$order_by .= $col_set[$order_col_index]." ".$order_col_dir." ";
		}

		if (empty($order_by)){
		    $order_by = " ORDER BY branch_id DESC ";
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
				branch_id,
				branch_name,
				branch_code,
				branch_comment,
				branch_date,
				status
					
				FROM
				branch".$where." ".$order_by."
				LIMIT ".$start.", ".$length;
		
		$sql = mysqli_query($con_main, $query);
		
		$i = 0;

		$result_array['data'] = "";
		
		while ($row = mysqli_fetch_assoc($sql)){
			
			$data['DT_RowId'] = "row_".$row['branch_id'];
			$data['branch_name'] = $row['branch_name'];
			$data['branch_code'] = $row['branch_code'];
			$data['branch_comment'] = $row['branch_comment'];
			$data['branch_date'] = $row['branch_date'];
			
			$result_array['data'][$i] = $data;
			$i = $i + 1;
		}

	  $filtered_row_count_query = "SELECT
									COUNT(branch_id) AS ROW_COUNT,
									branch_name,
									branch_code,
									branch_comment,
									center_date,
									status
								FROM
								branch".$where;

		$filtered_row_count_sql = mysqli_query($con_main, $filtered_row_count_query);
		$filtered_row_count = mysqli_fetch_assoc($filtered_row_count_sql);
		$filtered_records = $filtered_row_count['ROW_COUNT'];

		$full_row_count_sql = mysqli_query($con_main, "SELECT COUNT(branch_id) AS C FROM branch");
		$full_row_count = mysqli_fetch_array($full_row_count_sql);

		$total_records = $full_row_count['C'];

		$result_array['draw'] = $draw;
		$result_array['recordsTotal'] = $total_records;
		$result_array['recordsFiltered'] = (!empty($search['value'])) ? $filtered_records : $total_records;
		$result_array['query'] = $query;
		mysqli_close($con_main);
		
		echo (json_encode($result_array));
	?>