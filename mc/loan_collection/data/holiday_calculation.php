<?php
header('Content-Type: application/json');

include ('../../config.php');

$where = "";
$responce = array();
$data = "";
$result = true;
$message = "";


$startdate = (isset($_REQUEST['startdate']) && $_REQUEST['startdate'] != NULL && !empty($_REQUEST['startdate'])) ? $_REQUEST['startdate'] :0;
$enddate = (isset($_REQUEST['enddate']) && $_REQUEST['enddate'] != NULL && !empty($_REQUEST['enddate'])) ? $_REQUEST['enddate'] :0;

$query = "SELECT
                Count(loan_holiday.date) AS COUNT
          FROM
                `loan_holiday`
          WHERE
                loan_holiday.`status` = '1'
          AND loan_holiday.date BETWEEN '$startdate'
          AND '$enddate'";

$sql = mysqli_query ($con_main, $query);

if (!$sql){
    $result = false;
    $message .= " Error Sql : (".mysqli_errno($con_main).") ".mysqli_error($con_main).". ";
}

$num_rows = mysqli_num_rows($sql);

if ($num_rows > 0){
    $i = 0;

    while ($rows = mysqli_fetch_assoc($sql)){
        $holidays = $rows['COUNT'];
        $i++;
    }

}else{
    $result = false;
    $message .= " Empty results";
}

$responce['data'] = $holidays;
$responce['result'] = $result;
$responce['message'] = $message;

echo (json_encode($responce));

mysqli_close($con_main);
?>