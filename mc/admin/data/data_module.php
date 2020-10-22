<?php
header('Content-Type: application/json');

include ('../../config.php');

$where = "";
$responce = array();
$data = "";
$result = true;
$message = "";

$id = (isset($_REQUEST['id']) && $_REQUEST['id'] != NULL && !empty($_REQUEST['id'])) ? $_REQUEST['id'] : 0;
$check_code = (isset($_REQUEST['check_code']) && $_REQUEST['check_code'] != NULL && !empty($_REQUEST['check_code'])) ? $_REQUEST['check_code'] : "";
$is_main = (isset($_REQUEST['is_main']) && $_REQUEST['is_main'] != NULL && !empty($_REQUEST['is_main'])) ? $_REQUEST['is_main'] : "";
$parent_module_code = (isset($_REQUEST['parent_module']) && $_REQUEST['parent_module'] != NULL && !empty($_REQUEST['parent_module'])) ? $_REQUEST['parent_module'] : 0;
$is_in_menu = (isset($_REQUEST['is_in_menu']) && $_REQUEST['is_in_menu'] != NULL && !empty($_REQUEST['is_in_menu'])) ? $_REQUEST['is_in_menu'] : "";
$is_openable = (isset($_REQUEST['is_openable']) && $_REQUEST['is_openable'] != NULL && !empty($_REQUEST['is_openable'])) ? $_REQUEST['is_openable'] : "";
$menu_level = (isset($_REQUEST['menu_level']) && $_REQUEST['menu_level'] != NULL && !empty($_REQUEST['menu_level'])) ? $_REQUEST['menu_level'] : 0;
$status = (isset($_REQUEST['status']) && $_REQUEST['status'] != NULL && !empty($_REQUEST['status'])) ? $_REQUEST['status'] : "";

$query = "SELECT
MM.MOD_CODE AS ID,
MM.MOD_NAME AS MODULE_NAME,
MM.CHECK_CODE,
MM.URL,
MM.ICON,
MM.MAIN_MODULE AS IS_MAIN,
IFNULL(MM.PARENT_MODULE_CODE, '') AS PARENT_MODULE_CODE,
IFNULL(MAIN.MOD_NAME, '') AS MAIN_MODULE_NAME,
MM.IN_MENU AS IS_IN_MENU,
MM.MENU_LEVEL,
MM.INTERNAL_MENU_URL,
MM.OPENABLE AS IS_OPENABLE,
MM.ADDED_BY,
MM.ADDED_ON,
MM.`STATUS`
FROM
mas_module AS MM
LEFT JOIN mas_module AS MAIN ON MM.PARENT_MODULE_CODE = MAIN.MOD_CODE";

if ($id > 0){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= " MM.MOD_CODE = '$id' ";
}

if ($parent_module_code > 0){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= " MM.PARENT_MODULE_CODE = '$parent_module_code' ";
}

if ($menu_level > 0){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= " MM.MENU_LEVEL = '$menu_level' ";
}

if (!empty($check_code)){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= " MM.CHECK_CODE = '$check_code' ";
}

if (!empty($is_main)){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= " MM.MAIN_MODULE = '$is_main' ";
}

if (!empty($is_in_menu)){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= " MM.IN_MENU = '$is_in_menu' ";
}

if (!empty($is_openable)){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= " MM.OPENABLE = '$is_openable' ";
}

if (!empty($status)){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= " MM.`STATUS` = '$status' ";
}

$query = $query.$where;

$sql = mysqli_query ($con_main, $query);

if (!$sql){
    $result = false;
    $message .= " Error Sql : (".mysqli_errno($con_main).") ".mysqli_error($con_main).". ";
}

$num_rows = mysqli_num_rows($sql);

if ($num_rows > 0){
    $i = 0;

    while ($rows = mysqli_fetch_assoc ($sql)){
        $data[$i] = $rows;

        $i++;
    }
}else{
    $result = false;
    $message .= " Empty results ";
}

$responce['data'] = $data;
$responce['result'] = $result;
$responce['message'] = $message;

echo (json_encode($responce));

mysqli_close($con_main);
?>