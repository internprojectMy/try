<?php
require_once('tcpdf_include.php');
require ('../../../config.php');

ob_start();
$pdf = new TCPDF('l',PDF_UNIT,PDF_PAGE_FORMAT,true,'UTF-8',false);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->setFooterData(array(0,64,0), array(0,64,128));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

if (@file_exists(dirname(__FILE__).'/lang/eng.php')){
  require_once(dirname(__FILE__).'/lang/eng.php');
  $pdf->setLanguageArray($l);
}

$pdf->setFontSubsetting(true);
$pdf->SetFont('dejavusans', '', 12, '', true);
$pdf->AddPage();

$html = '';


//************PRINT QUOTATION HEADER DETAILS********************
$quot_no = $_REQUEST['quot_no'];

$file_name_query = "SELECT
                        quotation_header.quotation_no,
                        quotation_header.quotation_date,
                        quotation_header.billing_party_id,
                        mas_customer.VATRegNo AS CUSTOMER_VAT,
                        mas_customer.SVATRegNo AS CUSTOMER_SVAT,
                        mas_customer.CustomerName,
                        client_company_details.company_name,
                        client_company_details.vat_reg_no AS CLIENT_VAT,
                        client_company_details.svat_reg_no AS CLIENT_SVAT,
                        client_company_details.address AS CLIENT_ADDRESS,
                        quotation_sunry_customer.sunry_name,
                        quotation_sunry_customer.sunry_address,
                        quotation_sunry_customer.sunry_city,
                        quotation_sunry_customer.sunry_vat,
                        quotation_sunry_customer.sunry_svat,
                        quotation_header.is_sunry_customer,
                        mas_customer.City
                    FROM
                        quotation_header
                    LEFT JOIN mas_customer ON quotation_header.customer_id = mas_customer.ID
                    LEFT JOIN mas_employee ON quotation_header.sales_person_id = mas_employee.id
                    LEFT JOIN client_company_details ON quotation_header.client_company_id = client_company_details.id
                    LEFT JOIN quotation_sunry_customer ON quotation_header.is_sunry_customer = quotation_sunry_customer.id
                    WHERE
                        quotation_header.id = '$quot_no'";

$file_name_sql = mysqli_query($con_main,$file_name_query);
$file_name_res = mysqli_fetch_assoc($file_name_sql);
$file_name = $file_name_res['quotation_no'];
$quotation_date = $file_name_res['quotation_date'];
$customer_name = $file_name_res['CustomerName'];

  if($file_name_res['billing_party_id'] == 1){
       $bill_name = $file_name_res['company_name'];
       $bill_vat = $file_name_res['CLIENT_VAT'];
       $bill_svat = $file_name_res['CLIENT_SVAT'];
      
       if(!empty($bill_svat)){
         $bill_party_type = "SVAT CUSTOMER";
       }else if(!empty($bill_vat)){
         $bill_party_type = "VAT CUSTOMER";
       }else if(empty($bill_svat) && empty($bill_vat)){
         $bill_party_type = "NON-VAT CUSTOMER";
       }

  }else{
       $bill_name = $file_name_res['CustomerName'];
       $bill_city = $file_name_res['City'];
       $bill_vat = $file_name_res['CUSTOMER_VAT'];
       $bill_svat = $file_name_res['CUSTOMER_SVAT'];
    
       if(!empty($bill_svat)){
         $bill_party_type = "SVAT CUSTOMER";
       }else if(!empty($bill_vat)){
         $bill_party_type = "VAT CUSTOMER";
       }else if(empty($bill_svat) && empty($bill_vat)){
         $bill_party_type = "NON-VAT CUSTOMER";
       }
    }

 if($file_name_res['is_sunry_customer'] != "0"){
    $bill_name = $file_name_res['sunry_name'];
    $bill_city = $file_name_res['sunry_city'];
    $bill_vat = $file_name_res['sunry_vat'];
    $bill_svat = $file_name_res['sunry_svat'];
    if(!empty($bill_svat)){
       $bill_party_type = "SVAT CUSTOMER";
    }else if(!empty($bill_vat)){
       $bill_party_type = "VAT CUSTOMER";
    }else if(empty($bill_svat) && empty($bill_vat)){
       $bill_party_type = "NON-VAT CUSTOMER";
    }
  }   

 $grid_query = "SELECT
					mas_countries.currency_code,
					mas_uom.unit
				FROM
					mas_quotation
				LEFT JOIN mas_countries ON mas_quotation.quotation_currency = mas_countries.ID
				LEFT JOIN mas_measure_uom ON mas_quotation.uom = mas_measure_uom.id
				LEFT JOIN mas_uom ON mas_measure_uom.uom_id = mas_uom.id
				WHERE
					mas_quotation.quotation_header_id = '$quot_no'";

