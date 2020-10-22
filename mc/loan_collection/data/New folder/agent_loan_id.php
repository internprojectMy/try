<?php
header('Content-Type: application/json');

include ('../../config.php');

$where = "";
$responce = array();
$data = "";
$result = true;
$message = "";

$cusid = (isset($_REQUEST['cusid']) && $_REQUEST['cusid'] != NULL && !empty($_REQUEST['cusid'])) ? $_REQUEST['cusid'] :0;

$query = "SELECT
                loan_lending.id,
                loan_lending.loanid
            FROM
                loan_lending
            WHERE
                loan_lending.customer_id = '$cusid'";

$sql = mysqli_query ($con_main, $query);

if (!$sql){
    $result = false;
    $message .= " Error Sql : (".mysqli_errno($con_main).") ".mysqli_error($con_main).". ";
}

$num_rows = mysqli_num_rows($sql);

if ($num_rows > 0){
    $i = 0;

    while ($rows = mysqli_fetch_assoc($sql)){
        $data[$i] = $rows;
        $i++;
    }
}else{
    $result = false;
    $message .= " Empty results";
}

$responce['data'] = $data;
$responce['result'] = $result;
$responce['message'] = $message;

echo (json_encode($responce));

mysqli_close($con_main);
?>