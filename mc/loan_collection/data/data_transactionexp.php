<?php
header('Content-Type: application/json');

include ('../../config.php');

$where = "";
$responce = array();
$data = "";
$result = true;
$message = "";

$id = (isset($_REQUEST['id']) && $_REQUEST['id'] != NULL && !empty($_REQUEST['id'])) ? $_REQUEST['id'] : 0;

$query = "SELECT
                loan_transactionexp.id,
                loan_transactionexp.category,
                loan_transactionexp.amount,
                loan_transactionexp.expencestype,
                loan_transactionexp.comment,
                loan_transactionexp.other
         FROM
                loan_transactionexp
         WHERE
                loan_transactionexp.id = '$id'";
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