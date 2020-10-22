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
	//**** search*/
	$col_set = array('T0.ground_id','T0.team_id','T0.match_note','T0.match_score','T0.match_overs','T0.Inning');
	/*** */
	$order_by = "";
	$where = "";
	$where1 = " WHERE T0.match_score = '1'";

	foreach ($order_cols as $order_col){
		$order_by .= (empty($order_by)) ? " ORDER BY " : ", ";
		
		$order_col_index = $order_col['column']; 
		$order_col_dir = $order_col['dir']; 
		
		$order_by .= $col_set[$order_col_index]." ".$order_col_dir." ";
	}
	
	if (empty($order_by)){
	    $order_by = " ORDER BY T0.summary_id DESC ";
	}
	if (!empty($search['value'])){
		$term = $search['value'];
		$i = 0;
		foreach ($columns as $column){
			
			$col_name = $column['name'];
			$col_searchable = $column['searchable'];
			
			if ($col_searchable == "true"){
				$where .= (empty($where)) ? " AND " : " OR ";
				$where .= $col_set[$i]." LIKE '%$term%' ";
			}
			
			$i = $i + 1;
		}
	}
                    /*** */
                    $query_1 = "SELECT
                    T0.summary_id,
                    T0.ground_id,
                    T0.team_id,
                    T0.match_note,
                    T0.`match_score`,
                    T0.match_overs,
                    T0.Inning
                    FROM match_summary AS T0 ".$where1." ".$where." ".$order_by."
						LIMIT ".$start.", ".$length;

/***** */	
	$sql_1 = mysqli_query($con_main,$query_1);
	
	$i = 0;

	$result_array['data'] = "";
	
	/***
	 * 
	 * TEST
	 */
## Fetch records
// $empQuery = "select * from employee WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
// $empRecords = mysqli_query($con, $empQuery);
$data = array();

while ($row_1 = mysqli_fetch_assoc($sql_1)) {
   $data[] = array( 
	'id' => $row_1['summary_id'],
	'ground_id' => $row_1['ground_id'],
	'team_id' => $row_1['team_id'],
	'match_note' => $row_1['match_note'],
	'match_overs' => $row_1['match_overs'],
	'Inning' => $row_1['Inning']

   );
}

	 /***
	  * END TEST
	  */
	while ($row_1 = mysqli_fetch_assoc($sql_1)){
		/**** */
		//$data['AUTHOR_ID'] = "row_".$row['id'];
		$data['id'] = $row_1['summary_id'];
		$data['ground_id'] = $row_1['ground_id'];
		$data['team_id'] = $row_1['team_id'];
		$data['match_note'] = $row_1['match_note'];
        $data['match_overs'] = $row_1['match_overs'];
        $data['Inning'] = $row_1['Inning'];

		$result_array['data'][$i] = $data;
		$i = $i + 1;
    }
    /**** */
    	$filtered_row_count_query = "SELECT
								    	COUNT(T0.summary_id) AS ROW_COUNT,
                                        T0.ground_id
                                        T0.team_id,
										T0.match_note,
										T0.match_score,
										T0.match_overs,
										T0.Inning
										FROM
										match_summary AS T0 " .$where1." ".$where;

$filtered_row_count_sql = mysqli_query($con_main, $filtered_row_count_query);
$filtered_row_count = mysqli_fetch_assoc($filtered_row_count_sql);
$filtered_records = $filtered_row_count['ROW_COUNT'];
/**** */
$full_row_count_sql = mysqli_query($con_main, "SELECT COUNT(T0.summary_id) AS C FROM match_summary AS T0");
/**** */
$full_row_count = mysqli_fetch_array($full_row_count_sql);

$total_records = $full_row_count['C'];

$result_array['draw'] = $draw;
	$result_array['recordsTotal'] = $total_records;
	$result_array['recordsFiltered'] = (!empty($search['value'])) ? $filtered_records : $total_records;
	$result_array['query'] = $query; 
	$result_array['filter'] = $data;
	$result_array['data'] = $data;
	mysqli_close($con_main);
	
	echo (json_encode($result_array));
?>