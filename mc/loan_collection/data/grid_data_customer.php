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
		
		$col_set = array('registered_date', 'member_number', 'name_full', 'name_initial', 'dob', 'nic','spouse_name','spouse_contact','spouse_dob','spouse_nic','spouse_income', 'customer_home_address','customer_mobile1','customer_fixed1','status');

		
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
			loan_customer.id,
			loan_customer.branch_name,
			loan_customer.center_name,
			loan_customer.group_name,
			loan_customer.registered_date,
			loan_customer.member_number,
			loan_customer.name_full,
			loan_customer.name_initial,
			loan_customer.dob,
			loan_customer.nic,
			loan_customer.spouse_name,
			loan_customer.spouse_contact,
			loan_customer.spouse_dob,
			loan_customer.spouse_nic,
			loan_customer.spouse_income,
			loan_customer.customer_home_address,
			loan_customer.customer_mobile1,
			loan_customer.customer_fixed1,
			loan_customer.customer_business_address,
			loan_customer.customer_mobile2,
			loan_customer.customer_fixed2,
			loan_customer.status
			FROM
			loan_customer
						".$where." ".$order_by."
							LIMIT ".$start.", ".$length;
		
		$sql = mysqli_query($con_main, $query);
		
		$i = 0;

		$result_array['data'] = "";
		
		while ($row = mysqli_fetch_assoc($sql)){
			
			$data['DT_RowId'] = "row_".$row['id'];
			$data['registered_date'] = $row['registered_date'];
			$data['member_number'] = $row['member_number'];
			$data['name_full'] = $row['name_full'];
			$data['name_initial'] = $row['name_initial'];
            $data['dob'] = $row['dob'];
            $data['nic'] = $row['nic'];
            $data['spouse_name'] = $row['spouse_name'];
            $data['spouse_contact'] = $row['spouse_contact'];
            $data['spouse_dob'] = $row['spouse_dob'];
            $data['spouse_nic'] = $row['spouse_nic'];
            $data['spouse_income'] = $row['spouse_income'];
            $data['customer_home_address'] = $row['customer_home_address'];
            $data['customer_mobile1'] = $row['customer_mobile1'];
            $data['customer_fixed1'] = $row['customer_fixed1'];
            $data['status'] = $row['status'];
			
			$result_array['data'][$i] = $data;
			$i = $i + 1;
		}

	  $filtered_row_count_query = "SELECT
									COUNT(id) AS ROW_COUNT,
									
                                        loan_customer.branch_name,
                                        loan_customer.center_name,
                                        loan_customer.group_name,
                                        loan_customer.registered_date,
                                        loan_customer.member_number,
                                        loan_customer.name_full,
                                        loan_customer.name_initial,
                                        loan_customer.dob,
                                        loan_customer.nic,
                                        loan_customer.spouse_name,
                                        loan_customer.spouse_contact,
                                        loan_customer.spouse_dob,
                                        loan_customer.spouse_nic,
                                        loan_customer.spouse_income,
                                        loan_customer.customer_home_address,
                                        loan_customer.customer_mobile1,
                                        loan_customer.customer_fixed1,
                                        loan_customer.customer_business_address,
                                        loan_customer.customer_mobile2,
                                        loan_customer.customer_fixed2,
                                        loan_customer.status
                                        FROM
                                        loan_customer".$where;

		$filtered_row_count_sql = mysqli_query($con_main, $filtered_row_count_query);
		$filtered_row_count = mysqli_fetch_assoc($filtered_row_count_sql);
		$filtered_records = $filtered_row_count['ROW_COUNT'];

		$full_row_count_sql = mysqli_query($con_main, "SELECT COUNT(id) AS C FROM loan_customer");
		$full_row_count = mysqli_fetch_array($full_row_count_sql);

		$total_records = $full_row_count['C'];

		$result_array['draw'] = $draw;
		$result_array['recordsTotal'] = $total_records;
		$result_array['recordsFiltered'] = (!empty($search['value'])) ? $filtered_records : $total_records;
		$result_array['query'] = $query;
		mysqli_close($con_main);
		
		echo (json_encode($result_array));
	?>