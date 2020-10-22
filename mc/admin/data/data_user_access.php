<?php
	header('Content-Type: application/json');
	
	include ('../../config.php');
	
	$term = $_REQUEST['term'];
	$status = $_REQUEST['status'];
	$access_code = $_REQUEST['id'];
	$user_code = $_REQUEST['user_id'];
	$emp_no = $_REQUEST['emp_no'];
	$first_name = $_REQUEST['first_name'];
	$last_name = $_REQUEST['last_name'];
	
	$responce = "";
	$result = true;
	$message = "";
	$debug = "";
	$where = "";
	
	if ($term != NULL && !empty($term)){
		$where .= (!empty($where)) ? " AND " : " WHERE";
		$where .= " (MU.FIRST_NAME LIKE '%".$term."%' OR 
				   MU.LAST_NAME LIKE '%".$term."%' OR 
				   MU.EMP_NO LIKE '%".$term."%') ";
	}
	
	if ($status != NULL && !empty($status)){
		$where .= (!empty($where)) ? " AND " : " WHERE";
		$where .= " MA.`STATUS` = '$status' ";
	}else{
		$where .= (!empty($where)) ? " AND " : " WHERE";
		$where .= " MA.`STATUS` = 1 ";
	}
	
	if ($access_code != NULL && !empty($access_code) && $access_code != 0){
		$where .= (!empty($where)) ? " AND " : " WHERE";
		$where .= " MA.ACCESS_CODE = '$access_code' ";
	}

	if ($user_code != NULL && !empty($user_code) && $user_code != 0){
		$where .= (!empty($where)) ? " AND " : " WHERE";
		$where .= " MU.USER_CODE = '$user_code' ";
	}
	
	if ($emp_no != NULL && !empty($emp_no)){
		$where .= (!empty($where)) ? " AND " : " WHERE";
		$where .= " MU.EMP_NO = '$emp_no' ";
	}
	
	if ($first_name != NULL && !empty($first_name)){
		$where .= (!empty($where)) ? " AND " : " WHERE";
		$where .= " MU.FIRST_NAME = '$first_name' ";
	}
	
	if ($last_name != NULL && !empty($last_name)){
		$where .= (!empty($where)) ? " AND " : " WHERE";
		$where .= " MU.LAST_NAME = '$last_name' ";
	}
	
	$query =   "SELECT
	MA.ACCESS_CODE,
	MU.USER_CODE,
	MU.EMP_NO,
	CONCAT_WS(' ',MU.FIRST_NAME,MU.LAST_NAME) AS EMP_NAME,
	MU.FIRST_NAME,
	MU.LAST_NAME,
	MA.USERNAME,
	MA.`PASSWORD`,
	MA.USER_CREATED,
	MA.DATE_CREATED,
	MA.`STATUS`
	FROM
	mas_access AS MA
	INNER JOIN mas_user AS MU ON MA.USER_CODE = MU.USER_CODE".$where." ORDER BY EMP_NAME ASC ";
	
	$sql = mysqli_query($con_main, $query);

	$data = "";

	if ($sql){
		$i = 0;

		while ($res = mysqli_fetch_assoc($sql)){
			$data[$i] = $res;
			
			$i++;
		}
	}else{
		$result = false;
		$message .= "Access fetching failed.";
		$debug .= "SQL Error: (".mysqli_errno($con_main).") ".mysqli_error($con_main);
	}
	
	mysqli_close($con_main);

	$responce['data'] = $data;
	$responce['result'] = $result;
	$responce['message'] = $message;
	$responce['debug'] = $debug;
	
	echo (json_encode($responce));
?>