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

$to_date = $_REQUEST['to_date'];
$today = date("F j, Y",strtotime($to_date));
$customer = $_REQUEST['customer'];
$sales_person = $_REQUEST['sales_person'];
$settlement = $_REQUEST['set']; 
$payment_method = array();

$grand_status1 = 0;
$grand_status2 = 0;
$grand_status3 = 0;
$grand_status4 = 0;
$grand_status5 = 0;
$grand_tot_inv = 0;
$grand_tot_bal = 0;

$html = '<h2 style="text-align:center;font-family:Times New Roman;"><u>Debtors Summary Report as of '.$today.'</u></h2>';
$html .= '<br><br>';

if(strpos($customer,',') !== false ){
  $arr = explode(',',$customer);
}else{
  $arr = array();
  // $arr[0] = $customer;
  if($customer == "0"){
     $i=0;
     $cust_query = "SELECT mas_customer.ID FROM mas_customer ORDER BY mas_customer.CustomerCode ASC";
     $cust_sql = mysqli_query($con_main,$cust_query);
     while($cust_res = mysqli_fetch_assoc($cust_sql)){
       $arr[$i] = $cust_res['ID'];
       $i++;
     }
  }else{   
     $arr[0] = $customer;
  }
}

if(strpos($sales_person,',') !== false){
  $arr2 = explode(',',$sales_person);
}else{
  $arr2 = array();
  if($sales_person == "0"){
     $i=0;
     $emp_query = "SELECT mas_employee.id FROM mas_employee";
     $emp_sql = mysqli_query($con_main,$emp_query);
     while($emp_res = mysqli_fetch_assoc($emp_sql)){
       $arr2[$i] = $emp_res['id'];
       $i++;
     }
  }else{   
     $arr2[0] = $sales_person;
  }
}

$html .= '<table border="0">';
$html .= '<tr>';

$html .= '<th>Salesman :';
if($sales_person == "0"){
  $html .= 'All Sales Persons'; 
}else{
  $html .= '<br>'; 
  $x = 1;
   foreach ($arr2 as $value){
      $sales_query = "SELECT
                        CONCAT_WS(' ',mas_employee.first_name,mas_employee.last_name) AS FULL_NAME
                      FROM
                        mas_employee
                      WHERE
                        mas_employee.id = '$value'";

      $sales_sql = mysqli_query($con_main,$sales_query);
      $sales_res = mysqli_fetch_assoc($sales_sql);
      $html .= $x.') '.$sales_res['FULL_NAME'].'<br>';
      $x++;
   }
}
$html .= '</th>';
$html .= '<th></th>';
$html .= '<th>Customer :';
if($customer == "0"){
  $html .= 'All Customers'; 
}else{
  $html .= '<br>'; 
   $x = 1;
   foreach ($arr as $value){
      $cust_query = "SELECT mas_customer.CustomerName FROM mas_customer WHERE mas_customer.ID = '$value'";
      $cust_sql = mysqli_query($con_main,$cust_query);
      $cust_res = mysqli_fetch_assoc($cust_sql);
      $html .= $x.') '.$cust_res['CustomerName'].'<br>';
      $x++;
   }
}
$html .= '</th>';

$html .= '</tr>';
$html .= '</table>';

 $ar_count = 0;
 $html .= '<table style="font-family: arial,sans-serif;border-collapse: collapse;width: 100%;font-size:12px;" border="1">';
 $html .= '<thead>';
 $html .= '<tr>';
 $html .= '<th></th>';
 $html .= '<th></th>';
 $html .= '<th></th>';
 $html .= '<th></th>';
 $html .= '<th></th>';
 $html .= '<th style="text-align:center;" colspan="5"><strong>Days</strong></th>';
 $html .= '</tr>';

 $html .= '<tr>';
 $html .= '<th><strong>Customer</strong></th>';
 $html .= '<th><strong>Salesman</strong></th>';
 $html .= '<th style="text-align:center;"><strong>Cur</strong></th>';
 $html .= '<th style="text-align:center;"><strong>Invoiced Total</strong></th>';
 $html .= '<th style="text-align:center;"><strong>Bal. O/S</strong></th>';
 $html .= '<th style="text-align:center;"><strong> 30</strong></th>';
 $html .= '<th style="text-align:center;"><strong>30-60</strong></th>';
 $html .= '<th style="text-align:center;"><strong>61-90</strong></th>';
 $html .= '<th style="text-align:center;"><strong>90-120</strong></th>';
 $html .= '<th style="text-align:center;"><strong>120</strong></th>';
 $html .= '</tr>';
 $html .= '</thead>';
 $html .= '<tbody>'; 

