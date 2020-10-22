<?php
require_once('tcpdf/tcpdf.php');
require ('../config.php');

$cus_type = $_REQUEST['cus_type'];
$from = $_REQUEST['from'];
$to = $_REQUEST['to'];

ob_start();
$pdf = new TCPDF('l',PDF_UNIT,PDF_PAGE_FORMAT,true,'UTF-8',false);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->setFooterData(array(0,64,0), array(0,64,128));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
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
$output2="";

$output2 = '<h2 style="text-align:center;font-family:Times New Roman;"><u>Receipt Listning '.$from_word.' to '.$to_word.'</u></h2>';
$output2 .= '<br><br>';

$output2 .= "";
$output2 .= '<table style="font-family: arial, sans-serif;width: 100%;font-size:9px" border="1">';
$output2 .= '<thead>';   
$output2 .= '<tr>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Cus.Name</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Rec.No</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Date</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Currency</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Receipt Value</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Settled</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong> Advance </strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Cash@Counter</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Cash-BankDeposit</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Current Cheque</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>PD Cheque</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>TT</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Bank Draft</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Bank Transfer</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Other</strong></th>'; 
$output2 .= '<th height="25" style="text-align:center;"><strong>Release Date</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Ref.No</strong></th>';
$output2 .= '<th height="25" style="text-align:center;"><strong>Comments</strong></th>';

$output2 .= '</tr>'; 
$output2 .= '</thead>';
$output2 .= '<tbody>';

 
 if($cus_type != "All"){
   
   $rec_query ="SELECT
              mas_customer.CustomerName,
              quotation_payments_header.receipt_no,
              quotation_payments_header.receipt_date,
              mas_countries.currency_code,
              Sum(quotation_payments_detail.paid_amount) AS RECEIPT_VALUE,
              quotation_payments_header.payment_type,
              quotation_payments_header.exp_rel_date,
              quotation_payments_header.cheque_no,
              quotation_payments_header.description,
              quotation_payments_header.id
            FROM
              quotation_payments_header
            INNER JOIN mas_customer ON quotation_payments_header.customer_id = mas_customer.ID
            INNER JOIN mas_countries ON quotation_payments_header.currency_id = mas_countries.ID
            INNER JOIN quotation_payments_detail ON quotation_payments_header.id = quotation_payments_detail.header_id
            WHERE
            quotation_payments_header.customer_id = '$cus_type' AND
            quotation_payments_header.entered_date BETWEEN '$from' AND '$to'
            GROUP BY
              quotation_payments_detail.header_id
            ORDER BY
              quotation_payments_header.payment_type ASC,
              quotation_payments_header.entered_date ASC";
              }
           else{

  $rec_query ="SELECT
              mas_customer.CustomerName,
              quotation_payments_header.receipt_no,
              quotation_payments_header.receipt_date,
              mas_countries.currency_code,
              Sum(quotation_payments_detail.paid_amount) AS RECEIPT_VALUE,
              quotation_payments_header.payment_type,
              quotation_payments_header.exp_rel_date,
              quotation_payments_header.cheque_no,
              quotation_payments_header.description,
              quotation_payments_header.id
            FROM
              quotation_payments_header
            INNER JOIN mas_customer ON quotation_payments_header.customer_id = mas_customer.ID
            INNER JOIN mas_countries ON quotation_payments_header.currency_id = mas_countries.ID
            INNER JOIN quotation_payments_detail ON quotation_payments_header.id = quotation_payments_detail.header_id
            WHERE
            quotation_payments_header.receipt_date BETWEEN '$from' AND '$to'
            GROUP BY
              quotation_payments_detail.header_id
            ORDER BY
            quotation_payments_header.receipt_no ASC,
            quotation_payments_header.receipt_no ASC";


 }        



$sql = mysqli_query($con_main,$rec_query);

$rec_val = 0;
$settled = 0;
$adv = 0;
$tot_cash = 0;
$tot_cash_bd = 0;
$tot_current = 0;
$tot_pd = 0;
$tot_tt = 0;
$tot_bd = 0;
$tot_bt = 0;

