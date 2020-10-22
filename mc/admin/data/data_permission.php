<?php
header('Content-Type: application/json');

include ('../../config.php');

$where = "";
$responce = array();
$data = "";
$result = true;
$debug = "";
$message = "";

$id = (isset($_REQUEST['id']) && $_REQUEST['id'] != NULL && !empty($_REQUEST['id'])) ? $_REQUEST['id'] : 0;

if ($id > 0){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= " MP.ACCESS_CODE = '$id' ";
}

$query = "SELECT
MP.ACCESS_CODE,
MP.MOD_CODE
FROM
mas_permission AS MP";

$query = $query.$where;

$sql = mysqli_query ($con_main, $query);

if (!$sql){
    $result = false;
    $debug .= "\nError Sql : (".mysqli_errno($con_main).") ".mysqli_error($con_main)." ";
    $message .= "<br>Error fetching permission data ";
}

$num_rows = mysqli_num_rows($sql);

if ($num_rows > 0){
    $i = 0;

    while ($rows = mysqli_fetch_assoc ($sql)){
        $data[$i] = $rows;

        $i++;
    }
}

$responce['data'] = $data;
$responce['result'] = $result;
$responce['message'] = $message;
$responce['debug'] = $debug;

echo (json_encode($responce));

mysqli_close($con_main);
?>