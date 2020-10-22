

<?php
$timestamp = date('YmdHis');
$filename = "Invoice Report ".$timestamp.".xls";

header("Content-Disposition: attachment; filename=\"".$filename."\"");
header("Content-Type: application/vnd.ms-excel");

require_once ('../config.php');
session_start();

$from = $_REQUEST['from'];
$to = $_REQUEST['to'];
$cus_type = $_REQUEST['cus_type'];
$fg_cat = $_REQUEST['fg_cat'];
$order_tp = $_REQUEST['order_tp'];
$job_tp = $_REQUEST['job_tp'];
$fg_item = $_REQUEST['fg_item'];
$quot_status = $_REQUEST['quot_status'];
$sales_person = $_REQUEST['sales_person'];
$inv_type = $_REQUEST['inv_type'];
$user = $_SESSION['USER_CODE'];

$query = "";
$where = "";

// if ($sales_person != "All"){
//     $where .= (empty($where)) ? " WHERE " : " AND ";
//     $where .= "quotation_header.sales_person_id = '$sales_person' ";
// }

// if($fg_cat != "All"){
//     $where .= (empty($where)) ? " WHERE " : " AND ";
//     $where .= "finish_good_items.id = '$fg_cat' ";
// }


// if($order_tp != "All"){
//     $where .= (empty($where)) ? " WHERE " : " AND ";
//     $where .= "project_type.id = '$order_tp' ";
// }

// if($cus_type != "All"){
//     $where .= (empty($where)) ? " WHERE " : " AND ";
//     $where .= "mas_customer.ID = '$cus_type' ";
// }

// if($job_tp != "All"){
//     $where .= (empty($where)) ? " WHERE " : " AND ";
//     $where .= "mas_job_type.id = '$job_tp' ";
// }

// if($fg_item != "All"){
//     $where .= (empty($where)) ? " WHERE " : " AND ";
//     $where .= "mas_finish_good.id = '$fg_item' ";
// }

// if($inv_type != "All"){
//     $where .= (empty($where)) ? " WHERE " : " AND ";
//     $where .= "mas_invoice_header.customer_status = '$inv_type' ";
// }

if(!empty($from) && !empty($to)){
   $where .= (empty($where)) ? " WHERE " : " AND ";
   $where .= " DATE(loan_lending.loan_date)>='$from' AND DATE(loan_lending.loan_date)<='$to' ";
}


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
				INNER JOIN loan_lending ON loan_customer.nic = loan_lending.nic ".$where." ";
	
	
	echo ("ID");
	echo ("\tLoan ID");
	echo ("\tNIC");
	echo ("\tLoan Date");
	echo ("\tStart Date");

	
	$sql = mysqli_query($con_main,$query);

	// while ($row = mysqli_fetch_assoc($sql)){

	// 	$customer_name = preg_replace('/\s+/', '', $row['CustomerName']);

	// 	$quot_no = $row['invoice_no'];
 //        $query2 = "SELECT
	// 					Sum(quotation_payments_detail.paid_amount) AS TOTAL_PAID
	// 				FROM
	// 					quotation_payments_detail
	// 				WHERE
	// 					quotation_payments_detail.reference_no = '$quot_no'";
	// 	$sql2 = mysqli_query($con_main,$query2);
	// 	$res2 = mysqli_fetch_assoc($sql2);

	// 	$head = $row['HEADER_ID'];
	// 	$qno = $row['quotation_no'];
	// 	$line_id = $row['id'];
		 
	// 	$query3 = "SELECT
	// 					SUM(disp_final.disp_qty) AS DISP_TOTAL
	// 				FROM
	// 					disp_final
	// 				INNER JOIN service_items ON disp_final.item_id = service_items.id
	// 				WHERE
	// 					service_items.item_id = '$line_id'";
	// 	$sql3 = mysqli_query($con_main,$query3);
	// 	$res3 = mysqli_fetch_assoc($sql3);

 //         $query5= "SELECT
	// 					quotation_additional_services.service_charge,
	// 					mas_common_services.description
	// 				FROM
	// 					mas_common_services
	// 				INNER JOIN quotation_additional_services ON mas_common_services.id = quotation_additional_services.common_service_id
	// 				WHERE
	// 					quotation_additional_services.header_id = '$head'
	// 				AND quotation_additional_services.quotation_id = '$line_id'
	// 				ORDER BY mas_common_services.id ASC";

 //         $sql5 = mysqli_query($con_main,$query5);
 //         $serv_description = array();
 //         $serv_charge = array();
 //         $i = 0;
 //         while($res5 = mysqli_fetch_assoc($sql5)){
 //           $serv_description[$i] = $res5['description'];
 //           $serv_charge[$i] = $res5['service_charge'];
 //           $i++;
 //         }
        
 //        $sand = array_search("Sand Blasting",$serv_description);
 //        $sand_val = $serv_charge[$sand]; 

 //        $water = array_search("Water Jet Cutting",$serv_description);
 //        $water_val = $serv_charge[$water]; 

 //        $argon = array_search("Argon Gas Filling",$serv_description);
 //        $argon_val = $serv_charge[$argon]; 

 //        $wooden = array_search("Wooden Box And Packaging",$serv_description);
 //        $wooden_val = $serv_charge[$wooden]; 

 //        $trans = array_search("Transport (Local)",$serv_description);
 //        $trans_val = $serv_charge[$trans]; 

 //        $dgu = array_search("DGU - RFT Charges",$serv_description);
 //        $dgu_val = $serv_charge[$dgu]; 

 //        $sqm = ($row['length']*$row['width'])/1000000;
 //        $glass_value = $sqm*($row['rate']-$row['discount'])*$row['quantity_in_units'];

        
 //        // $nbt = (($glass_value+$sand_val+$water_val+$argon_val+$wooden_val+$trans_val+$dgu_val)*$row['tax_val2'])/(100-$row['tax_val2']);
 //        // $nbt = round($nbt,2);
 //         $nbt =$adv+$sand+$arogn+$water+$row['VALUE']*($row['tax_val2']/(100-$row['tax_val2']));
 //         $nbt = round($nbt,2);


 //         $vat = $adv+$sand+$arogn+$water+$nbt+($nbt+$row['VALUE'])*($row['tax_val1']/100);
 //         $vat = round($vat,2);	


        // $vat = ($nbt+$glass_value+$sand_val+$water_val+$argon_val+$wooden_val+$trans_val+$dgu_val)*($row['tax_val1']/100);
        // $vat = round($vat,2);

          // $gt= $adv+$sand+$arogn+$trans+$wooden+$nbt+$vat;
          // $gt =round($gt,4);

		echo ("\r\n");
		echo ($customer_name);
		echo ("\t".$row['id']);
		echo ("\t".$row['loanid']);
		echo ("\t".$row['nic']);
		echo ("\t".$row['loan_date']);	
	
		
		
?>

