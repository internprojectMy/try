<?php
// header('Content-Type: application/json');

include ('../../config.php');

$where = "";
$responce = array();
$data = "";
$result = true;
$message = "";
$debug = "";

if (isset($_POST['nic'])) {
    $nic = $_POST['nic'];
    $sql = "SELECT * FROM loan_customer WHERE nic='$nic'";
    $results = mysqli_query($con_main, $sql);
    if (mysqli_num_rows($results) > 0) {
      echo "taken"; 
    }else{
      echo 'not_taken';
    }
    exit();
  }

$responce['data'] = $data;
$responce['result'] = $result;
$responce['message'] = $message;
$responce['debug'] = $sql;

echo (json_encode($responce));

mysqli_close($con_main);
?>