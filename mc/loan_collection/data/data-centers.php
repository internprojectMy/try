<?php
header('Content-Type: application/json');

include ('../../config.php');

$where = "";
$responce = array();
$data = "";
$result = true;
$message = "";
$debug = "";

$id = (isset($_REQUEST['branch_id']) && $_REQUEST['branch_id'] != NULL && !empty($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : 0;

$query="SELECT
CEN.branch_id AS BID,
CEN.center_id AS ID,
CEN.center_name AS `NAME`,
CEN.center_code AS `CODE`,
CEN.cash_name AS `CASHNAME`,
CEN.cash_day AS `CASHDAY`,
CEN.status AS `STATUS`
FROM
center AS CEN";

if ($id > 0){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= "CEN.branch_id = '$id'";
}

$query = $query.$where;

$sql = mysqli_query ($con_main, $query);

if (!$sql){
    $result = false;
    $debug .= " Error Sql : (".mysqli_errno($con_main).") ".mysqli_error($con_main).". ";
    $message .= " Data retrieved failed.";
}else{
    $message .= " Data retrieved succeed.";
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
    $debug .= " Empty results ";
}

$responce['data'] = $data;
$responce['result'] = $result;
$responce['message'] = $message;
$responce['debug'] = $debug;

echo (json_encode($responce));

mysqli_close($con_main);
?>