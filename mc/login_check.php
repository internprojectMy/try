<?php
	header("Content-Type: application/json; charset=utf-8");
	
	// Referencing database connection library
	require_once ('config.php');
	
	// Catch username and password, sanitizing user input to prevent possible sql injections
	$username = mysqli_real_escape_string($con_main, $_POST['login-username']);
	$password = mysqli_real_escape_string($con_main, $_POST['login-password']);

	$responce = array();
	$html = "";
	$result = true;
	
	// Check username & password not empty
	if ((!empty($username) || $username != NULL) && (!empty($password) || $password != NULL)) {
		$enc_password = sha1($password);
		
		$access_query = "SELECT
						MA.ACCESS_CODE,
						MU.USER_CODE,
						MU.EMP_NO,
						MU.FIRST_NAME,
						MU.LAST_NAME,
						MU.GENDER,
						MU.DOB,
						MU.EMAIL,
						MU.COST_CENTER,
						MU.PHOTO,
						MU.`STATUS` AS USER_STATUS,
						MA.GROUP_ALLOCATED AS `GROUP`,
						MA.OVERRIDE_LOC AS LOC_CODE,
						MA.OVERRIDE_DEP AS DEP_CODE,
						MA.OVERRIDE_DES AS DES_CODE,
						MA.`STATUS` AS ACCESS_STATUS
						FROM
						mas_access AS MA
						INNER JOIN mas_user AS MU ON MA.USER_CODE = MU.USER_CODE
						WHERE
						MA.USERNAME = '$username' AND
						MA.`PASSWORD` = '$enc_password'";
		
		$access_sql = mysqli_query ($con_main, $access_query);
		$access_row = mysqli_fetch_array ($access_sql);
		$num_rows = mysqli_num_rows ($access_sql);
		
		if ($num_rows > 0){
			if ($access_row['ACCESS_STATUS'] == 0){
				$result = false;
				$html = '<div class="error-message alert alert-danger alert-dismissable"><i class="fa fa-close"></i>Access denied</div>';
			}
			
			if ($access_row['USER_STATUS'] == 0){
				$result = false;
				$html =  '<div class="error-message alert alert-danger alert-dismissable"><i class="fa fa-close"></i>User denied</div>';
			}
			
			if ($access_row['ACCESS_STATUS'] != 0 && $access_row['USER_STATUS'] != 0){
				session_start();
				
				// Initializing Session
				$_SESSION['ACCESS_CODE'] = $access_row['ACCESS_CODE'];
				$_SESSION['USER_CODE'] = $access_row['USER_CODE'];
				$_SESSION['EMP_NO'] = $access_row['EMP_NO'];
				$_SESSION['FIRST_NAME'] = $access_row['FIRST_NAME'];
				$_SESSION['LAST_NAME'] = $access_row['LAST_NAME'];
				$_SESSION['EMAIL'] = $access_row['EMAIL'];
				$_SESSION['PHOTO_URL'] = $access_row['PHOTO'];
				$_SESSION['GROUP'] = $access_row['GROUP'];
				$_SESSION['LOC_CODE'] = $access_row['LOC_CODE'];
				$_SESSION['COST_CENTER'] = $access_row['COST_CENTER'];
				$_SESSION['DEP_CODE'] = $access_row['DEP_CODE'];
				$_SESSION['DES_CODE'] = $access_row['DES_CODE'];
				
				session_write_close();
				
				$html =  '<div class="alert alert-success alert-dismissable"><i class="fa fa-refresh fa-spin fa-fw"></i>&nbsp;Success.Wait till redirect..</div>';
			}
		}else{
			$result = false;
			$html =  '<div class="alert alert-danger alert-dismissable"><i class="fa fa-close"></i> Incorrect Username/Password</div>';
		}
	}else{
		$result = false;
		$html =  '<div class="alert alert-danger alert-dismissable"><i class="fa fa-close"></i> Fields cannot be empty</div>';
	}
	
	// Close db connection
	mysqli_close($con_main);

	$responce['result'] = $result;
	$responce['html'] = $html;

	echo (json_encode($responce));
	
	exit();
?>