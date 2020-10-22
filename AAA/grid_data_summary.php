<?php
	header('Content-Type: application/json');
	
	include ('config.php');
	
	$result_array = array();
	
	$draw = $_REQUEST['draw'];
	$length = $_REQUEST['length'];
	$start = $_REQUEST['start'];
	$columns = $_REQUEST['columns'];
	$order_cols = $_REQUEST['order'];
	$search = $_REQUEST['search'];
	$data = array();
	
	// Column arrangement in grid. index to table column mapping array
		$col_set = array('T1.ground_id','T2.team_id','T0.match_note','T0.match_score','T0.match_overs','T0.Inning','T0.match_result','T0.official_note','T0.playerName1','T0.playerName2','T0.playerName3','T0.player1_score','T0.player2_score','T0.player3_score','T0.bowler1','T0.bowler2','T0.bowler3','T0.bowler1_wickets','T0.bowler2_wickets','T0.bowler3_wickets');
	
	// Where and Order By Clause string
	$order_by = " ORDER BY T0.summary_id DESC ";
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
			}
			
			$i = $i + 1;
		}
	}
	
	$query = "SELECT
                    T0.summary_id,
                    T1.groundname,
                    T2.teamname,
                    T0.match_note,
                    T0.match_score,
                    T0.match_overs,
                    T0.Inning,
                    T0.match_result,
                    T0.official_note,
                    T0.playerName1,
                    T0.playerName2,
                    T0.playerName3,
                    T0.player1_score,
                    T0.player2_score,
                    T0.player3_score,
                    T0.bowler1,
                    T0.bowler2,
                    T0.bowler3,
                    T0.bowler1_wickets,
                    T0.bowler2_wickets,
                    T0.bowler3_wickets
                    FROM
								match_summary AS T0
								INNER JOIN slground AS T1 ON T1.ground_id = T0.ground_id
								INNER JOIN slteam AS T2 ON T2.team_id = T0.team_id
								  ".$where." ".$order_by."
														LIMIT ".$start.", ".$length;
	
	$sql = mysqli_query($con_main, $query);
	
	$i = 0;

	$result_array['data'] = "";
	
	while ($row = mysqli_fetch_assoc($sql)){


		$data['DT_RowId'] = "row_".$row['summary_id'];

		$data['id'] = $row['summary_id'];
		$data['ground_id'] = $row['ground_id'];
		$data['team_id'] = $row['team_id'];
		$data['match_note'] = $row['match_note'];
        $data['match_score'] = $row['match_score'];
        $data['match_overs'] = $row['match_overs'];
        $data['Inning'] = $row['Inning'];
        $data['match_result'] = $row['match_result'];
        $data['official_note'] = $row['official_note'];
        $data['playerName1'] = $row['playerName1'];
        $data['playerName2'] = $row['playerName2'];
        $data['playerName3'] = $row['playerName3'];
        $data['player1_score'] = $row['player1_score'];
        $data['player2_score'] = $row['player2_score'];
        $data['player3_score'] = $row['player3_score'];
        $data['bowler1'] = $row['bowler1'];
        $data['bowler2'] = $row['bowler2'];
        $data['bowler3'] = $row['bowler3'];
        $data['bowler1_wickets'] = $row['bowler1_wickets'];
        $data['bowler2_wickets'] = $row['bowler2_wickets'];
        $data['bowler3_wickets'] = $row['bowler3_wickets'];

		$result_array['data'][$i] = $data;
		
		$i = $i + 1;
	}

	$filtered_row_count_query = "SELECT
								    	COUNT(T0.summary_id) AS ROW_COUNT,
                                        T0.ground_id,
                                        T0.team_id,
                                        T0.match_note,
                                        T0.match_score,
                                        T0.match_overs,
                                        T0.Inning,
                                        T0.match_result,
                                        T0.official_note,
                                        T0.playerName1,
                                        T0.playerName2,
                                        T0.playerName3,
                                        T0.player1_score,
                                        T0.player2_score,
                                        T0.player3_score,
                                        T0.bowler1,
                                        T0.bowler2,
                                        T0.bowler3,
                                        T0.bowler1_wickets,
                                        T0.bowler2_wickets,
                                        T0.bowler3_wickets
										FROM
										match_summary AS T0 ".$where;
	
	$filtered_row_count_sql = mysqli_query($con_main, $filtered_row_count_query);
	$filtered_row_count = mysqli_fetch_assoc($filtered_row_count_sql);
	$filtered_records = $filtered_row_count['ROW_COUNT'];
	
	$full_row_count_sql = mysqli_query($con_main, "SELECT COUNT(T0.MOD_CODE) AS C FROM mas_module AS T0");
	$full_row_count = mysqli_fetch_array($full_row_count_sql);
	
	$total_records = $full_row_count['C'];
	
	$result_array['draw'] = $draw; // Return same draw id received from datatable client request
	$result_array['recordsTotal'] = $total_records; // Return total record count in table
	$result_array['recordsFiltered'] = (!empty($search['value'])) ? $filtered_records : $total_records; // If search term is available return filtered records count or else total record count
	$result_array['query'] = $query; //For debugging
	
	mysqli_close($con_main);
	
	echo (json_encode($result_array));
?>