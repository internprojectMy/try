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




		    $tot_amt = 0;
		    $tot_interest = 0;
		    $tot_amt1 = 0;
		    $tot_interest1 = 0;
			$sql = mysqli_query ($con_main, $query);
		
			while ($row = mysqli_fetch_array ($sql)){

				$tot_amt = $tot_amt + $row['net_payment'];
				$tot_interest = $tot_interest + $row['net_payment'];

				$tot_amt1 = $tot_amt1 + $row['loan_amount'];
				$tot_interest1 = $tot_interest1 + $row['loan_amount'];
				
				$loan_id = $row['loanid'];

			$collect_amount_query = "SELECT
											Sum(cash_collecting.paid) AS TOTAL_PAID
										FROM
											cash_collecting
										WHERE
											cash_collecting.loanid = '$loan_id'
										AND cash_collecting.today BETWEEN '$from'
										AND '$to'";

				$collect_amount_sql = mysqli_query($con_main,$collect_amount_query);
                $collect_amount_res = mysqli_fetch_assoc($collect_amount_sql);
                $total_paid_amount = $collect_amount_res['TOTAL_PAID'];
                $bal_available = $row['net_payment']-$total_paid_amount; 
	

	
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
	 echo ("\t".$res['loan_type']);
	 echo("\r\n");	

	}

}
 
?>