$grid_sql = mysqli_query($con_main,$grid_query);
$grid_headers = mysqli_fetch_assoc($grid_sql);

$currencycode = $grid_headers['currency_code'];
$uom = $grid_headers['unit'];

 $date = date("j-F-Y"); 
 $arr = explode('-',$quotation_date);
 switch ($arr[1]) {
                    case 1:
                        $Mname = 'January';
                        break;
                    case 2:
                        $Mname = 'February';
                        break;
                    case 3:
                        $Mname = 'March';
                        break;
                    case 4:
                        $Mname = 'April';
                        break;
                    case 5:
                        $Mname = 'May';
                        break;
                    case 6:
                        $Mname = 'June';
                        break;  
                    case 7:
                        $Mname = 'July';
                        break;
                    case 8:
                        $Mname = 'August';
                        break;
                    case 9:
                        $Mname = 'September';
                        break;
                    case 10:
                        $Mname = 'October';
                        break;
                    case 11:
                        $Mname = 'November';
                        break;
                    case 12:
                        $Mname = 'December';
                        break;                      
                    default:
                        echo "<<eror>>";
                }

$date = $arr[2]."-".$Mname."-".$arr[0];
 $output = "";
 $output .= '<h4 style="text-align:left;">Gurind Accor(Pvt) Limited.</h4>'; 
 $output .= '<h3 style="text-align:center;">OrderTrack Report</h3>';

$html .= '<br><br>';
$html .= '<table border="0" style="width:100%;font-size:16px;">';
$html .= '<tr>';
$html .= '<td style="text-align:left;height:15;"><strong>'.$customer_name.'</strong></td>';
$html .= '<td style="text-align:center;height:15;"><strong>'.$file_name.' / '.$date.'</strong></td>';
$html .= '<td style="text-align:right;height:15;">Currency and UOM :<strong>'.$currencycode.' / '.$uom.'</strong></td>';
$html .= '<td style="text-align:center;height:15;"></td>';
$html .= '</tr>';

$html .= '<tr>';
$html .= '<td style="text-align:left;height:15;"><strong>'.$bill_party_type.'</strong></td>';
$html .= '<td style="text-align:center;height:15;"><strong>VAT :'.$bill_vat.'</strong></td>';
$html .= '<td style="text-align:right;height:15;"><strong>SVAT :'.$bill_svat.'</strong></td>';
$html .= '<td style="text-align:right;height:15;"><strong>City :'.$bill_city.'</strong></td>';
$html .= '</tr>';

$html .= '</table>';
//************END PRINT QUOTATION HEADER DETAILS****************************

