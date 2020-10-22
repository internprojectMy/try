<?php
header('Content-Type: application/json');

require_once('config.php');

$responce = array();
$message = "";
$data = "";
$result = true;

$groundId = $_REQUEST['groundId'];
$teamId = $_REQUEST['teamId'];
$uniqe_id = $_REQUEST['uniqe_id'];

if ($uniqe_id == '0') {

    $insert = "INSERT INTO `match_summary` (
                `ground_id`,
                `team_id`
            )
            VALUES
                (
                    '$groundId',
                    '$teamId'
                )";


    $sql = mysqli_query($con_main, $insert);
    $inserted_id = mysqli_insert_id($con_main);
}



if ($sql) {
    $result = true;
    $message = "Success";
    $data = $inserted_id;
} else {
    $result = false;
    $message = "Error SQL: (" . mysqli_errno($con_main) . ") " . mysqli_error($con_main);
}


$responce['result'] = $result;
$responce['data'] = $data;
$responce['message'] = $message;

echo (json_encode($responce));


mysqli_close($con_main);
