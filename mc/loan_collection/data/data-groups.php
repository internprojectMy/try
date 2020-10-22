<?php
header('Content-Type: application/json');

include ('../../config.php');

$where = "";
$responce = array();
$data = "";
$result = true;
$message = "";
$debug = "";

$center_id = (isset($_REQUEST['center_id']) && $_REQUEST['center_id'] != NULL && !empty($_REQUEST['center_id'])) ? $_REQUEST['center_id'] : 0;

$query="SELECT
center.center_id,
`group`.group_name,
`group`.group_id,
`group`.center_id
FROM
`group`
INNER JOIN center ON center.center_id = `group`.center_id
WHERE
center.center_id = '$center_id'
";

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