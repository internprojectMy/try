<?php
header('Content-Type: application/json');

include ('../../config.php');

$where = "";
$responce = array();
$data = "";
$result = true;
$message = "";

$id = (isset($_REQUEST['id']) && $_REQUEST['id'] != NULL && !empty($_REQUEST['id'])) ? $_REQUEST['id'] : 0;
$loc = (isset($_REQUEST['location']) && $_REQUEST['location'] != NULL && !empty($_REQUEST['location'])) ? $_REQUEST['location'] : 0;
$status = (isset($_REQUEST['status']) && $_REQUEST['status'] != NULL && !empty($_REQUEST['status'])) ? $_REQUEST['status'] : "";

$query = "SELECT
T.DEP_CODE,
T.DEPARTMENT,
T.LOC_CODE,
T.DATE_CREATED,
T.USER_CREATED,
T.`STATUS`
FROM
mas_department AS T";

if ($id > 0){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= " T.DEP_CODE = '$id' ";
}

if ($loc > 0){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= " T.LOC_CODE = '$loc' ";
}

if (!empty($status)){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= " T.`STATUS` = '$status' ";
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