//************PRINT QUOTATION LINE ITEMS************************************

	$query = "SELECT
      				mas_quotation.glass_mark,
      				mas_quotation.length,
      				mas_quotation.width,
      				mas_quotation.sqm_per_unit,
      				mas_quotation.quantity_in_units,
      				mas_countries.currency_code,
      				mas_quotation.rate,
      				mas_quotation.discount,
      				mas_quotation.value,
      				mas_quotation.id,
      				finish_good_items.finish_good_code,
      				mas_finish_good.item_description,
      				mas_job_type.job_type,
      				mas_uom.unit,
      				mas_quotation.tax1,
              mas_quotation.tax_val1,
              mas_quotation.tax2,
              mas_quotation.tax_val2,
              mas_quotation.tax3,
              mas_quotation.tax_val3,
              mas_quotation.tax4,
              mas_quotation.tax_val4
    		  FROM
    				mas_quotation
    		 LEFT JOIN mas_countries ON mas_quotation.quotation_currency = mas_countries.ID
    	     LEFT JOIN finish_good_items ON mas_quotation.fg_type_id = finish_good_items.id
    		 LEFT JOIN mas_finish_good ON mas_quotation.fg_item_id = mas_finish_good.id
    		 LEFT JOIN mas_job_type ON mas_quotation.job_type_id = mas_job_type.id
    		 LEFT JOIN mas_measure_uom ON mas_quotation.uom = mas_measure_uom.id
    		 LEFT JOIN mas_uom ON mas_measure_uom.uom_id = mas_uom.id
    		 WHERE mas_quotation.quotation_header_id = '$quot_no'
    		 ORDER BY mas_finish_good.item_description ASC,mas_quotation.id ASC";

	$sql = mysqli_query($con_main,$query);

$total_nbt = 0;
$total_vat = 0;
$total_sqm_unit = 0;
$total_Sqm_pieces = 0;
$total_qty = 0;
$total_net_rate = 0;
$total_value = 0;

$html .= '<br><br><br>';   
$html .= '<table style="font-size:12px;" border="1">';
$html .= '<thead>';
$html .= '<tr>';	
$html .= '<th style="height:28;"><strong>Glass Mark</strong></th>';
$html .= '<th style="text-align:right;height:28;"><strong>Length</strong></th>';	
$html .= '<th style="text-align:right;height:28;"><strong>Width</strong></th>';
$html .= '<th style="text-align:right;height:28;width:80;"><strong>SQM</strong></th>';
$html .= '<th style="text-align:right;height:28;width:45;"><strong>QTY</strong></th>';
$html .= '<th style="text-align:right;height:28;width:80;"><strong>Tot.SQM</strong></th>';
$html .= '<th style="text-align:right;height:28;"><strong>Rate</strong></th>';
$html .= '<th style="text-align:right;height:28;"><strong>Disc.</strong></th>';
$html .= '<th style="text-align:right;height:28;" colspan="2"><strong>Net Rate</strong></th>';
$html .= '<th style="text-align:right;height:28;width:80;"><strong>NBT</strong></th>';
$html .= '<th style="text-align:right;height:28;width:90;"><strong>VAT</strong></th>';
$html .= '<th style="text-align:right;height:28;" colspan="2"><strong>Value</strong></th>';												
$html .= '</tr>';
$html .= '</thead>';

$html .= '<tbody>';

