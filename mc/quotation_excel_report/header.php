<?php
require_once('tcpdf_include.php');
require ('../../../config.php');

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


$output2 = '<h2 style="text-align:center;font-family:Times New Roman;"><u>Customer Return Authorization '.'  '.'</u></h2>';
$output2 .= '<br><br>';

$output2 .= "";

$output2 .= '<table style="font-family: arial, sans-serif;width: 100%;font-size:11px" border="0.1">';
$output2 .= '<thead>'; 
$output2 .= '<tr>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Customer Name</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>CRA No</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Quotation.No</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Work Order.No</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Project ref.</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Cust.Complain Date</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Time</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Return to factory</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Mode Of Communi</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Comunicated By</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Qty to be returned</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Cumulative Disp.Qty</strong></th>';

// $output2 .= '<th height="25" style="text-align:center;"><strong>Cus.Complain Date/Time</strong></th>';
// $output2 .= '<th height="25" style="text-align:center;"><strong>Mode of Communi</strong></th>';
// $output2 .= '<th height="25" style="text-align:center;"><strong>Customer rep</strong></th>';
// $output2 .= '<th height="25" style="text-align:center;"><strong>Customer Comment</strong></th>';
// $output2 .= '<th height="25" style="text-align:center;"><strong>Marketing staff comment</strong></th>';
// $output2 .= '<th height="25" style="text-align:center;"><strong>Instruction for production</strong></th>';
$output2 .= '</tr>'; 

$output2 .= '</tbody>';




$output2 .= "";

$output2 .= '<table style="font-family: arial, sans-serif;width: 100%;font-size:11px" border="0.1">';

$output2 .= '<tr>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Customer Name</strong></th>';
$output2 .= '</tr>'; 

     $query ="SELECT
                quotation_header.quotation_no,
                customer_return_auth.id,
                customer_return_auth.cr_auth,
                customer_return_auth.cus_id,
                customer_return_auth.qid,
                customer_return_auth. COMMENT,
                customer_return_auth.mode_of_communication,
                customer_return_auth.date_of_communication,
                customer_return_auth.marketing_dep_obs,
                customer_return_auth.ins_production,
                customer_return_auth.goods_exp_date,
                customer_return_auth.goods_inspected,
                customer_return_auth.qtbr,
                mas_customer.CustomerName,
                customer_return_auth.communicated_by,
                quotation_header.project_reference,
                customer_return_auth.time,
                work_order_header.work_order_no,
                customer_return_auth.tcdq
              FROM
                customer_return_auth
              LEFT JOIN quotation_header ON customer_return_auth.qid = quotation_header.id
              LEFT JOIN mas_customer ON customer_return_auth.cus_id = mas_customer.ID
              LEFT JOIN work_order_header ON customer_return_auth.wid = work_order_header.id
              WHERE
                customer_return_auth.id = customer_return_auth.id"; 

  $sql = mysqli_query($con_main,$query);    
  $dat = mysqli_fetch_array($sql);           
    // $sqm = ($row['length']*$row['width'])/1000000*$row['quantity'];;
    // $sqm = round($sqm,4); 

  while ($work = mysqli_fetch_array($sql))
  {  
  
  $sqm = (($work['length']*$work['width'])/1000000)*$work['quantity'];
  
              
  $output2 .= '<tr>';
  $output2 .= '<thead>'; 
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"10\">".($work['CustomerName'])."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"10\">".($work['cr_auth'])."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['quotation_no'])."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['work_order_no'])."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['project_reference'])."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['date_of_communication'])."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['time'])."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['goods_exp_date'])."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['mode_of_communication'])."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['communicated_by'])."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['qtbr'])."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['tcdq'])."</td>";
  // $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['qtbr'])."</td>";
  // $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['date_of_communication'])."</td>";
  // $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['mode_of_communication'])."</td>";
  // $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['communicated_by'])."</td>";
  // $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['comment'])."</td>";
  // $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['marketing_dep_obs'])."</td>";
  // $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($work['ins_production'])."</td>";
  
  
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
  $output2 .= '</thead>'; 



  $qty = $qty + round($work['qtbr']);
  $sqmm = $sqmm + round($sqm,2);
  
 
}
      

$output2 .= '<tr>';
$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\"><strong>TOTAL</strong></td>";
$output2 .= '<td style="text-align:center;"></td>';


$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\"></td>";
$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\"></td>";
$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\"><strong>".number_format($qty)."</strong></td>";
// $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\"><strong>".number_format($sqmm,2)."</strong></td>";

$output2 .= '</tr>';
$output2 .= '<tbody>';
$output2 .= '</table>';


   $output2 .= '<p style="text-align:left;font-size:14px; font-weight:bold;">Customer Comment '.$dat['COMMENT'].'</p>';
   
   $output2 .= '<p style="text-align:left;font-size:14px; font-weight:bold;">Marketing Staff Comment '.$dat['marketing_dep_obs'].'</p>';

   $output2 .= '<p style="text-align:left;font-size:14px;font-weight:bold;">Instruction for production '.$dat['marketing_dep_obs'].'</p>';
 
   $output2 .= '<p style="text-align:left;font-size:14px;font-weight:bold;">Goods will be inspected by gurind staff before return into factory '.$dat['marketing_dep_obs'].'</p>';

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


 