<?php
header('Content-Type: application/json');

require_once('config.php');

$responce = array();
$message = "";
$data = "";
$result = true;

$authorname = $_REQUEST['authorname'];
$displayname = $_REQUEST['displayname'];
$nic = $_REQUEST['nic'];
$status = $_REQUEST['status'];
$dob = $_REQUEST['dob'];
$empstatus = $_REQUEST['empstatus'];
$uniqe_id = $_REQUEST['uniqe_id'];

if ($uniqe_id == '0') {

    $insert = "INSERT INTO `author_details` (
                `ground_id`,
                `team_id`,
                `match_note`,
                `match_score`,
                `match_overs`,
                `Inning`
            )
            VALUES
                (
                    '$authorname',
                    '$displayname',
                    '$nic',
                    '$status',
                    '$dob',
                    '$empstatus'
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
