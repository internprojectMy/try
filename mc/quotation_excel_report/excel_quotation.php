
<?php
$timestamp = date('YmdHis');
$filename = "Quotation Report ".$timestamp.".xls";

header("Content-Disposition: attachment; filename=\"".$filename."\"");
header("Content-Type: application/vnd.ms-excel");

require_once('../config.php');
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
$status = $_REQUEST['quot_status'];
$user = $_SESSION['USER_CODE'];

$query = "";
$where = "";

if ($sales_person != "All"){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= "quotation_header.sales_person_id = '$sales_person' ";
}

if($fg_cat != "All"){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= "finish_good_items.id = '$fg_cat' ";
}


if($order_tp != "All"){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= "project_type.id = '$order_tp' ";
}

if($cus_type != "All"){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= "mas_customer.ID = '$cus_type' ";
}

if($job_tp != "All"){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= "mas_job_type.id = '$job_tp' ";
}

if($fg_item != "All"){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= "mas_finish_good.id = '$fg_item' ";
}

if($status != "All"){
    $where .= (empty($where)) ? " WHERE " : " AND ";
    $where .= "quotation_header.status = '$status' ";
}

if(!empty($from) && !empty($to)){
   $where .= (empty($where)) ? " WHERE " : " AND ";
   $where .= " DATE(quotation_header.entered_date)>='$from' AND DATE(quotation_header.entered_date)<='$to' ";
}


$query = "SELECT
	mas_quotation.quotation_header_id,
	mas_quotation.glass_mark,
	mas_quotation.length,
	mas_quotation.width,
	mas_quotation.sqm_per_unit,
	mas_quotation.quantity_in_units,
	mas_countries.currency_code,
	mas_quotation.rate,
	mas_quotation.discount,
	mas_quotation.
VALUE
	,
	mas_quotation.id,
	finish_good_items.finish_good_code,
	mas_finish_good.item_description,
	mas_job_type.job_type,
	mas_uom.unit,
	mas_customer.CustomerName,
	quotation_header.quotation_no,
	quotation_header.quotation_date,
	quotation_header. STATUS,
	mas_quotation.tax_val1,
	mas_quotation.tax_val2,
	quotation_header.quotation_value,
	quotation_header.id AS HEADER_ID,
	CONCAT_WS(
		'',
		mas_employee.first_name,
		mas_employee.last_name
	) AS FULL_NAME,
	quotation_footer.discount_rate,
	quotation_footer.discount_rate,
	quotation_header.approved_by,
	quotation_header.approved_date,
	quotation_header.confirmed_by,
	quotation_header.confirmed_date,
	quotation_header.confirm_receipts
