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
                loan_lending.loanid,
                loan_lending.start_date,
                loan_lending.loan_type
            FROM
                loan_lending
            WHERE
                loan_lending.customer_id = '$cusid'";

$sql = mysqli_query ($con_main, $query);
while($sql_res = mysqli_fetch_assoc($sql)){

   $type = $sql_res['loan_type'];

    if($type == 2){
$start = $sql_res['start_date'];
$today_obj = time();
$start_date_obj = strtotime($start);
$day_count_obj = $today_obj - $start_date_obj;
$day_count = round($day_count_obj / (60 * 60 * 24)); 
  
   if($day_count%7 == 0){

      $data[0]['loan_id'] = $sql_res['loanid'];
      $data[0]['id'] = $sql_res['id'];
      $responce['data'] = $data;
      echo (json_encode($responce));
   }
}

else if($type == 3){
$start = $sql_res['start_date'];
$today_obj = time();
$start_date_obj = strtotime($start);
$day_count_obj = $today_obj - $start_date_obj;
$day_count = round($day_count_obj / (60 * 60 * 24)); 
  
   if($day_count%14 == 0){

      $data[0]['loan_id'] = $sql_res['loanid'];
      $data[0]['id'] = $sql_res['id'];
      $responce['data'] = $data;
      echo (json_encode($responce));
   }

}

else if($type == 4){
$start = $sql_res['start_date'];
$today_obj = time();
$start_date_obj = strtotime($start);
$day_count_obj = $today_obj - $start_date_obj;
$day_count = round($day_count_obj / (60 * 60 * 24)); 
  
   if($day_count%30 == 0){

      $data[0]['loan_id'] = $sql_res['loanid'];
      $data[0]['id'] = $sql_res['id'];
      $responce['data'] = $data;
      echo (json_encode($responce));
   }

}
}
mysqli_close($con_main);
?>