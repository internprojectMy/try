<?php
header('Content-Type: application/json');

include ('../../config.php');

$where = "";
$responce = array();
$data = "";
$result = true;
$message = "";

$loanid = (isset($_REQUEST['loanid']) && $_REQUEST['loanid'] != NULL && !empty($_REQUEST['loanid'])) ? $_REQUEST['loanid'] : 0;

$loan_detail_query = "SELECT
LL.id AS LOAN_ID,
LL.loan_amount AS LOAN_AMOUNT,
LL.interest_amount AS INTEREST_AMOUNT,
LL.net_payment AS NET_AMOUNT,
LL.total_due AS DURATION,
LL.due_amount AS DAILY_PAYABLE,
LL.start_date AS START_DATE,
LL.loan_type AS LOAN_TYPE,
loan_type.type,
mas_user.EMP_NO,
mas_user.FIRST_NAME
FROM
loan_lending AS LL
INNER JOIN loan_type ON LL.loan_type = loan_type.id
INNER JOIN mas_user ON LL.collector_id = mas_user.USER_CODE
WHERE
LL.id = $loanid
LIMIT 1";

$loan_detail_sql = mysqli_query ($con_main, $loan_detail_query);
$loan_detail_res = mysqli_fetch_assoc ($loan_detail_sql);

$daily_payable = (double)$loan_detail_res['DAILY_PAYABLE'];
$start_date = $loan_detail_res['START_DATE'];
$loan_type = $loan_detail_res['LOAN_TYPE'];
$loan_amt = $loan_detail_res['NET_AMOUNT'];
$loan_tp = $loan_detail_res['type'];
$collector_name = $loan_detail_res['FIRST_NAME'];
$collector_code = $loan_detail_res['EMP_NO'];

if($loan_type == '1'){
$today_obj = time();
$start_date_obj = strtotime($start_date);
$day_count_obj = $today_obj - $start_date_obj;
$day_count = round($day_count_obj / (60 * 60 * 24));
$day_count = $day_count + 1;

$total_due_amount = $day_count * $daily_payable;

$total_paid_query = "SELECT
SUM(FUCK.bill_amount) AS TOTAL_PAID
FROM
loan_collecting AS FUCK
WHERE
FUCK.loan_id = $loanid";

$total_paid_sql = mysqli_query ($con_main, $total_paid_query);
$total_paid_res = mysqli_fetch_assoc ($total_paid_sql);

$total_paid_amount = (double)$total_paid_res['TOTAL_PAID'];
$balance_amt = $loan_amt - $total_paid_amount;

$outstanding_amount = $total_due_amount - $total_paid_amount;


$data[0]['daily_payable'] = $daily_payable;
$data[0]['start_date'] = $start_date;
$data[0]['day_count'] = $day_count;
$data[0]['total_due_amount'] = $total_due_amount;
$data[0]['total_paid_amount'] = $total_paid_amount;
$data[0]['outstanding'] = $outstanding_amount;
$data[0]['loan_amt'] = $loan_amt;
$data[0]['loan_tp'] = $loan_tp;
$data[0]['balance_amt'] = $balance_amt;
$data[0]['collector_name'] = $collector_name;
$data[0]['collector_code'] = $collector_code;

$data[0]['total_payment'] = $total_payment;

$responce['data'] = $data;
$responce['result'] = $result;
$responce['message'] = $message;

echo (json_encode($responce));

mysqli_close($con_main);




}else if ($loan_type=='2'){

$today_obj = time();
$start_date_obj = strtotime($start_date);
$day_count_obj = $today_obj - $start_date_obj;
$day_count = round($day_count_obj / (60 * 60 * 24));
$day_count = ($day_count/7);
$day_count = floor($day_count)+1;

$total_due_amount = $day_count * $daily_payable;

$total_paid_query = "SELECT
SUM(FUCK.bill_amount) AS TOTAL_PAID
FROM
loan_collecting AS FUCK
WHERE
FUCK.loan_id = $loanid";

$total_paid_sql = mysqli_query ($con_main, $total_paid_query);
$total_paid_res = mysqli_fetch_assoc ($total_paid_sql);

$total_paid_amount = (double)$total_paid_res['TOTAL_PAID'];
$balance_amt = $loan_amt - $total_paid_amount;

$outstanding_amount = $total_due_amount - $total_paid_amount;

$data[0]['daily_payable'] = $daily_payable;
$data[0]['start_date'] = $start_date;
$data[0]['day_count'] = $day_count;
$data[0]['total_due_amount'] = $total_due_amount;
$data[0]['total_paid_amount'] = $total_paid_amount;
$data[0]['outstanding'] = $outstanding_amount;
$data[0]['loan_tp'] = $loan_tp;
$data[0]['loan_amt'] = $loan_amt;
$data[0]['balance_amt'] = $balance_amt;

$data[0]['total_payment'] = $total_payment;
$data[0]['collector_name'] = $collector_name;
$data[0]['collector_code'] = $collector_code;

$responce['data'] = $data;
$responce['result'] = $result;
$responce['message'] = $message;

echo (json_encode($responce));

mysqli_close($con_main);

}



