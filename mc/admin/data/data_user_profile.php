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
T.USER_CODE,
T.EMP_NO,
T.FIRST_NAME,
T.LAST_NAME,
T.GENDER,
T.DOB,
T.NIC,
T.LOCATION,
T.COST_CENTER,
T.DEPARTMENT,
T.DESIGNATION,
T.MOBILE_NO,
T.PHOTO,
T.EMAIL,
T.`STATUS`,
T.DATE_JOINED,
T.DATE_LEFT,
IFNULL(A.ACCESS_CODE,0) AS ACCESS_CODE,
IFNULL(A.USERNAME,'') AS USERNAME,
IFNULL(A.`PASSWORD`,'') AS `PASSWORD`
FROM
mas_user AS T
LEFT JOIN mas_access AS A ON T.USER_CODE = A.USER_CODE";

if ($id > 0){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= " T.USER_CODE = '$id' ";
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