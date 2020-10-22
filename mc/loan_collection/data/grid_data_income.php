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
		
		$col_set = array('category','amount','comment','date');

		
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
				other_income.id,
				other_income.category,
				other_income.amount,
				other_income.comment,
				other_income.date,
				other_income.status
				FROM
				other_income
				".$where." ".$order_by."
				LIMIT ".$start.", ".$length;
		
		$sql = mysqli_query($con_main, $query);
		
		$i = 0;

		$result_array['data'] = "";
		
		while ($row = mysqli_fetch_assoc($sql)){
			
			$data['DT_RowId'] = "row_".$row['id'];
			$data['category'] = $row['category'];
			$data['amount'] = $row['amount'];
			$data['comment'] = $row['comment'];
			$data['date'] = $row['date'];
			
			$result_array['data'][$i] = $data;
			$i = $i + 1;
		}

	  $filtered_row_count_query = "SELECT
									COUNT(id) AS ROW_COUNT,
										other_income.category,
										other_income.amount,
										other_income.comment,
										other_income.date,
										other_income.status
								FROM
								other_income".$where;

		$filtered_row_count_sql = mysqli_query($con_main, $filtered_row_count_query);
		$filtered_row_count = mysqli_fetch_assoc($filtered_row_count_sql);
		$filtered_records = $filtered_row_count['ROW_COUNT'];

		$full_row_count_sql = mysqli_query($con_main, "SELECT COUNT(id) AS C FROM other_income");
		$full_row_count = mysqli_fetch_array($full_row_count_sql);

		$total_records = $full_row_count['C'];

		$result_array['draw'] = $draw;
		$result_array['recordsTotal'] = $total_records;
		$result_array['recordsFiltered'] = (!empty($search['value'])) ? $filtered_records : $total_records;
		$result_array['query'] = $query;
		mysqli_close($con_main);
		
		echo (json_encode($result_array));
	?>