while($row = mysqli_fetch_assoc($sql)){

$sqm = ($row['length']*$row['width'])/1000000;
$sqm = round($sqm,4);

$tot_sqm = $sqm*$row['quantity_in_units'];
$tot_sqm = round($tot_sqm,4);

$net_rate =($row['rate'] - $row['discount']) * $tot_sqm;
$net_rate = round($net_rate,2);

$nbt_val = ($net_rate*$row['tax_val2'])/(100-$row['tax_val2']); //NBT
$nbt_val = round($nbt_val,2);//NBT

$vat_val = (($net_rate+$nbt_val)*$row['tax_val1'])/100;//VAT
$vat_val = round($vat_val,2);//VAT

$total_val = $net_rate + $nbt_val + $vat_val; 
$total_val = round($total_val,2); 

$total_nbt = $total_nbt + $nbt_val;
$total_vat = $total_vat + $vat_val;
$total_sqm_unit = $total_sqm_unit + $sqm;
$total_Sqm_pieces = $total_Sqm_pieces + $tot_sqm;  
$total_qty = $total_qty + $row['quantity_in_units'];
$total_net_rate = $total_net_rate + $net_rate;
$total_value = $total_value + $total_val;	 


$html .= '<tr>';
$html .= '<td style="text-align:right;height:28;">'.$row['glass_mark'].'</td>';	
$html .= '<td style="text-align:right;height:28;">'.number_format($row['length'],2).'</td>';
$html .= '<td style="text-align:right;height:28;">'.number_format($row['width'],2).'</td>';
$html .= '<td style="text-align:right;height:28;width:80;">'.number_format($sqm,4).'</td>';
$html .= '<td style="text-align:right;height:28;width:45;">'.$row['quantity_in_units'].'</td>';
$html .= '<td style="text-align:right;height:28;width:80;">'.number_format($tot_sqm,4).'</td>';
$html .= '<td style="text-align:right;height:28;">'.number_format($row['rate'],2).'</td>';
$html .= '<td style="text-align:right;height:28;">'.number_format($row['discount'],2).'</td>';
$html .= '<td style="text-align:right;height:28;" colspan="2">'.number_format($net_rate,2).'</td>';
$html .= '<td style="text-align:right;height:28;width:80;">'.number_format($nbt_val,2).'</td>';
$html .= '<td style="text-align:right;height:28;width:90;">'.number_format($vat_val,2).'</td>';
$html .= '<td style="text-align:right;height:28;" colspan="2">'.number_format($total_val,2).'</td>';
$html .= '</tr>';
}

//SHOWING TOTAL VALUES
$html .= '<tr>';
$html .= '<td style="text-align:left;height:28;" colspan="2"><strong>TOTAL</strong></td>';	
$html .= '<td style="text-align:right;height:28;"></td>';
$html .= '<td style="text-align:right;height:28;width:80;"><strong>'.number_format($total_sqm_unit,4).'</strong></td>';
$html .= '<td style="text-align:right;height:28;width:45;"><strong>'.$total_qty.'</strong></td>';
$html .= '<td style="text-align:right;height:28;width:80;"><strong>'.number_format($total_Sqm_pieces,4).'</strong></td>';
$html .= '<td style="text-align:right;height:28;"></td>';
$html .= '<td style="text-align:right;height:28;"></td>';
$html .= '<td style="text-align:right;height:28;" colspan="2"><strong>'.number_format($total_net_rate,2).'</strong></td>';
$html .= '<td style="text-align:right;height:28;width:80;"><strong>'.number_format($total_nbt,2).'</strong></td>';
$html .= '<td style="text-align:right;height:28;width:90;"><strong>'.number_format($total_vat,2).'</strong></td>';
$html .= '<td style="text-align:right;height:28;" colspan="2"><strong>'.number_format($total_value,2).'</strong></td>';
$html .= '</tr>';
//END SHOWING TOTAL VALUES

$html .= '</tbody>'; 
$html .= '</table>';
//************END PRINT QUOTATION LINE ITEMS********************************

//************PRINT QUOTATION ADDITIONAL SERVICES**************************
$additional_services_query = "SELECT
                  								mas_quotation.glass_mark,
                  								quotation_additional_services.service_charge,
                  								mas_common_services.description,
                  								mas_common_services.rate,
                  								mas_quotation.tax1,
                  								mas_quotation.tax_val1,
                  								mas_quotation.tax2,
                  								mas_quotation.tax_val2,
                  								mas_quotation.tax3,
                  								mas_quotation.tax_val3,
                  								mas_quotation.tax4,
                  								mas_quotation.tax_val4
              							FROM
              								quotation_additional_services
              							INNER JOIN mas_quotation ON quotation_additional_services.quotation_id = mas_quotation.id
              							INNER JOIN mas_common_services ON mas_common_services.id = quotation_additional_services.common_service_id
              							WHERE
              								quotation_additional_services.header_id = '$quot_no' AND
                              mas_common_services.taxable_or_not = '1'";