while($receipt_res = mysqli_fetch_assoc($sql)){
  
  $header_id = $receipt_res['id']; 
  $cash = "-";
  $cash_bd = "-";
  $current = "-";
  $pd = "-";
  $tt = "-";
  $bd = "-";
  $bt = "-";

  if($receipt_res['payment_type'] == "Cash@counter"){ 
    $cash = $receipt_res['RECEIPT_VALUE'];
  }else if($receipt_res['payment_type'] == "Cash-Bankdeposit"){
    $cash_bd = $receipt_res['RECEIPT_VALUE']; 
  }else if($receipt_res['payment_type'] == "Current Cheque"){
    $current = $receipt_res['RECEIPT_VALUE'];  
  }else if($receipt_res['payment_type'] == "PD Cheque"){
    $pd = $receipt_res['RECEIPT_VALUE'];  
  }else if($receipt_res['payment_type'] == "TT"){
    $tt = $receipt_res['RECEIPT_VALUE']; 
  }else if($receipt_res['payment_type'] == "Bank Draft"){
    $bd = $receipt_res['RECEIPT_VALUE'];  
  }else if($receipt_res['payment_type'] == "Bank Transfers"){
    $bt = $receipt_res['RECEIPT_VALUE'];
  }

  $sub_query = "SELECT
                  quotation_payments_detail.payment_for,
                  quotation_payments_detail.paid_amount
                FROM
                  quotation_payments_detail
                WHERE
                  quotation_payments_detail.header_id = '$header_id'";

  $header_sql = mysqli_query($con_main,$sub_query);
  
  $settled = 0;
  $advanced = 0;

  while($header_res = mysqli_fetch_assoc($header_sql)){
   
     if($header_res['payment_for'] = "Quotation" || $header_res['payment_for'] = "Invoice"){
        $settled = $settled + round($header_res['paid_amount'],2);
     }else{
        $advanced = $advanced + round($header_res['paid_amount'],2); 
     } 

  }
  $output2 .= '<tr>';

  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($receipt_res['CustomerName'])."</td>";
  $output2 .= '<td style="text-align:center;">'.($receipt_res['receipt_no']).'</td>';
  $output2 .= '<td style="text-align:center;">'.($receipt_res['receipt_date']).'</td>';
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($receipt_res['currency_code'])."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($receipt_res['RECEIPT_VALUE'])."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".number_format($settled,2)."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".number_format($advanced,2)."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".(number_format($cash,2))."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".(number_format($cash_bd,2))."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".(number_format($current,2))."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".(number_format($pd,2))."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".(number_format($tt,2))."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".(number_format($bd,2))."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".(number_format($bt,2))."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">-</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($receipt_res['exp_rel_date'])."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($receipt_res['cheque_no'])."</td>";
  $output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".($receipt_res['description'])."</td>";

  $output2 .= '</tr>';
  
  $rec_val = $rec_val + round($receipt_res['RECEIPT_VALUE'],2);
  $settled = $settled + round($settled,2);
  $adv = $adv + round($advanced,2);
  $tot_cash = $tot_cash + round($cash,2);
  $tot_cash_bd = $tot_cash_bd + round($cash_bd,2);
  $tot_current = $tot_current + round($current,2);
  $tot_pd = $tot_pd + round($pd,2);
  $tot_tt = $tot_tt + round($tt,2);
  $tot_bd = $tot_bd + round($bd,2);
  $tot_bt = $tot_bt + round($tot_bt,2);  
}

$output2 .= '<tr>';
$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\"><strong>TOTAL</strong></td>";
$output2 .= '<td style="text-align:center;"></td>';
$output2 .= '<td style="text-align:center;"></td>';
$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\"></td>";
$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".number_format($rec_val,2)."</td>";
$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".number_format($settled,2)."</td>";
$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".number_format($adv,2)."</td>";
$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".(number_format($tot_cash,2))."</td>";
$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".(number_format($tot_cash_bd,2))."</td>";
$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".(number_format($tot_current,2))."</td>";
$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".(number_format($tot_pd,2))."</td>";
$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".(number_format($tot_tt,2))."</td>";
$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".(number_format($tot_bd,2))."</td>";
$output2 .= "<td style=\"text-align:center;\" colspan=\"1\" height=\"14\">".(number_format($tot_bt,2))."</td>";
$output2 .= '</tr>';

$output2 .= '<tbody>';
$output2 .= '</table>';



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