foreach($arr2 as $value2){
foreach ($arr as $value){
  //MAIN QUERY
    $main_query = "SELECT
                     mas_invoice_header.total_value,
                     mas_invoice_header.reference,
                     mas_invoice_header.invoice_date,
                     mas_invoice_header.invoice_no,
                     mas_invoice_header.reference_no
                   FROM
                     mas_invoice_header
                   WHERE
                     mas_invoice_header.invoice_date <= '$to_date'
                   AND mas_invoice_header.status = '1'
                   ORDER BY
                     mas_invoice_header.invoice_date ASC";

    $main_sql = mysqli_query($con_main,$main_query);
    $total_invoice_val1 = 0;
    $total_balance_val1 = 0;
    $con1 = 0;
    $con2 = 0;
    $con3 = 0;
    $con4 = 0;
    $con5 = 0;

     while($main_res = mysqli_fetch_assoc($main_sql)){
          
      $allow_iterate = false;
      if($main_res['reference'] == "quotation"){
              
         $quot_header_id = $main_res['reference_no'];
         $query2 =  "SELECT
                        quotation_header.quotation_no,
                        CONCAT_WS(' ',mas_employee.first_name,mas_employee.last_name) AS FULL_NAME,
                        mas_customer.CustomerName,
                        quotation_header.id
                   FROM
                        quotation_header
                   INNER JOIN mas_employee ON quotation_header.sales_person_id = mas_employee.id
                   INNER JOIN mas_customer ON quotation_header.customer_id = mas_customer.ID
                   WHERE
                   quotation_header.id = '$quot_header_id' AND
                   quotation_header.customer_id = '$value'
                    AND
                   quotation_header.sales_person_id = '$value2'";

        $sql2 = mysqli_query($con_main,$query2);
        $num_rows = mysqli_num_rows($sql2);     
        if($num_rows > 0){
            $allow_iterate = true;
            $res2 = mysqli_fetch_assoc($sql2);
            $quotation_number = $res2['quotation_no'];
            $customer = $res2['CustomerName']; 
            $sales_person = $res2['FULL_NAME'];
            $currency_query = "SELECT
                                  mas_countries.currency_code
                              FROM
                                mas_quotation
                              INNER JOIN mas_countries ON mas_quotation.quotation_currency = mas_countries.ID
                              WHERE
                                mas_quotation.quotation_header_id = '$quot_header_id'
                              GROUP BY
                                mas_quotation.quotation_header_id";
            $currency_sql = mysqli_query($con_main,$currency_query);
            $currency_res = mysqli_fetch_assoc($currency_sql);
        }
              
      }else if($main_res['reference'] == "dispatch"){
              
          $disp_header_id = $main_res['reference_no'];
          $query3 = "SELECT
                      work_order_header.quotation_id
                    FROM
                      final_disp_header
                    INNER JOIN disp_header ON final_disp_header.disp_auth = disp_header.id
                    INNER JOIN work_order_header ON disp_header.work_header = work_order_header.id
                    WHERE
                      final_disp_header.id = '$disp_header_id'";

          $sql3 = mysqli_query($con_main,$query3);
          $res3 = mysqli_fetch_assoc($sql3);
          $head = $res3['quotation_id'];

           $query4 = "SELECT
                          quotation_header.quotation_no,
                          CONCAT_WS(' ',mas_employee.first_name,mas_employee.last_name) AS FULL_NAME,
                          mas_customer.CustomerName,
                          quotation_header.id
                      FROM
                          quotation_header
                      INNER JOIN mas_employee ON quotation_header.sales_person_id = mas_employee.id
                      INNER JOIN mas_customer ON quotation_header.customer_id = mas_customer.ID
                      WHERE
                      quotation_header.id = '$head' AND
                      quotation_header.customer_id = '$value'";

           $sql4 = mysqli_query($con_main,$query4);
              
           $num_rows = mysqli_num_rows($sql4);

          if($num_rows > 0){
               $allow_iterate = true;
               $res4 = mysqli_fetch_assoc($sql4);
               $quotation_number = $res4['quotation_no'];
               $customer = $res4['CustomerName']; 
               $sales_person = $res4['FULL_NAME'];
               $currency_query = "SELECT
                                      mas_countries.currency_code
                                  FROM
                                    mas_quotation
                                  INNER JOIN mas_countries ON mas_quotation.quotation_currency = mas_countries.ID
                                  WHERE
                                    mas_quotation.quotation_header_id = '$quot_header_id'
                                  GROUP BY
                                    mas_quotation.quotation_header_id";
               $currency_sql = mysqli_query($con_main,$currency_query);
               $currency_res = mysqli_fetch_assoc($currency_sql);
          }
      }
         
         if($allow_iterate){
           
           $inv = $main_res['invoice_no'];
           $paid_query = "SELECT
                              Sum(quotation_payments_detail.paid_amount) AS TOTAL_PAID,
                              quotation_payments_header.payment_type
                          FROM
                          quotation_payments_detail
                          INNER JOIN quotation_payments_header ON quotation_payments_detail.header_id = quotation_payments_header.id
                          WHERE
                              (quotation_payments_detail.reference_no = '$inv' OR quotation_payments_detail.reference_no = '$quotation_number')
                          AND DATE(quotation_payments_header.receipt_date) <= '$to_date'";

             $paid_sql = mysqli_query($con_main,$paid_query);
             $paid_res = mysqli_fetch_assoc($paid_sql);
             $num_rows = mysqli_num_rows($paid_sql);
             if($num_rows > 0){
                 $paid_amount = round($paid_res['TOTAL_PAID'],2);
                 $payment_method[$ar_count] = $paid_res['payment_type'];
                 $ar_count++;
             }else{
                 $paid_amount = 0;  
             }
            
             $invoice_val = round($main_res['total_value'],2);

           if($invoice_val > $paid_amount){

              $balance_to_pay = $invoice_val - $paid_amount; 
              $invoice_date = date_create($main_res['invoice_date']);
              $todt = date_create($to_date);
              $diff = date_diff($invoice_date,$todt);
              $no = $diff->format("%R%a");
              $no = (int)$no;
              if($no<=30){
                $con1 = $con1 + round($balance_to_pay,2); 
              }else if($no>30 && $no<=60){
                $con2 = $con2 + round($balance_to_pay,2);
              }else if($no>61 && $no<=90){
                $con3 = $con3 + round($balance_to_pay,2);
              }else if($no>90 && $no<=120){
                $con4 = $con4 + round($balance_to_pay,2);
              }else{
                $con5 = $con5 + round($balance_to_pay,2);
              }
              $total_invoice_val1 = $total_invoice_val1 + round($main_res['total_value'],2); 
              $total_balance_val1 = $total_balance_val1 + round($balance_to_pay,2);
           }
         }   
     }
      
    //GET OPENING INVOICES
      $grand_outstanding_amount = 0;
      $open_invoice_val = 0;
      $open_query = "SELECT
                      opening_invoices.man_invoice_no,
                      opening_invoices.invoice_date,
                      opening_invoices.currency_id,
                      opening_invoices.original_value,
                      opening_invoices.outstanding_value,
                      mas_countries.currency_code
                    FROM
                      opening_invoices
                    INNER JOIN mas_countries ON opening_invoices.currency_id = mas_countries.ID
                    WHERE
                      opening_invoices.customer_id = '$value'
                    AND opening_invoices.invoice_date <= '$to_date'";

      $open_sql = mysqli_query($con_main,$open_query);
      $numb_rows = mysqli_num_rows($open_sql);

      if($numb_rows > 0){
          $con_1 = 0;
          $con_2 = 0;
          $con_3 = 0;
          $con_4 = 0;
          $con_5 = 0;
          while($open_res = mysqli_fetch_assoc($open_sql)){

            $invoice_numb = $open_res['man_invoice_no'];
            $invoice_dt = $open_res['invoice_date'];
            $currency = $open_res['currency_code'];  
            $invoice_val = $open_res['original_value'];
            $balance_val = $open_res['outstanding_value'];
            
            $invoice_val = round($invoice_val,2);
            $balance_val = round($balance_val,2);
            $open_paid_amount = $invoice_val - $balance_val; 
            $system_paid_amount = 0; 

            $system_paid_query = "SELECT
                                    Sum(quotation_payments_detail.paid_amount) AS TOTAL_PAID,
                                    quotation_payments_header.payment_type
                                  FROM
                                    quotation_payments_detail
                                  INNER JOIN quotation_payments_header ON quotation_payments_detail.header_id = quotation_payments_header.id
                                  WHERE
                                    quotation_payments_detail.reference_no = '$invoice_numb'
                                  AND DATE(quotation_payments_header.receipt_date) <= '$to_date'";

            $system_paid_sql = mysqli_query($con_main,$system_paid_query);
            $system_paid_rows = mysqli_num_rows($system_paid_sql);
            if($system_paid_rows > 0){
               $system_paid_res = mysqli_fetch_assoc($system_paid_sql);
               $system_paid_amount = round($system_paid_res['TOTAL_PAID'],2);
            }
           
            $total_paid_amount = $open_paid_amount + $system_paid_amount;
            $total_outstanding_amount = $invoice_val - $total_paid_amount;
            $total_outstanding_amount = round($total_outstanding_amount,2);   

            $invoice_date = date_create($invoice_dt);
            $todt = date_create($to_date);
            $diff = date_diff($invoice_date,$todt);
            $no = $diff->format("%R%a");
            $no = (int)$no;    
            if($no<=30){
              $con_1 = $con_1 + round($total_outstanding_amount,2);
            }else if($no>30 && $no<=60){
              $con_2 = $con_2 + round($total_outstanding_amount,2);
            }else if($no>61 && $no<=90){
              $con_3 = $con_3 + round($total_outstanding_amount,2);
            }else if($no>90 && $no<=120){
              $con_4 = $con_4 + round($total_outstanding_amount,2);
            }else{
              $con_5 = $con_5 + round($total_outstanding_amount,2);
            }
            $grand_outstanding_amount = $grand_outstanding_amount + round($total_outstanding_amount,2); 
            $open_invoice_val = $open_invoice_val + $invoice_val; 
          }
      }
      //END GET OPENING INVOICES

   //GET UNALLOCATED PAYMENTS
    $unallocated_query = "SELECT
                            quotation_payments_detail.reference_no,
                            quotation_payments_detail.paid_amount,
                            quotation_payments_header.receipt_date AS DATE_ONLY
                        FROM
                            quotation_payments_header
                        INNER JOIN quotation_payments_detail ON quotation_payments_header.id = quotation_payments_detail.header_id
                        WHERE
                            quotation_payments_header.customer_id = '$value'
                        AND DATE(quotation_payments_header.receipt_date) <= '$to_date'
                        AND quotation_payments_detail.payment_for = 'General'";

    $unallocated_sql = mysqli_query($con_main,$unallocated_query);
    $total_advance = 0;
    $un_al1 = 0;
    $un_al2 = 0;
    $un_al3 = 0;
    $un_al4 = 0;
    $un_al5 = 0;
    while($unallocated_res = mysqli_fetch_assoc($unallocated_sql)){

        $adv_date = date_create($unallocated_res['DATE_ONLY']);
        $todt = date_create($to_date);
        $diff = date_diff($adv_date,$todt);
        $no = $diff->format("%R%a");
        $no = (int)$no;
        if($no<=30){
          $un_al1 = $un_al1 + round($unallocated_res['paid_amount'],2); 
         }else if($no>30 && $no<=60){
          $un_al2 = $un_al2 + round($unallocated_res['paid_amount'],2);
         }else if($no>61 && $no<=90){
          $un_al3 = $un_al3 + round($unallocated_res['paid_amount'],2);
         }else if($no>90 && $no<=120){
          $un_al4 = $un_al4 + round($unallocated_res['paid_amount'],2);
         }else{
          $un_al5 = $un_al5 + round($unallocated_res['paid_amount'],2);
        }
        $total_advance = $total_advance + round($unallocated_res['paid_amount'],2);
    }
    //END GET UNALLOCATED PAYMENTS
        
        $total_balance_val1 = $total_balance_val1 + $grand_outstanding_amount;
        $balance = $total_balance_val1 - $total_advance;
        $total_invoice_val1 = $total_invoice_val1 + $open_invoice_val;

        $status1 = ($con1 + $con_1) - $un_al1;  
        $status2 = ($con2 + $con_2) - $un_al2; 
        $status3 = ($con3 + $con_3) - $un_al3; 
        $status4 = ($con4 + $con_4) - $un_al4; 
        $status5 = ($con5 + $con_5) - $un_al5; 

        $html .= '<tr>';
        $html .= '<td style="text-align:left;">'.$customer.'</td>';
        $html .= '<td style="text-align:left;">'.$sales_person.'</td>';
        $html .= '<td style="text-align:center;">'.$currency_res['currency_code'].'</td>';
        $html .= '<td style="text-align:right;">'.number_format($total_invoice_val1,2).'</td>';
        $html .= '<td style="text-align:right;">'.number_format($balance,2).'</td>';
        $html .= '<td style="text-align:right;">'.number_format($status1,2).'</td>';
        $html .= '<td style="text-align:right;">'.number_format($status2,2).'</td>';
        $html .= '<td style="text-align:right;">'.number_format($status3,2).'</td>';
        $html .= '<td style="text-align:right;">'.number_format($status4,2).'</td>';
        $html .= '<td style="text-align:right;">'.number_format($status5,2).'</td>';
        $html .= '</tr>';

        $grand_status1 = $grand_status1 + $status1;
        $grand_status2 = $grand_status2 + $status2;
        $grand_status3 = $grand_status3 + $status3;
        $grand_status4 = $grand_status4 + $status4;
        $grand_status5 = $grand_status5 + $status5;  

        $grand_tot_inv = $grand_tot_inv + $total_invoice_val1; 
        $grand_tot_bal = $grand_tot_bal + $balance;      
}
}
        $html .= '<tr>';
        $html .= '<td style="text-align:left;" colspan="3"><strong>GRAND TOTAL</strong></td>';
        $html .= '<td style="text-align:right;"><strong>'.number_format($grand_tot_inv,2).'</strong></td>';
        $html .= '<td style="text-align:right;"><strong>'.number_format($grand_tot_bal,2).'</strong></td>';
        $html .= '<td style="text-align:right;"><strong>'.number_format($grand_status1,2).'</strong></td>';
        $html .= '<td style="text-align:right;"><strong>'.number_format($grand_status2,2).'</strong></td>';
        $html .= '<td style="text-align:right;"><strong>'.number_format($grand_status3,2).'</strong></td>';
        $html .= '<td style="text-align:right;"><strong>'.number_format($grand_status4,2).'</strong></td>';
        $html .= '<td style="text-align:right;"><strong>'.number_format($grand_status5,2).'</strong></td>';
        $html .= '</tr>';  

        $html .= '</tbody>';
        $html .= '</table>';
  
        $html .= '<br>';

        // $html .= '<h3 style="text-align:left;"><u>Collection Summary</u></h3>';

        // $html .= '<table border="1">';
        // $html .= '<thead>';
        // $html .= '<tr>';
        // $html .= '<th colspan="3"></th>';
        // $html .= '<th>Cash</th>';
        // $html .= '<th>Cheques</th>';
        // $html .= '<th>PD Chq.</th>';
        // $html .= '</tr>';
        // $html .= '</thead>';
        // $html .= '</table>';

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