<?php
header('Content-Type: application/json');

include ('../../config.php');

$where = "";
$responce = array();
$data = "";
$result = true;
$message = "";

$id = (isset($_REQUEST['id']) && $_REQUEST['id'] != NULL && !empty($_REQUEST['id'])) ? $_REQUEST['id'] : 0;

$query = "SELECT
loan_customer.id,
loan_customer.branch_name,
loan_customer.center_name,
loan_customer.group_name,
loan_customer.registered_date,
loan_customer.member_number,
loan_customer.name_full,
loan_customer.name_initial,
loan_customer.dob,
loan_customer.nic,
loan_customer.spouse_name,
loan_customer.spouse_contact,
loan_customer.spouse_dob,
loan_customer.spouse_nic,
loan_customer.spouse_income,
loan_customer.customer_home_address,
loan_customer.customer_mobile1,
loan_customer.customer_fixed1,
loan_customer.customer_business_address,
loan_customer.customer_mobile2,
loan_customer.customer_fixed2,
loan_customer.status
FROM
loan_customer
";

if ($id > 0){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= "id = '$id'";
}

$query = $query.$where;

$sql = mysqli_query ($con_main, $query);

if (!$sql){
    $result = false;
    $message .= " Error Sql : (".mysqli_errno($con_main).") ".mysqli_error($con_main).". ";
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
    $message .= "Empty results ";
}

$responce['data'] = $data;
$responce['result'] = $result;
$responce['message'] = $message;

echo (json_encode($responce));

mysqli_close($con_main);
?>