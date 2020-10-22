<?php
header('Content-Type: application/json');

include ('../../config.php');

$where = "";
$responce = array();
$data = "";
$result = true;
$message = "";
$debug = "";

$id = (isset($_REQUEST['branch_id']) && $_REQUEST['branch_id'] != NULL && !empty($_REQUEST['branch_id'])) ? $_REQUEST['branch_id'] : 0;
$branch_id = (isset($_REQUEST['branch']) && $_REQUEST['branch'] != NULL && !empty($_REQUEST['branch'])) ? $_REQUEST['branch'] : 0;
$center_id = (isset($_REQUEST['center_id']) && $_REQUEST['center_id'] != NULL && !empty($_REQUEST['center_id'])) ? $_REQUEST['center_id'] : 0;
$loanid = (isset($_REQUEST['loanid']) && $_REQUEST['loanid'] != NULL && !empty($_REQUEST['loanid'])) ? $_REQUEST['loanid'] : 0;
$customer_id = (isset($_REQUEST['customer_id']) && $_REQUEST['customer_id'] != NULL && !empty($_REQUEST['customer_id'])) ? $_REQUEST['customer_id'] : 0;

if($id>0){

    $query = "SELECT
                BRA.branch_id,
                BRA.branch_name AS `NAME`,
                BRA.branch_code AS `CODE`,
                BRA.branch_comment AS `COMMENT`
              FROM
                branch AS BRA";

    if ($id > 0){
        $where .= (empty($where)) ? " WHERE " : " AND ";
        $where .= "BRA.branch_id = '$id'";
    }

    $query = $query.$where;

}

if($branch_id > 0){

    $query = "SELECT
                center.center_id,
                center.center_name
            FROM
                center
            WHERE
                center.branch_id = '$branch_id'";

}

if($center_id > 0){
   
   $query = "SELECT
                loan_lending.loanid,
                loan_lending.nic,
                loan_lending.net_payment,
                loan_customer.branch_name,
                loan_customer.center_name,
                loan_customer.member_number,
                loan_customer.name_full
            FROM
                loan_lending
            INNER JOIN loan_customer ON loan_lending.id = loan_customer.id
            WHERE
                loan_customer.center_name = '$loanid'";
}

if($loanid > 0){
   
   $query = "SELECT
                loan_customer.branch_name,
                loan_customer.center_name,
                loan_customer.member_number,
                loan_customer.name_full,
                loan_lending.net_payment,
                loan_lending.nic,
                loan_customer.nic,
                loan_lending.loanid
            FROM
                 loan_customer
INNER JOIN loan_lending ON loan_customer.center_name = '$loanid'";

}


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
$responce['debug'] = $query;

echo (json_encode($responce));

mysqli_close($con_main);
?>