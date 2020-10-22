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

   if($id>0){
                $query="SELECT
                        loan_lending.id,
                        loan_lending.loanid,
                        loan_lending.loan_date,
                        loan_lending.nic,
                        loan_lending.loan_amount,
                        loan_lending.interest_amount,
                        loan_lending.loan_type,
                        loan_lending.loantypes,
                        loan_lending.duration,
                        loan_lending.net_payment,
                        loan_lending.due_amount,
                        loan_lending.collector_day,
                        loan_lending.startdate,
                        loan_lending.enddate,
                        loan_lending.collector_name,
                        loan_lending.status
                        FROM
                        loan_lending";
}

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