$additional_services_sql = mysqli_query($con_main,$additional_services_query);
$num_rows = mysqli_num_rows($additional_services_sql);

if($num_rows > 0){

$additional_nbt = 0;
$additional_vat = 0;
$total_additional_value = 0;
$total_serv_charge = 0;

$html .= '<h4 style="text-align:left;">Additional Services (Taxable).</h4>';
$html .= '<table style="font-size:12px;" border="0">';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th style="height:28;"><strong>Glass Mark</strong></th>';
$html .= '<th style="height:28;"><strong>Service</strong></th>';
$html .= '<th style="height:28;text-align:right;"><strong>Rate</strong></th>';
$html .= '<th style="height:28;text-align:right;"><strong>Charge</strong></th>';
$html .= '<th style="height:28;text-align:right;"><strong>NBT</strong></th>';
$html .= '<th style="height:28;text-align:right;"><strong>VAT</strong></th>';
$html .= '<th style="height:28;text-align:right;"><strong>Value</strong></th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';

    while($res2 = mysqli_fetch_assoc($additional_services_sql)){

    	$nbt = ($res2['service_charge']*$res2['tax_val2'])/(100-$res2['tax_val2']);//NBT
    	$nbt = round($nbt,2);//NBT
    	$additional_nbt = $additional_nbt + $nbt;//NBT

    	$vat = (($res2['service_charge'] + $nbt)*$res2['tax_val1'])/100;//VAT
    	$vat = round($vat,2);//VAT
    	$additional_vat = $additional_vat + $vat;//VAT 

    	$charge = $res2['service_charge'] + $nbt + $vat;
    	$charge = round($charge,2);

    	$total_additional_value = $total_additional_value + $charge;
        $total_serv_charge = $total_serv_charge + $res2['service_charge']; 
  
		$html .= '<tr>';
		$html .= '<td style="height:28;text-align:left;">'.$res2['glass_mark'].'</td>';
		$html .= '<td style="height:28;text-align:left;">'.$res2['description'].'</td>';
		$html .= '<td style="height:28;text-align:right;">'.$res2['rate'].'</td>';
		$html .= '<td style="height:28;text-align:right;">'.$res2['service_charge'].'</td>';
		$html .= '<td style="height:28;text-align:right;">'.number_format($nbt,2).'</td>';
		$html .= '<td style="height:28;text-align:right;">'.number_format($vat,2).'</td>';
		$html .= '<td style="height:28;text-align:right;">'.number_format($charge,2).'</td>';
		$html .= '</tr>';
	}
$html .= '<tr>';
$html .= '<td style="height:28;text-align:left;border-bottom: 1px solid #000;border-top: 1px solid #000;"colspan="2"><strong>TOTAL</strong></td>';
$html .= '<td style="height:28;text-align:right;border-bottom: 1px solid #000;border-top: 1px solid #000;"></td>';
$html .= '<td style="height:28;text-align:right;border-bottom: 1px solid #000;border-top: 1px solid #000;"><strong>'.number_format($total_serv_charge,2).'</strong></td>';
$html .= '<td style="height:28;text-align:right;border-bottom: 1px solid #000;border-top: 1px solid #000;"><strong>'.number_format($additional_nbt,2).'</strong></td>';
$html .= '<td style="height:28;text-align:right;border-bottom: 1px solid #000;border-top: 1px solid #000;"><strong>'.number_format($additional_vat,2).'</strong></td>';
$html .= '<td style="height:28;text-align:right;border-bottom: 1px solid #000;border-top: 1px solid #000;"><strong>'.number_format($total_additional_value,2).'</strong></td>';
$html .= '</tr>';

$html .= '</tbody>';
$html .= '</table>';
}

