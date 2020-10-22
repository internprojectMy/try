<?php
	header('Content-Type: application/json');
	
	session_start();
	
	require_once ('../config.php');
	
	$op = $_REQUEST['operation'];
	$id = $_REQUEST['id'];
	$check_code = $_REQUEST['check_code'];
	$icon = $_REQUEST['icon'];
	$is_in_menu = $_REQUEST['is_in_menu'];
	$is_main_module = $_REQUEST['is_main_module'];
	$is_openable = $_REQUEST['is_openable'];
	$parent_module = $_REQUEST['parent_module'];
	$menu_level = $_REQUEST['menu_level'];
	$menu_url = $_REQUEST['menu_url'];
	$mod_name = $_REQUEST['mod_name'];
	$status = $_REQUEST['status'];
	$url = $_REQUEST['url'];
	$user = $_SESSION['USER_CODE'];
	
	$query = "";
	$success = true;
	$message = "";
	$debug = "";
	$responce = array();

	if(!empty($icon)){
		$icon_code_explode_array = explode('-',$icon,2);
		$icon_code_prefix = $icon_code_explode_array[0];

		$icon = $icon_code_prefix." ".$icon;
	}
	
	if ($op == "insert"){
		$query = "INSERT INTO `mas_module` (
			`MOD_NAME`,
			`CHECK_CODE`,
			`URL`,
			`ICON`,
			`MAIN_MODULE`,
			`PARENT_MODULE_CODE`,
			`IN_MENU`,
			`MENU_LEVEL`,
			`INTERNAL_MENU_URL`,
			`OPENABLE`,
			`ADDED_BY`,
			`ADDED_ON`,
			`STATUS`
		)
		VALUES
		(
			'$mod_name',
			'$check_code',
			'$url',
			'$icon',
			'$is_main_module',
			'$parent_module',
			'$is_in_menu',
			'$menu_level',
			'$menu_url',
			'$is_openable',
			'$user',
			NOW(),
			'$status'
		)";
	}else if ($op == "update"){
		if ($is_main_module == 1 && (empty($parent_module) || $parent_module == 0)){
			$parent_module = $id;
		}

		$query = "UPDATE `mas_module`
		SET `MOD_NAME` = '$mod_name',
		`CHECK_CODE` = '$check_code',
		`URL` = '$url',
		`ICON` = '$icon',
		`MAIN_MODULE` = '$is_main_module',
		`PARENT_MODULE_CODE` = '$parent_module',
		`IN_MENU` = '$is_in_menu',
		`MENU_LEVEL` = '$menu_level',
		`INTERNAL_MENU_URL` = '$menu_url',
		`OPENABLE` = '$is_openable',
		`STATUS` = '$status'
		WHERE
		(`MOD_CODE` = $id)";
	}
	
	$sql = mysqli_query ($con_main, $query);
	
	$id = ($op == "insert") ? mysqli_insert_id($con_main) : $id;
	
	if ($sql){

		if ($op == "insert" && $is_main_module == 1){
			$self_update_main_module_code = mysqli_query($con_main, "UPDATE `mas_module` SET `PARENT_MODULE_CODE`='$id' WHERE MOD_CODE=$id");

			if ($self_update_main_module_code){
				$success = true;
				$message .= "Operation Succeed";
			}else{
				$success = false;
				$message .= "Module saved successfully but error in self updating main module code";
				$debug = "Error SQL: (".mysqli_errno($con_main).") ".mysqli_error($con_main);
			}
		}else{
			$success = true;
			$message .= "Operation Succeed";
		}

	}else{
		$success = false;
		$message .= "Operation Failed";
		$debug = "Error SQL: (".mysqli_errno($con_main).") ".mysqli_error($con_main);
	}
	
	$responce['operation'] = $op;
	$responce['result'] = $success;
	$responce['id'] = $id;
	$responce['message'] = $message;
	$responce['debug'] = $debug;
	
	echo (json_encode($responce));
	
	mysqli_close($con_main);
?>