else if ($loan_type=='3'){

$today_obj = time();
$start_date_obj = strtotime($start_date);
$day_count_obj = $today_obj - $start_date_obj;
$day_count = round($day_count_obj / (60 * 60 * 24));
$day_count = ($day_count/14);
$day_count = floor($day_count)+1;

$total_due_amount = $day_count * $daily_payable;

$total_paid_query = "SELECT
SUM(FUCK.bill_amount) AS TOTAL_PAID
FROM
loan_collecting AS FUCK
WHERE
FUCK.loan_id = $loanid";

$total_paid_sql = mysqli_query ($con_main, $total_paid_query);
$total_paid_res = mysqli_fetch_assoc ($total_paid_sql);

$total_paid_amount = (double)$total_paid_res['TOTAL_PAID'];
$balance_amt = $loan_amt - $total_paid_amount;

$outstanding_amount = $total_due_amount - $total_paid_amount;

$data[0]['daily_payable'] = $daily_payable;
$data[0]['start_date'] = $start_date;
$data[0]['day_count'] = $day_count;
$data[0]['total_due_amount'] = $total_due_amount;
$data[0]['total_paid_amount'] = $total_paid_amount;
$data[0]['outstanding'] = $outstanding_amount;
$data[0]['loan_tp'] = $loan_tp;
$data[0]['loan_amt'] = $loan_amt;
$data[0]['balance_amt'] = $balance_amt;

$data[0]['total_payment'] = $total_payment;
$data[0]['collector_name'] = $collector_name;
$data[0]['collector_code'] = $collector_code;

$responce['data'] = $data;
$responce['result'] = $result;
$responce['message'] = $message;

echo (json_encode($responce));

mysqli_close($con_main);

}


else if ($loan_type=='4'){

$today_obj = time();
$start_date_obj = strtotime($start_date);
$day_count_obj = $today_obj - $start_date_obj;
$day_count = round($day_count_obj / (60 * 60 * 24));
$day_count = ($day_count/30);
$day_count = floor($day_count)+1;

$total_due_amount = $day_count * $daily_payable;

$total_paid_query = "SELECT
SUM(FUCK.bill_amount) AS TOTAL_PAID
FROM
loan_collecting AS FUCK
WHERE
FUCK.loan_id = $loanid";

$total_paid_sql = mysqli_query ($con_main, $total_paid_query);
$total_paid_res = mysqli_fetch_assoc ($total_paid_sql);

$total_paid_amount = (double)$total_paid_res['TOTAL_PAID'];
$balance_amt = $loan_amt - $total_paid_amount;

$outstanding_amount = $total_due_amount - $total_paid_amount;

$data[0]['daily_payable'] = $daily_payable;
$data[0]['start_date'] = $start_date;
$data[0]['day_count'] = $day_count;
$data[0]['total_due_amount'] = $total_due_amount;
$data[0]['total_paid_amount'] = $total_paid_amount;
$data[0]['outstanding'] = $outstanding_amount;
$data[0]['loan_tp'] = $loan_tp;
$data[0]['loan_amt'] = $loan_amt;
$data[0]['balance_amt'] = $balance_amt;

$data[0]['total_payment'] = $total_payment;
$data[0]['collector_name'] = $collector_name;
$data[0]['collector_code'] = $collector_code;

 $responce['data'] = $data;
// $responce['result'] = $result;
// $responce['message'] = $message;

echo (json_encode($responce));

mysqli_close($con_main);

}
?>