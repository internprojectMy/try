<?php
	header('Content-Type: application/json');
	
	session_start();
	
	function validate($val,$type = NULL){
		require ('../config.php');

		$bool_return = array();

		$bool_return['result'] = (!empty($val)) ? true : false;

		if ($bool_return['result']){
			if ($type == "DUPLICATE_CHECK"){
				$duplicate_check_query = "SELECT
				COUNT(MA.USER_CODE) AS C
				FROM
				mas_access AS MA
				WHERE
				MA.USERNAME = '$val'";

				$duplicate_check_sql = mysqli_query($con_main, $duplicate_check_query);
				$duplicate_check_res = mysqli_fetch_assoc($duplicate_check_sql);

				$duplicated_row_count = $duplicate_check_res['C'];

				$bool_return['result'] = ($duplicated_row_count > 0) ? false : true;

				if (!$bool_return['result']){
					$bool_return['message'] = "Username is already exist.";
				}
			}
		}else{
			$bool_return['message'] = "Username or password can not be empty.";
		}

		mysqli_close($con_main);

		return $bool_return;
	}

	require ('../config.php');
	
	$op = $_REQUEST['operation'];
	$id = $_REQUEST['id'];
	$first_name = $_REQUEST['first_name'];
	$last_name = $_REQUEST['last_name'];
	$gender = $_REQUEST['gender'];
	$dob = $_REQUEST['dob'];
	$nic = $_REQUEST['nic'];
	$emp_no = $_REQUEST['emp_no'];
	$designation = $_REQUEST['designation'];
	$location = $_REQUEST['location'];
	$cost_center = $_REQUEST['cost_center'];
	$department = $_REQUEST['department'];
	$joined_date = $_REQUEST['joined_date'];
	$phone = $_REQUEST['phone'];
	$email = $_REQUEST['email'];
	$resigned_date = $_REQUEST['resigned_date'];
	$status = $_REQUEST['status'];
	$created_user = $_SESSION['USER_CODE'];

	$username = (isset($_REQUEST['username'])) ? $_REQUEST['username'] : "";
	$password = (isset($_REQUEST['password'])) ? $_REQUEST['password'] : "";
	$enc_password = sha1($password);

	$validation_pass = true;
	$validation_result = "";
	
	$query = "";
	$result = true;
	$message = "";
	$debug = "";
	$responce = array();
	
	if ($op == "insert"){
		$profile_query = "INSERT INTO `mas_user` (`EMP_NO`, `FIRST_NAME`, `LAST_NAME`, `GENDER`, `DOB`, `NIC`, `LOCATION`, `COST_CENTER`, `DEPARTMENT`, `DESIGNATION`, `MOBILE_NO`, `EMAIL`, `DATE_JOINED`, `DATE_LEFT`, `DATE_CREATED`, `USER_CREATED`, `STATUS`) 
		VALUES ('$emp_no', '$first_name', '$last_name', '$gender', '$dob', '$nic', '$location', '$cost_center', '$department', '$designation', '$phone', '$email', '$joined_date', '$resigned_date', NOW(), '$created_user', '$status')";

		$profile_sql = mysqli_query ($con_main, $profile_query);
	
		$id = mysqli_insert_id($con_main);

		if ($profile_sql){
			$message .= "<br>Profile created successfully.";
		}else{
			$result = false;
			$message .= "<br>Profile create failed.";
			$debug .= "\nError SQL. (".mysqli_errno($con_main).") ".mysqli_error($con_main)." Query: ".$profile_query;
		}

		$validation_result = validate($username);

		if (!$validation_result['result']){
			$validation_pass = false;
			$debug .= $validation_result['message'];
		}

		$validation_result = validate($password);

		if (!$validation_result['result']){
			$validation_pass = false;
			$debug .= $validation_result['message'];
		}

		$validation_result = validate($username,'DUPLICATE_CHECK');

		if (!$validation_result['result']){
			$validation_pass = false;
			$debug .= $validation_result['message'];
		}

		if ($validation_pass){
			$access_query = "INSERT INTO `mas_access` (
				`USER_CODE`,
				`USERNAME`,
				`PASSWORD`,
				`GROUP_ALLOCATED`,
				`OVERRIDE_LOC`,
				`OVERRIDE_DEP`,
				`OVERRIDE_DES`,
				`DATE_CREATED`,
				`USER_CREATED`,
				`STATUS`
			)
			VALUES
			(
				'$id',
				'$username',
				'$enc_password',
				0,
				0,
				0,
				0,
				NOW(),
				'$created_user',
				'$status'
			)";

			$access_sql = mysqli_query($con_main, $access_query);

			if ($access_sql){
				$message .= "<br>Access created successfully.";
			}else{
				$result = false;
				$message .= "<br>Access create failed.";
				$debug .= "\nError SQL. (".mysqli_errno($con_main).") ".mysqli_error($con_main)." Query: ".$access_query;
			}
		}else{
			$message .= "<br>Access creation escaped.";
		}
	}else if ($op == "update"){
		$profile_query = "UPDATE `mas_user`
		SET `EMP_NO` = '$emp_no',
		`FIRST_NAME` = '$first_name',
		`LAST_NAME` = '$last_name',
		`GENDER` = '$gender',
		`DOB` = '$dob',
		`NIC` = '$nic',
		`LOCATION` = '$location',
		`COST_CENTER` = '$cost_center',
		`DEPARTMENT` = '$department',
		`DESIGNATION` = '$designation',
		`MOBILE_NO` = '$phone',
		`EMAIL` = '$email',
		`STATUS` = '$status',
		`DATE_JOINED` = '$joined_date',
		`DATE_LEFT` = '$resigned_date'
		WHERE
		(`USER_CODE` = '$id')";

		$profile_sql = mysqli_query ($con_main, $profile_query);

		if ($profile_sql){
			$message .= "<br>Profile updated successfully.";
		}else{
			$result = false;
			$message .= "<br>Profile update failed.";
			$debug .= "\nError SQL. (".mysqli_errno($con_main).") ".mysqli_error($con_main)." Query: ".$profile_query;
		}

		$have_access = false;
		$cur_access_code = 0;
		$cur_access_status = 0;
		$cur_username = "";
		$cur_password = "";

		$cur_access_query = "SELECT
		MA.ACCESS_CODE,
		MA.USERNAME,
		MA.`PASSWORD`,
		MA.`STATUS`
		FROM
		mas_access AS MA
		WHERE
		MA.USER_CODE = $id";

		$cur_access_sql = mysqli_query($con_main,$cur_access_query);
		$cur_access_num = mysqli_num_rows($cur_access_sql);
		$cur_access = mysqli_fetch_assoc($cur_access_sql);

		$have_access = ($cur_access_num > 0) ? true : false;

		$validation_result = validate($username);

		if (!$validation_result['result']){
			$validation_pass = false;
			$debug .= $validation_result['message'];
		}

		$validation_result = validate($password);

		if (!$validation_result['result']){
			$validation_pass = false;
			$debug .= $validation_result['message'];
		}

		if ($have_access){
			$cur_access_code = $cur_access['ACCESS_CODE'];
			$cur_access_status = $cur_access['STATUS'];
			$cur_username = $cur_access['USERNAME'];
			$cur_password = $cur_access['PASSWORD'];

			if ($validation_pass){
				if ($username == $cur_username && $password == $cur_password){
					$message .= "<br>Access details found and not changed.";
				}else if ($username == $cur_username && $password != $cur_password){
					$access_query = "UPDATE `mas_access` SET `PASSWORD`='$enc_password', `STATUS`=1 WHERE (`ACCESS_CODE`='$cur_access_code')";
					$access_sql = mysqli_query ($con_main, $access_query);

					if ($access_sql){
						$message .= "<br>Access updated successfully.";
					}else{
						$result = false;
						$message .= "<br>Access update failed.";
						$debug .= "\nError SQL. (".mysqli_errno($con_main).") ".mysqli_error($con_main)." Query: ".$access_query;
					}
				}else if ($username != $cur_username && $password == $cur_password){
					$validation_result = validate($username,'DUPLICATE_CHECK');

					if (!$validation_result['result']){
						$validation_pass = false;
						$debug .= $validation_result['message'];
					}

					if ($validation_pass){
						$access_query = "UPDATE `mas_access` SET `USERNAME`='$username', `STATUS`=1 WHERE (`ACCESS_CODE`='$cur_access_code')";
						$access_sql = mysqli_query ($con_main, $access_query);

						if ($access_sql){
							$message .= "<br>Access updated successfully.";
						}else{
							$result = false;
							$message .= "<br>Access update failed.";
							$debug .= "\nError SQL. (".mysqli_errno($con_main).") ".mysqli_error($con_main)." Query: ".$access_query;
						}
					}else{
						$message .= "<br>Access details found but not changed.";
					}
				}else if ($username != $cur_username && $password != $cur_password){
					$validation_result = validate($username,'DUPLICATE_CHECK');

					if (!$validation_result['result']){
						$validation_pass = false;
						$debug .= $validation_result['message'];
					}

					if ($validation_pass){
						$access_query = "UPDATE `mas_access` SET `USERNAME`='$username', `PASSWORD`='$enc_password', `STATUS`=1 WHERE (`ACCESS_CODE`='$cur_access_code')";
						$access_sql = mysqli_query ($con_main, $access_query);

						if ($access_sql){
							$message .= "<br>Access updated successfully.";
						}else{
							$result = false;
							$message .= "<br>Access update failed.";
							$debug .= "\nError SQL. (".mysqli_errno($con_main).") ".mysqli_error($con_main)." Query: ".$access_query;
						}
					}else{
						$message .= "<br>Access details found but not changed.";
					}
				}
			}else{
				$access_query = "UPDATE `mas_access` SET `STATUS`=0 WHERE (`ACCESS_CODE`='$cur_access_code')";
				$access_sql = mysqli_query ($con_main, $access_query);

				if ($access_sql){
					$message .= "<br>Access disabled.";
				}else{
					$result = false;
					$message .= "<br>Access disable failed.";
					$debug .= "\nError SQL. (".mysqli_errno($con_main).") ".mysqli_error($con_main)." Query: ".$access_query;
				}
			}
		}else{
			$validation_result = validate($username,'DUPLICATE_CHECK');

			if (!$validation_result['result']){
				$validation_pass = false;
				$debug .= $validation_result['message'];
			}

			if ($validation_pass){
				$access_query = "INSERT INTO `mas_access` (
					`USER_CODE`,
					`USERNAME`,
					`PASSWORD`,
					`GROUP_ALLOCATED`,
					`OVERRIDE_LOC`,
					`OVERRIDE_DEP`,
					`OVERRIDE_DES`,
					`DATE_CREATED`,
					`USER_CREATED`,
					`STATUS`
				)
				VALUES
				(
					'$id',
					'$username',
					'$enc_password',
					0,
					0,
					0,
					0,
					NOW(),
					'$created_user',
					'$status'
				)";

				$access_sql = mysqli_query($con_main, $access_query);

				if ($access_sql){
					$message .= "<br>Access created successfully.";
				}else{
					$result = false;
					$message .= "<br>Access create failed.";
					$debug .= "\nError SQL. (".mysqli_errno($con_main).") ".mysqli_error($con_main)." Query: ".$access_query;
				}
			}else{
				$message .= "<br>Neither access details found nor created new.";
			}
		}
	}else if ($op == "upload-image"){
		$obj_id = $_REQUEST['obj_id'];
		$moved_url = "profile_pix/".$obj_id.".jpg";

		if (!empty($_FILES["file"])){
			if ($_FILES["file"]["error"] > 0){
				$result = false;
				$message .= "<br>Error uploading file.<br>".$_FILES["file"]["error"];
				$debug .= "\nError: " . $_FILES["file"]["error"];
			}else{
				$responce['file_name'] = $_FILES["file"]["name"];
				$responce['file_size_kb'] = $_FILES["file"]["size"]/1024;

				$file_moved = move_uploaded_file($_FILES["file"]["tmp_name"],$moved_url);

				if ($file_moved){
					$upload_query = "UPDATE `mas_user` SET `PHOTO` = '$moved_url' WHERE (`USER_CODE` = '$obj_id')";
					$sql = mysqli_query($con_main, $upload_query);

					if ($sql){
						$message .= "<br>Image uploaded successfully.";
					}else{
						$result = false;
						$message .= "<br>Image upload failed.";
						$debug .= "\nError SQL. (".mysqli_errno($con_main).") ".mysqli_error($con_main)." Query: ".$upload_query;
					}
				}else{
					$result = false;
					$message .= "<br>Error moving uploaded file.";
					$debug .= "\nError moving uploaded file";
				}
			}
		}else{
			$result = false;
			$message .= "<br>No file to upload.";
			$debug .= "\nError: No file to upload";
		}
	}
	
	$responce['operation'] = $op;
	$responce['result'] = $result;
	$responce['id'] = $id;
	$responce['message'] = $message;
	$responce['debug'] = $debug;
	
	echo (json_encode($responce));
	
	mysqli_close($con_main);
?>