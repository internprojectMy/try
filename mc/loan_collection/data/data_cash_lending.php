<?php
header('Content-Type: application/json');

include ('../../config.php');

$where = "";
$responce = array();
$data = "";
$result = true;
$message = "";
$debug = "";

$id = (isset($_REQUEST['id']) && $_REQUEST['id'] != NULL && !empty($_REQUEST['id'])) ? $_REQUEST['id'] : 0;
$id = (isset($_REQUEST['lid']) && $_REQUEST['lid'] != NULL && !empty($_REQUEST['lid'])) ? $_REQUEST['lid'] : 0;
$nic = (isset($_REQUEST['nic']) && $_REQUEST['nic'] != NULL && !empty($_REQUEST['nic'])) ? $_REQUEST['nic'] : 0;



if($id>0){

                 $query = "SELECT
                        loan_lending.id,
                        loan_lending.loanid,
                        loan_lending.loan_date,
                        loan_lending.nic,
                        loan_lending.loan_amount,
                        loan_lending.interest_amount,
                        loan_lending.loan_type,
                        loan_lending.loantypes,
                        loan_lending.duration,
                        loan_lending.net_payment,
                        loan_lending.due_amount,
                        loan_lending.collector_day,
                        loan_lending.startdate,
                        loan_lending.enddate,
                        loan_lending.collector_name,
                        loan_lending.status
                        FROM
                        loan_lending";

    }


if($lid>0){

              $query =  "SELECT
                    loan_customer.name_full,
                    loan_customer.nic,
                    center.cash_name,
                    center.cash_day
                    FROM
                    loan_customer
                    INNER JOIN center ON loan_customer.center_name = center.center_id
                    WHERE
                    loan_customer.center_name = '$lid'";


}


// if($nic>0){

//               $query =  "SELECT
//                 loan_customer.name_full,
//                 loan_customer.nic,
//                 loan_customer.id,
//                 center.cash_name,
//                 center.cash_day
//                 FROM
//                 loan_customer
//                 INNER JOIN center ON loan_customer.center_name = center.center_id
//                 WHERE
//                 loan_customer.nic = '$nic'";



// }


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