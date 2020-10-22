<?php
date_default_timezone_set('Asia/Colombo'); 
$timestamp = date('YmdHis');
$filename = "loan_summary ".$timestamp.".xls";

header("Content-Disposition: attachment; filename=\"".$filename."\"");
header("Content-Type: application/vnd.ms-excel");

require_once ('../config.php');
session_start();
$user = $_SESSION['USER_CODE'];
$collector = $_REQUEST['coll_name'];



// echo ("\t\t\t\t\t\t\tUnsettled invoices report as of ".$today);
// echo("\r\n");
// echo ("Printed By and date : ".$printed_by.' '.$print_date_and_time);

// echo("\r\n\r\n");

// echo ("Invoice Number");
echo ("Loan ID");
echo ("\tCustomer Name");
echo ("\tNIC");
echo ("\tCenter");
echo ("\tPremium");
echo ("\tLoan Balance");
echo ("\tStart Date");
echo ("\tEnd Date");


$query = "SELECT
				loan_lending.collector_name,
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
				loan_lending.`status`,
				loan_customer.name_full,
				center.center_id,
				center.center_name
				FROM
				loan_lending
				INNER JOIN loan_customer ON loan_lending.nic = loan_customer.nic
				INNER JOIN center ON center.center_id = loan_customer.center_name
				WHERE
							loan_lending.collector_name= '$collector'
				";

 $sql = mysqli_query($con_main,$query);



	
 echo("\r\n");

while($res = mysqli_fetch_assoc($sql)){
     
     // $customer = preg_replace('/\s+/', ' ', $res['CUSTOMER_NAME']);
     // echo ("\r\n");
     // echo ($res['INVOICE_NO']);
     echo ("".$res['loanid']);
	 echo ("\t".$res['name_full']);
     echo ("\t".$res['nic']);
	 echo ("\t".$res['center_name']);	
	 echo ("\t".$res['due_amount']);
     echo ("\t".$res['net_payment']);
	 echo ("\t".$res['startdate']);	
	 echo ("\t".$res['enddate']);
	 echo("\r\n");	

	}

 
?>

