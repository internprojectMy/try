<?php
date_default_timezone_set('Asia/Colombo'); 
$timestamp = date('YmdHis');
$filename = "unsettled invoices ".$timestamp.".xls";

header("Content-Disposition: attachment; filename=\"".$filename."\"");
header("Content-Type: application/vnd.ms-excel");

require_once ('../config.php');
session_start();
$user = $_SESSION['USER_CODE'];

$today = date("F j, Y");
$user_query = "SELECT CONCAT_WS(' ',mas_user.FIRST_NAME,mas_user.LAST_NAME) AS PRINTED_BY_NAME FROM mas_user WHERE mas_user.USER_CODE = '$user'";
$user_sql = mysqli_query($con_main,$user_query);
$user_res = mysqli_fetch_assoc($user_sql);
$printed_by = $user_res['PRINTED_BY_NAME'];
$print_date_and_time = date('l jS \of F Y h:i:s A'); 

echo ("\t\t\t\t\t\t\tUnsettled invoices report as of ".$today);
echo("\r\n");
echo ("Printed By and date : ".$printed_by.' '.$print_date_and_time);

echo("\r\n\r\n");

echo ("Invoice Number");
echo ("\tInvoice Date");
echo ("\tCustomer Name");
echo ("\t Invoice QTY");
echo ("\tcurrency code");
echo ("\tInvoice Value(with tax)");
echo ("\tpaid amount");
echo ("\tdispatch number");
echo ("\tdispatch date");
echo ("\tquotation number");
echo ("\tsalesman name");

$query = "SELECT
			view_invoice_dispatches.INVOICE_NO,
			view_invoice_dispatches.INVOICE_DATE,
			view_invoice_dispatches.CUSTOMER_NAME,
			view_invoice_dispatches.TOTAL_INVOICED,
			view_invoice_dispatches.CURRENCY,
			view_invoice_dispatches.TOTAL_VALUE,
			view_invoice_dispatches.TOTAL_PAID,
			view_invoice_dispatches.DISPATCH_NUMBER,
			view_invoice_dispatches.DISPATCH_DATE,
			view_invoice_dispatches.QUOTATION_NO,
			view_invoice_dispatches.SALES_REF_NAME
		FROM
			view_invoice_dispatches
		WHERE view_invoice_dispatches.BALANCED_TO_PAY > 0";

 $sql = mysqli_query($con_main,$query);
 echo("\r\n");

while($res = mysqli_fetch_assoc($sql)){
     
     $customer = preg_replace('/\s+/', ' ', $res['CUSTOMER_NAME']);
     echo ("\r\n");
     echo ($res['INVOICE_NO']);
     echo ("\t".$res['INVOICE_DATE']);
	 echo ("\t".$customer);
     echo ("\t".$res['TOTAL_INVOICED']);
	 echo ("\t".$res['CURRENCY']);	
	 echo ("\t".$res['TOTAL_VALUE']);
     echo ("\t".$res['TOTAL_PAID']);
	 echo ("\t".$res['DISPATCH_NUMBER']);	
	 echo ("\t".$res['DISPATCH_DATE']);
     echo ("\t".$res['QUOTATION_NO']);
	 echo ("\t".$res['SALES_REF_NAME']);	

}
 
?>

