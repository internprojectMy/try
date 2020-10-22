<?php
require_once('tcpdf_include.php');
require ('../../../config.php');

ob_start();
$pdf = new TCPDF('l',PDF_UNIT,PDF_PAGE_FORMAT,true,'UTF-8',false);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->setFooterData(array(0,64,0), array(0,64,128));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

if (@file_exists(dirname(__FILE__).'/lang/eng.php')){
  require_once(dirname(__FILE__).'/lang/eng.php');
  $pdf->setLanguageArray($l);
}

$pdf->setFontSubsetting(true);
$pdf->SetFont('dejavusans','',12,'',true);
$pdf->AddPage();

$today = date("F j, Y",strtotime($to_date));
$filter = $_REQUEST['filter'];


$html = '<h2 style="text-align:center;font-family:Times New Roman;"><u>Moulde Stroge Terminal Print</u></h2>';
$html .= '<br><br>';

if(strpos($filter,',') !== false ){
     $arr = explode(',',$filter);
}else{
     $arr = array();
     $arr[0] = $customer;
}

 foreach ($arr as $key => $value) {

       $html .= '<p>'.$value.'</p>';
  
       $html .= '<table style="font-family: arial,sans-serif;border-collapse: collapse;width: 100%;font-size:12px;" border="1">';
       $html .= '<thead>';
       $html .= '<tr>';
       $html .= '<th><strong>Equipment</strong></th>';
       $html .= '<th><strong>Mo No</strong></th>';
       $html .= '<th style="text-align:center;"><strong>Tred Ring</strong></th>';
       $html .= '<th style="text-align:center;"><strong>Side Ring</strong></th>';
       $html .= '<th style="text-align:center;"><strong>Core Normal</strong></th>';
       $html .= '<th style="text-align:center;"><strong>Core Quick</strong></th>';
       $html .= '<th style="text-align:center;"><strong>Name Plate</strong></th>';
       $html .= '<th style="text-align:center;"><strong>Casing No</strong></th>';
       $html .= '<th style="text-align:center;"><strong>Rack No</strong></th>';
       $html .= '<th style="text-align:center;"><strong>Cell No</strong></th>';
       $html .= '<th style="text-align:center;"><strong>ABC Indicator</strong></th>';
       $html .= '<th style="text-align:center;"><strong>SAP</strong></th>';
       $html .= '</tr>';
       $html .= '</thead>';


       $html .= '<tbody>';
       
       $query = "SELECT
                    mould_storage_terminal.id,
                    mould_storage_terminal.description,
                    mould_storage_terminal.equipment,
                    mould_storage_terminal.mo_no,
                    mould_storage_terminal.side_rinig,
                    mould_storage_terminal.tread_rinig,
                    mould_storage_terminal.core_normal,
                    mould_storage_terminal.caore_qick,
                    mould_storage_terminal.name_plate,
                    mould_storage_terminal.casing_no,
                    mould_storage_terminal.rack_no,
                    mould_storage_terminal.cell_no,
                    mould_storage_terminal.abc_indicator,
                    mould_storage_terminal.sap
                FROM `mould_storage_terminal`
                WHERE
                mould_storage_terminal.description = '$value'";

       $sql = mysqli_query($con_main,$query);

       while($res = mysqli_fetch_assoc($sql)){
          
           $html .= '<tr>';
           $html .= '<td>'.$res['equipment'].'</td>';
           $html .= '<td>'.$res['mo_no'].'</td>';
           if($res['tread_rinig'] == "FALSE"){
             $html .= '<td></td>';
           }else{
             $html .= '<td>'.$res['tread_rinig'].'</td>'; 
           }

           if($res['side_rinig'] == "FALSE"){
             $html .= '<td></td>';
           }else{
             $html .= '<td>'.$res['side_rinig'].'</td>'; 
           }
           
           if($res['core_normal'] == "FALSE"){
             $html .= '<td></td>';
           }else{
             $html .= '<td>'.$res['core_normal'].'</td>'; 
           }

           if($res['caore_qick'] == "FALSE"){
             $html .= '<td></td>';
           }else{
             $html .= '<td>'.$res['caore_qick'].'</td>'; 
           }

           $html .= '<td>'.$res['name_plate'].'</td>';
           $html .= '<td>'.$res['casing_no'].'</td>';
           $html .= '<td>'.$res['rack_no'].'</td>';
           $html .= '<td>'.$res['cell_no'].'</td>';
           $html .= '<td>'.$res['abc_indicator'].'</td>';
           $html .= '<td>'.$res['sap'].'</td>';
           $html .= '</tr>';
       }

       $html .= '</tbody>';


       $html .= '</table>';

}


session_start();
$user = $_SESSION['USER_CODE'];
$today = date("F j, Y");
$user_query = "SELECT mas_user.FIRST_NAME,mas_user.LAST_NAME FROM mas_user WHERE mas_user.USER_CODE = '$user'";
$user_sql = mysqli_query($con_main,$user_query);
$user_res = mysqli_fetch_assoc($user_sql);
$html .= '<p style="text-align:left;font-size:14px;">Printed By : '.$user_res['FIRST_NAME'].' '.$user_res['LAST_NAME'].' / '.$today.'</p>';

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
ob_end_clean();
$pdf->Output('Debtors_summary.pdf','I');
?>