$additional_services_query2 = "SELECT
                  								mas_quotation.glass_mark,
                  								quotation_additional_services.service_charge,
                  								mas_common_services.description,
                  								mas_common_services.rate,
                  								mas_quotation.tax1,
                  								mas_quotation.tax_val1,
                  								mas_quotation.tax2,
                  								mas_quotation.tax_val2,
                  								mas_quotation.tax3,
                  								mas_quotation.tax_val3,
                  								mas_quotation.tax4,
                  								mas_quotation.tax_val4
                  							FROM
                  								quotation_additional_services
                  							INNER JOIN mas_quotation ON quotation_additional_services.quotation_id = mas_quotation.id
                  							INNER JOIN mas_common_services ON mas_common_services.id = quotation_additional_services.common_service_id
                  							WHERE
                  								quotation_additional_services.header_id = '$quot_no' AND
                                  mas_common_services.taxable_or_not = '0'";

$additional_services_sql2 = mysqli_query($con_main,$additional_services_query2);
$num_rows2 = mysqli_num_rows($additional_services_sql2);

if($num_rows2 > 0){
$non_taxable_total = 0;
$html .= '<h4 style="text-align:left;">Additional Services (Non-Taxable).</h4>';
$html .= '<table style="font-size:12px;" border="0">';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th style="height:28;"><strong>Glass Mark</strong></th>';
$html .= '<th style="height:28;"><strong>Service</strong></th>';
$html .= '<th style="height:28;text-align:right;"><strong>Rate</strong></th>';
$html .= '<th style="height:28;text-align:right;"><strong>Charge</strong></th>';
$html .= '</tr>';
$html .= '</thead>';

$html .= '<tbody>';
    while($res3 = mysqli_fetch_assoc($additional_services_sql2)){

	    $non_taxable_total = $non_taxable_total + $res3['service_charge'];

        $html .= '<tr>';
		$html .= '<td style="height:28;text-align:left;">'.$res3['glass_mark'].'</td>';
		$html .= '<td style="height:28;text-align:left;">'.$res3['description'].'</td>';
		$html .= '<td style="height:28;text-align:right;">'.$res3['rate'].'</td>';
		$html .= '<td style="height:28;text-align:right;">'.$res3['service_charge'].'</td>';
		$html .= '</tr>';
    }

$html .= '<tr>';
$html .= '<td style="height:28;text-align:left;border-bottom: 1px solid #000;border-top: 1px solid #000;"colspan="2"><strong>TOTAL</strong></td>';
$html .= '<td style="height:28;text-align:right;border-bottom: 1px solid #000;border-top: 1px solid #000;"></td>';
$html .= '<td style="height:28;text-align:right;border-bottom: 1px solid #000;border-top: 1px solid #000;"><strong>'.number_format($non_taxable_total,2).'</strong></td>';
$html .= '</tr>';

$html .= '</tbody>';
$html .= '</table>';
}
//***********END PRINT QUOTATION ADDITIONAL SERVICES***********************

//************PRINT QUOTATION FOOTER***********************************
// $html .= '<br><br>';
// $html .= '<table style="font-size:15px;" border="0">';
// $html .= '<tr>';
// // $html .= '<td><strong>TOtal NBT Value :</strong></td>';
// $html .= '<td style="height:28;text-align:right;"><strong>'.number_format(($total_nbt+$additional_nbt),2).'</strong></td>';
// $html .= '</tr>';

// $html .= '<tr>';
// // $html .= '<td><strong>TOtal VAT Value :</strong></td>';
// $html .= '<td style="height:28;text-align:right;"><strong>'.number_format(($total_vat+$additional_vat),2).'</strong></td>';
// $html .= '</tr>';

// $html .= '<tr>';
// // $html .= '<td><strong>TOtal Quotation Value :</strong></td>';
// $html .= '<td style="height:28;text-align:right;"><strong>'.number_format(($total_value+$total_additional_value),2).'</strong></td>';
// $html .= '</tr>';

// $html .= '</table>';
//************END PRINT QUOTATION FOOTER***********************************
 
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
ob_end_clean();
$pdf->Output($file_name.'.pdf', 'I');
?>