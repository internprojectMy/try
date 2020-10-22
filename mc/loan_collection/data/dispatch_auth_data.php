<?php
	header('Content-Type: application/json');
	session_start();
    require_once ('../config.php');

    $responce = array();

    $id = $_REQUEST['id']; 
    $branch_name = $_REQUEST['branch_name'];
    $center_name = $_REQUEST['center_name'];
    $loanid = $_REQUEST['loanid'];
    $name_full = $_SESSION['name_full'];
    $nic = $_REQUEST['nic'];
    $net_payment = $_REQUEST['net_payment'];
    $today = $_REQUEST['today'];
    $status = $_REQUEST['status'];

    if($center_name==1){
        
        $check = "SELECT COUNT(id) as loan_customer  FROM loan_lending WHERE center_name = '$center_name'";
        $checkSql = mysqli_query($con_main,$check);
        $chckRw = mysqli_fetch_assoc($checkSql);
        $a = $chckRw['count'];
        if($a>0){
            $is_new = false;

            $query = "SELECT
                    loan_customer.id,
                    loan_customer.name_full,
                    loan_lending.loanid,
                    loan_lending.net_payment
                    FROM
                    loan_customer ,
                    loan_lending
                    WHERE
                    loan_customer.center_name = '$center_name'";

            $sql = mysqli_query ($con_main, $query);
            $i = 0;
                while($row = mysqli_fetch_assoc($sql)){
                    $data[$i] = $row;
                    $i++;                    
                }            
            $responce['new'] = $is_new;
            $responce[2] = $data;

        }else{

            $is_new = true;

            $query = "SELECT
                    loan_customer.id,
                    loan_customer.name_full,
                    loan_lending.loanid,
                    loan_lending.nic,
                    loan_lending.net_payment
                    FROM
                    loan_customer ,
                    loan_lending
                    WHERE
                    loan_customer.center_name = '$center_name';";

            $sql = mysqli_query ($con_main, $query);
            $i = 0;
            while($row = mysqli_fetch_assoc($sql)){
                $data[$i] = $row;
                $i++;                    
            }
            $responce['new'] = $is_new;
            $responce[2] = $data;
        }
    }
    echo (json_encode($responce));
?>    