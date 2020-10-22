<?php
header('Content-Type: application/json');

include ('../../config.php');

$where = "";
$responce = array();
$data = "";
$result = true;
$message = "";

$branch_id = (isset($_REQUEST['$branch_id']) && $_REQUEST['$branch_id'] != NULL && !empty($_REQUEST['$branch_id'])) ? $_REQUEST['$branch_id'] : 0;

$query = "SELECT
                branch.branch_name,
                branch.branch_code,
                branch.branch_comment,
                branch.branch_date,
                branch.`status`
                FROM
                branch
                WHERE
                branch.branch_id = 'branch.branch_id'";
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