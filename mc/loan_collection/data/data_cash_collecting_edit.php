<?php
header('Content-Type: application/json');

include ('../../config.php');

$where = "";
$responce = array();
$data = "";
$result = true;
$message = "";
$debug = "";

$id = (isset($_REQUEST['id']) && $_REQUEST['id'] != NULL && !empty($_REQUEST['id'])) ? $_REQUEST['id'] : 0;

$query=       "SELECT
                    cash_collecting.id,
                    cash_collecting.branch_name,
                    cash_collecting.center_name,
                    cash_collecting.branch_name,
                    cash_collecting.center_name,
                    cash_collecting.loanid,
                    cash_collecting.name_full,
                    cash_collecting.nic,
                    cash_collecting.net_payment,
                    cash_collecting.paid,
                    cash_collecting.total,
                    cash_collecting.today,
                    cash_collecting.status
                    FROM
                    cash_collecting";


if ($id > 0){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= "id = '$id'";
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