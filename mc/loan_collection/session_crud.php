<?php
	header('Content-Type: application/json');
	session_start();
	require ('../config.php');
	
	$user = $_SESSION['USER_CODE'];
	$date = $_REQUEST['date'];
	$id = $_REQUEST['id'];
	$op = $_REQUEST['op'];

	$query = "";
	$result = true;
	$message = "";
	$debug = "";
	$responce = array();

	if($op == 'get'){
		
	$update_query	= "SELECT
						session_date.session_date,
						session_date.id
					FROM
						`session_date`
					WHERE
						session_date.id = '1'";


	}else if($op == 'update'){

	$update_query = "UPDATE `session_date`
						SET 
						 `session_date` = '$date',
						 `last_edit_by` = '$user',
						 `last_edit_date` = NOW()
						WHERE
							(`id` = '1')";
	}
	
	

	 $profile_sql = mysqli_query($con_main, $update_query);

	
	if ($profile_sql){

		 $num_rows = mysqli_num_rows($profile_sql);
    
    if ($num_rows > 0){
        $i = 0;
    
        while ($rows = mysqli_fetch_assoc($profile_sql)){
            $data[$i] = $rows;
            $i++;
        }
    }
		$success = true;
		$message = "Success";
	}else{
		$success = false;
		$message = "Error SQL: (".mysqli_errno($con_main).") ".mysqli_error($con_main);
	}
	
	$responce['operation'] = $op;
	$responce['result'] = $success;
	$responce['message'] = $message;
	$responce['debug'] = $debug;
	$responce['data'] = $data;
	echo (json_encode($responce));
	
	mysqli_close($con_main);

?>