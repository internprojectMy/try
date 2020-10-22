<?php
    header('Content-Type: application/json');
    
    session_start();
    
    require_once ('../config.php');
    
    $user = $_SESSION['USER_CODE'];
    $op = $_REQUEST['operation'];
    $id = $_REQUEST['id'];

    $branch_name = $_REQUEST['branch_name']; 
    $center_name = $_REQUEST['center_name'];  
    $loanno = $_REQUEST['loanid'];
    $type = $_REQUEST['type'];
    $name_full = $_REQUEST['name_full'];
    $nic = $_REQUEST['nic'];
    $member_number = $_REQUEST['member_number'];
    $net_payment = $_REQUEST['net_payment'];
    $paid = $_REQUEST['paid'];
    $total = $_REQUEST['total'];
     $today = $_REQUEST['today'];

    $loan_amt = $_REQUEST['loan_amt'];
    $pd_amt = $_REQUEST['pd_amt'];
    $bal_amt = $_REQUEST['bal_amt'];
    
    
    // $today = date("Y-m-d");
    $id = 0;

    $query = "";
    $result = false;
    $message = "";
    $responce = array();
    
  
  if ($op == "insert"){
    $query = "INSERT INTO cash_collecting (
                            `branch_name`,
                            `center_name`,
                            `loanid`,
                            `name_full`,
                            `nic`,
                            `net_payment`,
                            `paid`,
                            `today`,
                            `type`,
                            `status`
                        )
                    VALUES
                        (
                            '$branch_name',
                            '$center_name',
                            '$loanno',
                            '$name_full',
                            '$nic',
                            '$net_payment',
                            '$paid',
                            '$today',
                            'cash_collected',
                            '1'
                        );";

    }else if ($op == "update"){
        $query = "UPDATE cash_collecting
SET 
        `branch_name` = '$branch_name',
        `center_name` = '$center_name',
        `loanid` =  '$loanno',
        `name_full` = '$name_full',
        `nic` =  '$nic',
        `net_payment` = '$net_payment',
        `paid` =  '$paid',
        `today` = '$today',
        `type` =  '$cash_collected',
        `status` =  '1'
WHERE
    (`id` = '$id');";
    }
                    

    $sql = mysqli_query ($con_main, $query);
    if($sql){
        $result = true;
    }else{
        $result = false;
    }
   
    $responce['result'] = $result;
    $responce['query'] = $query;
   
    echo (json_encode($responce));

    mysqli_close($con_main);
?>