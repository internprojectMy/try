<?php
header('Content-Type: application/json');

include ('../config.php');

$where = "";
$responce = array();
$data = "";
$result = true;
$message = "";

$loan_id =(isset($_REQUEST['loan_id']) && $_REQUEST['loan_id'] != NULL && !empty($_REQUEST['loan_id'])) ? $_REQUEST['loan_id'] :0;

$query = "SELECT
            loan_lending.loanid AS LOAN_ID
          FROM
            `loan_lending`
          ORDER BY
            loan_lending.loanid DESC
          LIMIT 1";

$sql = mysqli_query ($con_main, $query);

if (!$sql){
    $result = false;
    $message .= " Error Sql : (".mysqli_errno($con_main).") ".mysqli_error($con_main).". ";
}

$num_rows = mysqli_num_rows($sql);

if ($num_rows > 0){
    $i = 0;

    while ($rows = mysqli_fetch_assoc ($sql)){
        $loan_id = $rows['LOAN_ID'];
        $loan_id++;
       // $data['agentcode'] = $acode;
    }
}else{
   $loan_id = "LN001";
}

$responce['data'] =$acode;
$data[0]['loan_id'] = $loan_id;
$responce['result'] = $result;
$responce['message'] = $message;

echo (json_encode($responce));

mysqli_close($con_main);
?>