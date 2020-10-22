<?php
header('Content-Type: application/json');

include ('../../config.php');

$where = "";
$responce = array();
$data = "";
$result = true;
$message = "";
$debug = "";

$id = (isset($_REQUEST['loanid']) && $_REQUEST['loanid'] != NULL && !empty($_REQUEST['loanid'])) ? $_REQUEST['loanid'] : 0;

$query = "SELECT
    loan_lending.id,
    loan_lending.loanid,
    loan_lending.loan_amount,
    CONCAT_WS( ' ', loan_customer.name_initial, loan_customer.nic ) AS name
    FROM
    loan_lending
    INNER JOIN loan_customer ON loan_lending.nic = loan_customer.nic 
    WHERE
    loan_lending.loanid = '$id'";

// if ($id > 0){
//     $where .= (empty($where)) ? " WHERE " : " AND ";
//     $where .= "id = '$id'";
// }

// $query = $query.$where;

$sql = mysqli_query ($con_main, $query);
$res = mysqli_fetch_assoc($sql);

if (!$sql){
    $result = false;
    $debug .= " Error Sql : (".mysqli_errno($con_main).") ".mysqli_error($con_main).". ";
    $message .= " Data retrieved failed.";
}else{
    $message .= " Data retrieved succeed.";
    $amount = $res['loan_amount']; 
    $name = $res['name']; 
}

$responce['amount'] = $amount;
$responce['name'] = $name;
$responce['result'] = $result;
$responce['message'] = $message;

echo (json_encode($responce));

mysqli_close($con_main);
?>