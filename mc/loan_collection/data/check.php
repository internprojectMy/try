<?php

header('Content-Type: application/json');

include ('../../config.php');

$where = "";
$responce = array();
$data = "";
$result = true;
$message = "";
$nic = $_REQUEST['nic'];


 if(isset($_POST['nic'])){
    
    $query = "SELECT * FROM loan_customer WHERE nic = '$nic'";

    
    $sql = mysqli_query ($con_main, $query);

    if(mysqli_num_rows($sql)> 0){

        echo '<span class="text-danger">Username not availability</span>';
    }else{
           echo '<span class="text-success">Username availability</span>';
    }
     
}

$responce['data'] = $data;
$responce['result'] = $result;
$responce['debug'] = $query;

echo (json_encode($responce));

mysqli_close($con_main);
?>