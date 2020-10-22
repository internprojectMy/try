<?php

header('Content-Type: application/json');

include ('../../config.php');

$where = "";
$responce = array();
$data = "";
$result = true;
$message = "";

$name_full = (isset($_REQUEST['name_full']) && $_REQUEST['name_full'] != NULL && !empty($_REQUEST['name_full'])) ? $_REQUEST['name_full'] :0;
$customer_id = (isset($_REQUEST['customer_id']) && $_REQUEST['customer_id'] != NULL && !empty($_REQUEST['customer_id'])) ? $_REQUEST['customer_id'] :0;

if(!empty($name_full)){
    
    $query = "SELECT
                    loan_customer.name_full,
                    loan_customer.status,
                    loan_customer.nic,
                    loan_lending.loanid,
                    loan_lending.nic,
                    loan_customer.member_number
                    FROM
                    loan_customer
                    INNER JOIN loan_lending ON loan_customer.nic = loan_lending.nic
                    WHERE
                    loan_customer.name_full = '$name_full'";

    
    $sql = mysqli_query ($con_main, $query);
    
    if (!$sql){
        $result = false;
        $message .= " Error Sql : (".mysqli_errno($con_main).") ".mysqli_error($con_main).". ";
    }
    
    $num_rows = mysqli_num_rows($sql);
    
    if ($num_rows > 0){
        $i = 0;
    
        while ($rows = mysqli_fetch_assoc($sql)){
            $data[$i] = $rows;
            $i++;
        }
    }else{
        $result = false;
        $message .= " Empty results";
    }
    
}

$responce['data'] = $data;
$responce['result'] = $result;
$responce['debug'] = $query;

echo (json_encode($responce));

mysqli_close($con_main);
?>