FROM
mas_quotation
INNER JOIN quotation_header ON mas_quotation.quotation_header_id = quotation_header.id
INNER JOIN mas_customer ON quotation_header.customer_id = mas_customer.ID
INNER JOIN mas_countries ON mas_quotation.quotation_currency = mas_countries.ID
INNER JOIN finish_good_items ON mas_quotation.fg_type_id = finish_good_items.id
INNER JOIN mas_finish_good ON mas_quotation.fg_item_id = mas_finish_good.id
INNER JOIN mas_job_type ON mas_quotation.job_type_id = mas_job_type.id
INNER JOIN mas_measure_uom ON mas_quotation.uom = mas_measure_uom.id
INNER JOIN mas_employee ON quotation_header.sales_person_id = mas_employee.id
INNER JOIN mas_uom ON mas_measure_uom.uom_id = mas_uom.id
INNER JOIN quotation_footer ON quotation_header.id = quotation_footer.header_id
INNER JOIN mas_user ON mas_user.USER_CODE = quotation_header.approved_by AND mas_user.USER_CODE = quotation_header.confirmed_by   ".$where." ";


    // echo($query);
	echo ("Customer");
	echo ("\tSales Person");
	echo ("\tQuotation No");
	echo ("\tQuotation Date");
	echo ("\tQuotation Status");
	echo ("\tFG Category");
	echo ("\tFG Item");
	echo ("\tJob Type");
	echo ("\tLength");
	echo ("\tWidth");
	echo ("\tSQM/Pc");
	echo ("\tQuantity");
	echo ("\tCur.Code");
	echo ("\tRate");
	//echo ("\tDisc.Value");
	echo ("\tGlass Value");
	echo ("\tDis.rate");
	echo ("\tDis.Amount");
	echo ("\tAfter Dis.Value");
	echo ("\tSand Blast");
	echo ("\tRFT");
    echo ("\tWater Jet Cutting");
    echo ("\tArgon Gas Filling");
    echo ("\tNBT");
    echo ("\tVAT");
	echo ("\tGrand Total");
	echo ("\tWooden Box And Packaging");
    echo ("\tTransport (Local)");
    echo ("\tPatch Fittings");
    echo ("\tApproved By");
    echo ("\tApproved Date");
    echo ("\tConfirmation Name");
    echo ("\tConfirmation Date");
    echo ("\tReceipt No");


	$sql = mysqli_query ($con_main,$query);//Execute the query

	while ($row = mysqli_fetch_array($sql)){

		$customer_name = preg_replace('/\s+/', '', $row['CustomerName']);
		$mq=$row['id'];

		// $query3="SELECT
		// 			Sum(quotation_additional_services.service_charge) AS ADDITIONAL_TOTAL
		// 			FROM
		// 			quotation_additional_services
		// 			WHERE
		// 			quotation_additional_services.quotation_id = '$mq'";
		// 	$sql = mysqli_query($con_main,$query3);
		// 	$reslt = mysqli_fetch_assoc($sql);
		
		
		$quot_no = $row['quotation_no'];
        $query2 = "SELECT
						Sum(quotation_payments_detail.paid_amount) AS TOTAL_PAID
					FROM
						quotation_payments_detail
					WHERE
						quotation_payments_detail.reference_no = '$quot_no'";
						
		$sql2 = mysqli_query($con_main,$query2);
		$res2 = mysqli_fetch_assoc($sql2);

		$head = $row['HEADER_ID'];
		$qno = $row['quotation_no'];
		$line_id = $row['id'];

		$query3 = "SELECT
						final_disp_header.disp,
						Sum(dispatch_recored.amount) AS TOTAL
					FROM
						quotation_header
					INNER JOIN work_order_header ON work_order_header.quotation_id = quotation_header.id
					INNER JOIN service_items ON work_order_header.id = service_items.header_id
					INNER JOIN dispatch_recored ON service_items.id = dispatch_recored.service_id
					INNER JOIN disp_header ON work_order_header.id = disp_header.work_header
					INNER JOIN final_disp_header ON disp_header.id = final_disp_header.disp_auth
					WHERE quotation_header.id = '$head'";

		$sql3 = mysqli_query($con_main,$query3);
		$res3 = mysqli_fetch_assoc($sql3);
																					

		$query4= "SELECT
					Sum(quotation_payments_detail.paid_amount) AS TOTAL
				FROM
					quotation_payments_detail
				WHERE
					quotation_payments_detail.reference_no = '$qno'
				GROUP BY
					quotation_payments_detail.reference_no";

         $sql4 = mysqli_query($con_main,$query4);
         $res4 = mysqli_fetch_assoc($sql4);
         

         $query5= "SELECT
						quotation_additional_services.service_charge,
						mas_common_services.description
					FROM
						mas_common_services
					INNER JOIN quotation_additional_services ON mas_common_services.id = quotation_additional_services.common_service_id
					WHERE
						quotation_additional_services.header_id = '$head'
					AND quotation_additional_services.quotation_id = '$line_id'
					GROUP BY mas_common_services.id
					ORDER BY mas_common_services.id ASC";

         $sql5 = mysqli_query($con_main,$query5);
         $serv_description = array();
         $serv_charge = array();
         $i = 0;
         while($res5 = mysqli_fetch_assoc($sql5)){
           $serv_description[$i] = $res5['description'];
           $serv_charge[$i] = $res5['service_charge'];
           $i++;
         }
        
        $sand = array_search("Sand Blasting",$serv_description);
        $sand_val = ($sand !== FALSE) ? $serv_charge[$sand] : 0;

        $water = array_search("Water Jet Cutting",$serv_description);
        $water_val = ($water !== FALSE) ? $serv_charge[$water] : 0;

        $argon = array_search("Argon Gas Filling",$serv_description);
        $argon_val = ($argon !== FALSE) ? $serv_charge[$argon] : 0;

        $wooden = array_search("Wooden Box And Packaging",$serv_description);
        $wooden_val = ($wooden !== FALSE)? $service_charge[$wooden]:0;

        $trans = array_search("Transport (Local)",$serv_description);
        $trans_val = ($trans !== FALSE)? $service_charge[$trans]:0;

        $dgu = array_search("DGU - RFT Charges",$serv_description);
        $dgu_val = ($dgu!==FALSE)? $service_charge[$dgu]:0;

        $patch = array_search("Patch Fittings",$serv_description);
        $patch_val = $serv_charge[$dgu]; 
     
        // $nbt = $row['VALUE']*($row['tax_val2']/(100-$row['tax_val2']));
        // $nbt = round($nbt,2);
        
         $nbt =$adv+$dgu_val+$sand+$arogn+$water+$row['VALUE']*($row['tax_val2']/(100-$row['tax_val2']));
         $nbt = round($nbt,2);
        

      	 $vat = $adv+$dgu_val+$sand+$arogn+$water+$nbt+($nbt+$row['VALUE'])*($row['tax_val1']/100);
         $vat = round($vat,2);	

        // $vat = ($nbt+$row['VALUE'])*($row['tax_val1']/100);
        //$vat = round($vat,2);

        $da =$row['VALUE']*($row['discount_rate'])/100;
        $da =round($da,2);

        $adv = $row['VALUE']-$da;
        $adv = round($adv,2);

        $sqm = $row['sqm_per_unit'];
        $sqm = round($sqm,4);

        $gt= $adv+$dgu_val+$sand_val+$argon_val+$water_val+$nbt+$vat;
        $gt =round($gt,4);
		

		echo("\r\n");
		echo($customer_name);
		echo("\t".$row['FULL_NAME']);
		echo("\t".$row['quotation_no']);
		echo("\t".$row['quotation_date']);	
		echo("\t".$row['status']);
		echo("\t".$row['finish_good_code']);
		echo("\t".$row['item_description']);
		echo("\t".$row['job_type']);
		echo("\t".$row['length']);
		echo("\t".$row['width']);
		echo("\t".number_format($sqm,4));
		echo("\t".$row['quantity_in_units']);
		echo("\t".$row['currency_code']);
		echo("\t".$row['rate']);
		echo("\t".$row['VALUE']);
		echo("\t".$row['discount_rate']);
		echo("\t".number_format($da,2));
		echo("\t".number_format($adv,2));
		echo("\t".$sand_val);
		echo("\t".$dgu_val);
		echo("\t".$water_val);
		echo("\t".$argon_val);
        echo("\t".number_format($nbt,2));
		echo("\t".number_format($vat,2));
		echo("\t".number_format($gt,4));
		echo("\t".$wooden_val);
		echo("\t".$trans_val);
		echo("\t".$patch_val);
		echo("\t".$row['approved_by']);
		echo("\t".$row['approved_date']);
		echo("\t".$row['confirmed_by']);
		echo("\t".$row['confirmed_date']);
		echo("\t".$row['confirm_receipts']);
		
}
	
?>
