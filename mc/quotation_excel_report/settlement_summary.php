<?php
require_once('tcpdf/tcpdf.php');
require ('../config.php');

$radio = $_REQUEST['r_button'];
$ref_no = $_REQUEST['ref_no'];

ob_start();
 $pdf = new TCPDF('l',PDF_UNIT,PDF_PAGE_FORMAT,true,'UTF-8',false);

 $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

 $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

 // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

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
$html='';

function headerSection($ref_no,$radio){
 
 require ('../config.php');
 $output = "";
 $output .= '<h4 style="text-align:left;">Gurind Accor(Pvt) Limited.'.$ref_no.'</h4>'; 
 $output .= '<h3 style="text-align:center;">OrderTrack Report</h3>';
 $output .= '<br><br>';
 $output .= '<table>';
 $output .= '<tr>';
 $output .= '<table style="font-size:12px;" border="1">';
 $output .= '</tr>';
 $output .= '</table>';
 $output .= '<br><br><br>';

 return $output;
}

function detailSection($ref_no,$radio){
  require ('../config.php');
      
      if($radio == "work_order"){
        $wod_query = "SELECT
                        work_order_header.quotation_id
                      FROM
                        work_order_header
                      WHERE
                        work_order_header.id = '$ref_no'";
        $wod_sql = mysqli_query($con_main,$wod_query);
        $wod_res = mysqli_fetch_assoc($wod_sql);
        $ref_no = $wod_res['quotation_id']; 
      }

      // if($radio == "quotation"){

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
                  mas_quotation.tax_val4,
                  quotation_payments_header.receipt_no,
                  quotation_payments_header.receipt_date
                  FROM
                  mas_quotation
                  LEFT JOIN mas_countries ON mas_quotation.quotation_currency = mas_countries.ID
                  LEFT JOIN finish_good_items ON mas_quotation.fg_type_id = finish_good_items.id
                  LEFT JOIN mas_finish_good ON mas_quotation.fg_item_id = mas_finish_good.id
                  LEFT JOIN mas_job_type ON mas_quotation.job_type_id = mas_job_type.id
                  LEFT JOIN mas_measure_uom ON mas_quotation.uom = mas_measure_uom.id
                  LEFT JOIN mas_uom ON mas_measure_uom.uom_id = mas_uom.id
                  LEFT JOIN quotation_header ON mas_quotation.quotation_header_id = quotation_header.id
                  LEFT JOIN quotation_payments_detail ON quotation_header.quotation_no = quotation_payments_detail.reference_no
                  LEFT JOIN quotation_payments_header ON quotation_payments_detail.header_id = quotation_payments_header.id
                  WHERE mas_quotation.quotation_header_id = '$ref_no'";

      $sql = mysqli_query ($con_main, $query);
      // }
    // $output2 .= $query;
     
     $output2 .= "";
     $output2 .= '<table style="font-family: arial, sans-serif;width: 100%;font-size:9px" border="1">';
                  
     $output2 .= '<tr>';
     $output2 .= '<th height="25" style="text-align:center;"><strong>Item Descr</strong></th>';
     $output2 .= '<th height="25" style="text-align:center;"><strong>Glass mark</strong></th>';
     $output2 .= '<th height="25" style="text-align:center;"><strong>Quo.Qty</strong></th>';
     $output2 .= '<th height="25" style="text-align:center;"><strong>Q.SQM </strong></th>';
     $output2 .= '<th height="25" style="text-align:center;"><strong>Rate</strong></th>';
     $output2 .= '<th height="25" style="text-align:center;"><strong>W/O Pcs</strong></th>';
     $output2 .= '<th height="25" style="text-align:center;"><strong>W/O SQM</strong></th>';
     $output2 .= '<th height="25" style="text-align:center;"><strong>Temp SQM</strong></th>';
     $output2 .= '<th height="25" style="text-align:center;"><strong>Ratio</strong></th>';
     $output2 .= '<th height="25" style="text-align:center;"><strong>IG Pcs</strong></th>';
     $output2 .= '<th height="25" style="text-align:center;"><strong>SQM</strong></th>';
     $output2 .= '<th height="25" style="text-align:center;"><strong>Ratio</strong></th>';
     $output2 .= '<th height="25" style="text-align:center;"><strong>Disp Pcs</strong></th>';
     $output2 .= '<th height="25" style="text-align:center;"><strong>Disp SQM</strong></th>'; 
     $output2 .= '<th height="25" style="text-align:center;"><strong>Ratio</strong></th>';
     $output2 .= '<th height="25" style="text-align:center;"><strong>Inv Pcs</strong></th>';
     $output2 .= '<th height="25" style="text-align:center;"><strong>Inv SQM</strong></th>';
     $output2 .= '<th height="25" style="text-align:center;"><strong>Ratio</strong></th>';
     $output2 .= '<th height="25" style="text-align:center;"><strong>Cur Code</strong></th>'; 
     $output2 .= '<th style="text-align:right;height:28;"><strong>Inv Value</strong></th>'; 
     $output2 .= '<th style="text-align:right;height:28;"><strong>Recpt No</strong></th>';  
     $output2 .= '<th style="text-align:right;height:28;"><strong>Recpt Date</strong></th>'; 
     $output2 .= '</tr>'; 

    while ($row = mysqli_fetch_array($sql)){
       
       $quot_id = $row['id'];
       $sqm = ($row['length']*$row['width'])/1000000;
       $sqm = round($sqm,4);

       $wo_query = "SELECT
                      service_items.length,
                      service_items.width,
                      service_items.quantity,
                      service_items.temp,
                      service_items.ig
                    FROM
                      service_items
                    WHERE
                      service_items.item_id = '$quot_id'";  
        $wo_sql = mysqli_query($con_main,$wo_query);
        $wo_res = mysqli_fetch_assoc($wo_sql);  
        
        //WORK ORDER DETAILS
        $wo_length = $wo_res['length'];
        $wo_width = $wo_res['width'];   
        $wo_sqm = ($wo_length*$wo_width)/1000000;
        $wo_sqm = round($wo_sqm,4);
        
        $tempered_pcs = ($wo_res['temp'] == 1) ? $wo_res['quantity'] : 0;
        $tempered_sqm = ($wo_res['temp'] == 1) ? $wo_sqm : 0;
        $tempered_ratio = ($tempered_pcs['quantity_in_units'] == 1)*100;

        $ig_pcs = ($wo_res['ig'] == 1) ? $wo_res['quantity'] : 0;
        $ig_sqm = ($wo_res['ig'] == 1) ? $wo_sqm : 0;
        $ig_ratio = ($wo_res['ig'] == 1) ? " " : 0;   
        //END WORK ORDER DETAILS
         
        //DISPATCH DETAILS 
        $disp_query = "SELECT
                            disp_final.disp_qty,
                            service_items.length,
                            service_items.width
                        FROM
                            dispatch
                        INNER JOIN service_items ON service_items.id = dispatch.Item_id
                        INNER JOIN disp_final ON dispatch.id = disp_final.item_id
                        WHERE
                            service_items.item_id = '$quot_id'";
        $disp_sql = mysqli_query($con_main,$disp_query);
        $disp_res = mysqli_fetch_assoc($disp_sql);
        
        $dispatch_pcs = $disp_res['disp_qty'];
        $dispatch_sqm = ($disp_res['length']*$disp_res['width'])/1000000; 
        $dispatch_sqm = round($dispatch_sqm,4);
        $disp_ratio = ($dispatch_pcs/$row['quantity_in_units'])*100; 
        //DISPATCH DETAILS
        
        //INVOICE DETAILS
        $invoice_query = "SELECT
                            mas_invoice_detail.invoice_qty,
                            mas_quotation.length,
                            mas_quotation.width
                        FROM
                            mas_invoice_detail
                        INNER JOIN mas_quotation ON mas_invoice_detail.line_item_id = mas_quotation.id
                        WHERE
                            mas_invoice_detail.`status` = '1'
                        AND mas_invoice_detail.line_item_id = '$quot_id'";
        $invoice_sql = mysqli_query($con_main,$invoice_query);
        $invoice_res = mysqli_fetch_assoc($invoice_sql);

        $invoice_pcs = $invoice_res['invoice_qty'];
        $invoice_sqm = ($invoice_res['length']*$disp_res['width'])/1000000; 
        $invoice_sqm = round($invoice_sqm,4);
        $invoice_ratio = ($invoice_pcs/$row['quantity_in_units'])*100; 

        $line_rate = round($row['rate'],2);
        $line_discount = round($row['discount'],2);
        $line_rate = $line_rate - $line_discount;
        $line_value = $sqm*$line_rate*$invoice_pcs;
        $line_value = round($line_value,2);

        $nbt = ($line_value*$row['tax_val2'])/(100-$row['tax_val2']);
        $nbt = round($nbt,2);
        $line_value_with_nbt = $line_value + $nbt;

        $vat = ($line_value_with_nbt*$row['tax_val1'])/100;
        $line_value_with_vat = $line_value_with_nbt + $vat;   
        $line_value_with_vat = round($line_value_with_vat,2); 
        //END INVOICE DETAILS

        $output2 .= '<tr>';
        $output2 .= '<td style="text-align:center;">'.($row['item_description']).'</td>';
        $output2 .= '<td style="text-align:center;">'.($row['glass_mark']).'</td>';
        $output2 .= '<td style="text-align:center;">'.($row['quantity_in_units']).'</td>';
        $output2 .= '<td style="text-align:center;">'.number_format($sqm,4).'</td>';
        $output2 .= '<td style="text-align:center;">'.number_format($row['rate'],2).'</td>';
        $output2 .= '<td style="text-align:center;">'.$row['quantity_in_units'].'</td>';
        $output2 .= '<td style="text-align:center;">'.number_format($wo_sqm,4).'</td>';
        $output2 .= '<td style="text-align:center;">'.($tempered_sqm).'</td>';
        $output2 .= '<td style="text-align:center;">'.($tempered_ratio).'</td>';
        $output2 .= '<td style="text-align:center;">'.($ig_pcs).'</td>';
        $output2 .= '<td style="text-align:center;">'.(number_format($ig_sqm,4)).'</td>';
        $output2 .= '<td style="text-align:center;">'.($ig_ratio).'</td>';
        $output2 .= '<td style="text-align:center;">'.($dispatch_pcs).'</td>';
        $output2 .= '<td style="text-align:center;">'.(number_format($dispatch_sqm,4)).'</td>';
        $output2 .= '<td style="text-align:center;">'.($disp_ratio).'</td>';
        $output2 .= '<td style="text-align:center;">'.($invoice_pcs).'</td>';
        $output2 .= '<td style="text-align:center;">'.(number_format($invoice_sqm,4)).'</td>';
        $output2 .= '<td style="text-align:center;">'.($invoice_ratio).'</td>';
        $output2 .= '<td style="text-align:center;">'.($row['currency_code']).'</td>';
        $output2 .= '<td style="text-align:center;">'.(number_format($line_value_with_vat,2)).'</td>';
        $output2 .= '<td style="text-align:center;">'.($row['receipt_no']).'</td>';
        $output2 .= '<td style="text-align:center;">'.($row['receipt_date']).'</td>';
        $output2 .= '</tr>';
    }
    // $output2 .= '</table>';
    return $output2;
}
$html .= headerSection($ref_no,$radio);
$html .= detailSection($ref_no,$radio); 


 
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
ob_end_clean();
$pdf->Output('example_001.pdf', 'I');
?>
