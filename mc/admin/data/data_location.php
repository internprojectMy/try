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
T.LOC_CODE,
T.LOCATION,
T.ADDRESS_LINE1,
T.ADDRESS_LINE2,
T.ADDRESS_LINE3,
T.CITY,
T.TEL1,
T.TEL2,
T.FAX1,
T.FAX2,
T.EMAIL,
T.LATITUDE,
T.LONGITUDE,
T.SYSTEM_ID,
T.DATE_CREATED,
T.USER_CREATED,
T.`STATUS`
FROM
mas_location AS T";

if ($id > 0){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= " T.LOC_CODE = '$id' ";
}

$query = $query.$where;

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