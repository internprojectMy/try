<?php
require_once('tcpdf/tcpdf.php');
require ('../config.php');

$from = $_REQUEST['from'];
$to = $_REQUEST['to'];
$cmb = $_REQUEST['quot'];

$query = "";
$where = "";
$ref_no="";

ob_start();
$pdf = new TCPDF('l',PDF_UNIT,PDF_PAGE_FORMAT,true,'UTF-8',false);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
  $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->setFooterData(array(0,64,0), array(0,64,128));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));//Doc.Date
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$from_word=date("j-F-Y",strtotime($from));
$to_word=date("j-F-Y",strtotime($to));

if (@file_exists(dirname(__FILE__).'/lang/eng.php')){
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->setFontSubsetting(true);
$pdf->SetFont('dejavusans', '', 12, '', true);
$pdf->AddPage();
$output2 ="";


$output2 = '<h2 style="text-align:center;font-family:Times New Roman;"><u>Dispatch Listing Report from '.$from_word.' to '.$to_word.'</u></h2>';
$output2 .= '<br><br>';

$output2 .= "";

$output2 .= '<table style="font-family: arial, sans-serif;width: 100%;font-size:13px" border="1">';
$output2 .= '<thead>'; 
$output2 .= '<tr>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Dispatch.No</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Dispatch.Date</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Customer</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Salesman</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Proj.Ref</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>W/O.No</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Quotation.No</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Dispatch.Qty</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Dispatch.SQM</strong></th>';
$output2 .= '</tr>'; 
$output2 .= '</thead>';
$output2 .= '<tbody>';

     $query ="SELECT
              final_disp_header.disp,
              final_disp_header.date,
              mas_customer.CustomerName,
              CONCAT_WS(' ', mas_employee.first_name, mas_employee.last_name) AS FULL_NAME,
              quotation_header.project_reference,
              work_order_header.work_order_no,
              quotation_header.quotation_no,
              SUM(disp_final.disp_qty) AS TOTAL_DISPATCHED
              FROM
              disp_header
              INNER JOIN final_disp_header ON final_disp_header.disp_auth = disp_header.id
              INNER JOIN mas_customer ON disp_header.cus_id = mas_customer.ID
              INNER JOIN work_order_header ON disp_header.work_header = work_order_header.id
              INNER JOIN quotation_header ON work_order_header.quotation_id = quotation_header.id
              INNER JOIN mas_employee ON mas_employee.id = quotation_header.sales_person_id
              INNER JOIN disp_final ON final_disp_header.disp_auth = disp_final.id
              WHERE final_disp_header.dispatch_date BETWEEN '$from' AND '$to'
              GROUP BY
              final_disp_header.disp"; 

  $sql = mysqli_query($con_main,$query);               
    // $sqm = ($row['length']*$row['width'])/1000000*$row['quantity'];;
    // $sqm = round($sqm,4); 

  while ($work = mysqli_fetch_array($sql))
  { 
     $dispatch_no = $work['disp']; 
 $query="SELECT
          service_items.length,
          service_items.width,
          disp_final.disp_qty
        FROM
          disp_final
        INNER JOIN dispatch ON disp_final.item_id = dispatch.id
        INNER JOIN service_items ON dispatch.Item_id = service_items.id
        WHERE
          disp_final.disp = '$dispatch_no'";

  $q = mysqli_query($con_main,$query);
  $r = mysqli_fetch_assoc($q);

  $len = $r['length'];
  $wid = $r['width'];
  $qt = $r['disp_qty'];

  $disp_sqm = ($len*$wid*$qt)/1000000;
  $disp_sqm = round($disp_sqm,4);
              
  $output2 .= '<tr>';

  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['disp'])."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['date'])."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['CustomerName'])."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['FULL_NAME'])."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['project_reference'])."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['work_order_no'])."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['quotation_no'])."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['TOTAL_DISPATCHED'])."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".number_format($disp_sqm,4)."</td>";
  
  
  
  // $output2 .= '<td style="text-align:center;">'.($receipt_res['receipt_no']).'</td>';
  // $output2 .= '<td style="text-align:center;">'.($receipt_res['receipt_date']).'</td>';
  // $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($receipt_res['currency_code'])."</td>";
  // $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($receipt_res['RECEIPT_VALUE'])."</td>";
  // 
  // $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".number_format($advanced,2)."</td>";
  // $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".(number_format($cash,2))."</td>";
  // $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".(number_format($cash_bd,2))."</td>";
  // $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".(number_format($current,2))."</td>";
  // $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".(number_format($pd,2))."</td>";
  // $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".(number_format($tt,2))."</td>";
  // $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".(number_format($bd,2))."</td>";
  // $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".(number_format($bt,2))."</td>";
  // $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">-</td>";
  // $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($receipt_res['exp_rel_date'])."</td>";
  // $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($receipt_res['cheque_no'])."</td>";
  // $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($receipt_res['description'])."</td>";

  $output2 .= '</tr>';


  $qty = $qty + round($work['TOTAL_DISPATCHED'],2);
  $sqmm = $sqmm + round($disp_sqm,2);
 
 
}


$output2 .= '<tr>';
$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\"><strong>TOTAL</strong></td>";
$output2 .= '<td style="text-align:center;"></td>';

$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\"></td>";
$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\"></td>";
$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\"></td>";
$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\"></td>";
$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\"></td>";
$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\"><strong>".number_format($qty)."</strong></td>";
$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\"><strong>".number_format($sqmm,2)."</strong></td>";

$output2 .= '</tr>';
$output2 .= '<tbody>';
$output2 .= '</table>';


$output2 .= '<br>';

      session_start();
        date_default_timezone_set('Asia/Colombo');

        $user = $_SESSION['USER_CODE'];
        $today = date("F j, Y");
        $time = date("h:i a") ;//"h:i:s A"
        $user_query = "SELECT mas_user.FIRST_NAME,mas_user.LAST_NAME FROM mas_user WHERE mas_user.USER_CODE = '$user'";
        $user_sql = mysqli_query($con_main,$user_query);
        $user_res = mysqli_fetch_assoc($user_sql);
        $output2 .= '<p style="text-align:left;font-size:14px;">Printed By : '.$user_res['FIRST_NAME'].' '.$user_res['LAST_NAME'].' / '.$today.' / '
        .$time.'</p>';
        














 



     
$pdf->writeHTMLCell(0, 0, '', '', $output2, 0, 1, 0, true, '', true);
ob_end_clean();
$pdf->Output('example_001.pdf', 'I');
?>
