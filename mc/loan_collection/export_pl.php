<?php
date_default_timezone_set('Asia/Colombo'); 
$timestamp = date('YmdHis');
$filename = "loan_summary ".$timestamp.".xls";

header("Content-Disposition: attachment; filename=\"".$filename."\"");
header("Content-Type: application/vnd.ms-excel");

require_once ('../config.php');
session_start();
$user = $_SESSION['USER_CODE'];
$from = $_REQUEST['from'];
$to = $_REQUEST['to'];


// echo ("\t\t\t\t\t\t\tUnsettled invoices report as of ".$today);
// echo("\r\n");
// echo ("Printed By and date : ".$printed_by.' '.$print_date_and_time);

// echo("\r\n\r\n");

// echo ("Invoice Number");
echo ("Loan ID");
echo ("\tNIC");
echo ("\tLoan Date");
echo ("\tStart Date");
echo ("\tEnd Date");
echo ("\tLoan Amount");
echo ("\tDuration");
echo ("\tInterest Amount");
echo ("\tNet Payment");
echo ("\tName Full");
echo ("\tloan Type");

$query = "SELECT
				loan_customer.id,
				loan_lending.loanid,
				loan_customer.nic,
				loan_lending.loan_date,
				loan_lending.startdate,
				loan_lending.enddate,
				loan_lending.loan_amount,
				loan_lending.duration,
				loan_lending.interest_amount,
				loan_lending.net_payment,
				loan_customer.name_full,
				loan_lending.loan_type,
				center.center_id,
				center.center_name
				FROM
				loan_customer
				INNER JOIN loan_lending ON loan_customer.nic = loan_lending.nic
				INNER JOIN center ON center.center_id = loan_customer.center_name
					WHERE
				loan_lending.loan_date BETWEEN '$from'
				AND '$to'";

 $sql = mysqli_query($con_main,$query);

	
 echo("\r\n");

while($res = mysqli_fetch_assoc($sql)){
     
     // $customer = preg_replace('/\s+/', ' ', $res['CUSTOMER_NAME']);
     // echo ("\r\n");
     // echo ($res['INVOICE_NO']);
     echo ("".$res['loanid']);
	 echo ("\t".$res['nic']);
     echo ("\t".$res['loan_date']);
	 echo ("\t".$res['startdate']);	
	 echo ("\t".$res['enddate']);
     echo ("\t".$res['loan_amount']);
	 echo ("\t".$res['duration']);	
	 echo ("\t".$res['interest_amount']);
     echo ("\t".$res['net_payment']);
	 echo ("\t".$res['name_full']);
	 echo ("\t".$res['$bal_available']);
	 // echo ("\t".$res['name_full']);	

}
 
?>

