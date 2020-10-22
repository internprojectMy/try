<?php
require_once('tcpdf_include.php');
require ('../../../config.php');

$from = $_REQUEST['from'];
$to = $_REQUEST['to'];
$cmb = $_REQUEST['quot'];
$auth_id = $_REQUEST['id'];


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

if (@file_exists(dirname(__FILE__).'/lang/eng.php')){
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

$pdf->setFontSubsetting(true);
$pdf->SetFont('dejavusans', '', 12, '', true);
$pdf->AddPage();
$output2="";

$query = "SELECT
              quotation_header.quotation_no,
              customer_return_auth.id,
              customer_return_auth.cr_auth,
              customer_return_auth.cus_id,
              customer_return_auth.qid,
              customer_return_auth.COMMENT,
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
              customer_return_auth.won_id,
              customer_return_auth.tcdq,
              customer_return_auth.entered_by,
              customer_return_auth.entered_date
              FROM
              customer_return_auth
              LEFT JOIN quotation_header ON customer_return_auth.qid = quotation_header.id
              LEFT JOIN mas_customer ON customer_return_auth.cus_id = mas_customer.ID
              WHERE
              customer_return_auth.id = $auth_id ";

$sql = mysqli_query($con_main,$query);
$dat = mysqli_fetch_array($sql);


$output2 = '<h2 style="text-align:center;font-family:Times New Roman;"><u>Customer Return Authorization</u></h2>';
$output2 .= '<br><br>';

$output2 .= "";

$output2 .= '<table style="font-family: arial, sans-serif;width: 100%;font-size:11px" >';

$output2 .= '<thead>'; 
$output2 .= '<tr>';

$output2 .= '<th height="10" style="text-align:center;">Customer Name</th>';
$output2 .= '<th height="10" style="text-align:center;">CRA No</th>';
$output2 .= '<th height="10" style="text-align:center;">Quotation.No</th>';
$output2 .= '<th height="10" style="text-align:center;">Work Order.No</th>';
$output2 .= '<th height="10" style="text-align:center;">Project ref.</th>';

$output2 .= '</tr>'; 
$output2 .= '</thead>'; 

$output2 .= '<tbody>';       
$output2 .= '<tr>';
$output2 .= '<td style="text-align:center"; colspan="1" height="10"><strong>'.$dat['CustomerName'].'</strong></td>';
$output2 .= '<td style="text-align:center;" colspan="1" height="10"><strong>'.$dat['cr_auth'].'</strong></td>';
$output2 .= '<td style="text-align:center;" colspan="1" height="10"><strong>'.$dat['quotation_no'].'</strong></td>';
$output2 .= '<td style="text-align:center;" colspan="1" height="10"><strong>'.$dat['won_id'].'</strong></td>';
$output2 .= '<td style="text-align:center;" colspan="1" height="10"><strong>'.$dat['project_reference'].'</strong></td>';

$output2 .= '</tr>';
$output2 .= '<tbody>';

$output2 .= '</table><br><br>';

$output2 .= '<table style="font-family: arial, sans-serif;width: 100%;font-size:11px" >';

$output2 .= '<thead>'; 
$output2 .= '<tr>';

$output2 .= '<th height="10" style="text-align:center;">Cust.Complain Date</th>';
$output2 .= '<th height="10" style="text-align:center;">Time</th>';
$output2 .= '<th height="10" style="text-align:center;">Return to factory</th>';
$output2 .= '<th height="10" style="text-align:center;">Mode Of Communi</th>';
$output2 .= '<th height="10" style="text-align:center;">Comunicated By</th>';
$output2 .= '<th height="10" style="text-align:center;">Qty to be returned</th>';
$output2 .= '<th height="10" style="text-align:center;">Cumulative Disp.Qty</th>';

$output2 .= '</tr>'; 
$output2 .= '</thead>'; 
$output2 .= '<tbody>';       
$output2 .= '<tr>';

$from_word=date("j-F-Y",strtotime($dat['date_of_communication']));
$from_words=date("j-F-Y",strtotime($dat['goods_exp_date']));

$output2 .= '<td style="text-align:center;" colspan="1" height="10"><strong>'.$from_word.'</strong></td>';
$output2 .= '<td style="text-align:center;" colspan="1" height="10"><strong>'.$dat['time'].'</strong></td>';
$output2 .= '<td style="text-align:center;" colspan="1" height="10"><strong>'.$from_words.'</strong></td>';
$output2 .= '<td style="text-align:center;" colspan="1" height="10"><strong>'.$dat['mode_of_communication'].'</strong></td>';
$output2 .= '<td style="text-align:center;" colspan="1" height="10"><strong>'.$dat['communicated_by'].'</strong></td>';
$output2 .= '<td style="text-align:center;" colspan="1" height="10"><strong>'.$dat['qtbr'].'</strong></td>';
$output2 .= '<td style="text-align:center;" colspan="1" height="10"><strong>'.$dat['tcdq'].'</strong></td>';

$output2 .= '</tr>';
$output2 .= '<tbody>';
$output2 .= '</table><br>';


$output2 .= '<p style="text-align:left;font-size:12px;">Customer Comment <strong>'.$dat['COMMENT'].'</p>';

$output2 .= '<p style="text-align:left;font-size:12px;">Marketing Staff Comment <strong>'.$dat['marketing_dep_obs'].'</p>';

$output2 .= '<p style="text-align:left;font-size:12px;">Instruction for production <strong>'.$dat['ins_production'].'</p>';

$output2 .= '<p style="text-align:left;font-size:12px;">Goods will be inspected by gurind staff before return into factory <strong>'.$dat['goods_inspected']
.'</p>';

   $html .= "<br>";
    
   $html .= "</table>";

 $query = "SELECT
          mas_user.FIRST_NAME,
          mas_user.LAST_NAME,
          DATE(customer_return_auth.entered_date) AS DATE_ONLY
          FROM
          customer_return_auth
          INNER JOIN mas_user ON customer_return_auth.entered_by = mas_user.USER_CODE
          WHERE
          customer_return_auth.id = '$auth_id'";
            
          $sql = mysqli_query($con_main,$query);
          $res = mysqli_fetch_assoc($sql);
          $fname = $res['FIRST_NAME'];
          $lname = $res['LAST_NAME'];
          $date = $res['DATE_ONLY'];

          $html .= '<table style="padding:15px;">';
          $html .= '<tr>';
          $html .= '<td style="text-align:left;font-size:10px;">Created By : ';
          $html .= $fname." ".$lname;
          $html .= '</td>';
          $html .= '<td style="text-align:left;font-size:10px;">Created Date : ';
          $html .= $date;
          $html .= '</td>';
          $html .= '<td style="text-align:right;font-size:10px;">Authorized By :.........................</td>';
          $html .= '</tr>';
          $html .= '</table>';

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
        








 



     


 