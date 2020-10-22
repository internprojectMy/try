<?php
	header('Content-Type: application/json');
	session_start();
    require_once ('config.php');
    $data = array();
    $data2 = array();
    $data3 = array();

    $responce = array();
    $message = "";
    
    if(!empty($_REQUEST['quot_id'])){

      $quot_id = $_REQUEST['quot_id'];

    }else if(!empty($_REQUEST['wo_id'])){
      
      $wo_header_id = $_REQUEST['wo_id'];

      $qheader_query = "SELECT work_order_header.quotation_id FROM work_order_header WHERE id = '$wo_header_id';";
      $qheader_sql = mysqli_query($con_main,$qheader_query);
      $header_res = mysqli_fetch_assoc($qheader_sql);
      $quot_id = $header_res['quotation_id']; 

    }else if(!empty($_REQUEST['disp_id'])){
      
       $disp_id = $_REQUEST['disp_id'];

      $qu = "SELECT
                work_order_header.quotation_id
            FROM
                final_disp_header
            INNER JOIN disp_header ON final_disp_header.disp_auth = disp_header.id
            INNER JOIN work_order_header ON disp_header.work_header = work_order_header.id
            WHERE
                final_disp_header.id = '$disp_id'";
     
      $sq = mysqli_query($con_main,$qu);
      $rw = mysqli_fetch_assoc($sq);
      $quot_id = $rw['quotation_id'];

    }else if(!empty($_REQUEST['inv_id'])){
       
        $inv_id = $_REQUEST['inv_id'];

        $qu1 = "SELECT mas_invoice_header.reference,mas_invoice_header.reference_no FROM mas_invoice_header WHERE mas_invoice_header.id = '$inv_id';";
        $sq1 = mysqli_query($con_main,$qu1);
        $rs1 = mysqli_fetch_assoc($sq1);

        if($rs1['reference'] == "quotation"){
            
            $quot_id = $rs1['reference_no'];

        }else{
            
            $ref_id = $rs1['reference_no'];
            $qu2 = "SELECT
                        work_order_header.quotation_id
                    FROM
                        final_disp_header
                    INNER JOIN disp_header ON final_disp_header.disp_auth = disp_header.id
                    INNER JOIN work_order_header ON disp_header.work_header = work_order_header.id
                    WHERE
                        final_disp_header.id = '$ref_id'";
     
             $sq2 = mysqli_query($con_main,$qu2);
             $rw2 = mysqli_fetch_assoc($sq2);
             $quot_id = $rw2['quotation_id'];
        }
    }
 
    $query1 = "SELECT
                    DATE(quotation_header.approved_date) AS DATE_ONLY,
                    work_order_header.id,
                    work_order_header.work_order_no,
                    DATE(work_order_header.entered_date) AS DATE_ONLY2,
                    mas_customer.CustomerName,
                    quotation_header.quotation_no
                FROM
                    quotation_header
                INNER JOIN work_order_header ON quotation_header.id = work_order_header.quotation_id
                INNER JOIN mas_customer ON quotation_header.customer_id = mas_customer.ID
                WHERE quotation_header.id = '$quot_id'";
        
        $sql = mysqli_query($con_main,$query1);
        $res = mysqli_fetch_assoc($sql);

        $approved_date = $res['DATE_ONLY'];
        $work_order_Date = $res['DATE_ONLY2'];
        $customer = $res['CustomerName'];

        $responce['approved_date'] = $approved_date;
        $responce['workorder_date'] = $work_order_Date; 
        $responce['customer_name'] = $customer;
        $responce['wo_no'] = $res['work_order_no'];
        $responce['quot_no'] = $res['quotation_no'];

     $query2 = "SELECT
                    final_disp_header.disp,
                    final_disp_header.date
                FROM
                    quotation_header
                INNER JOIN work_order_header ON quotation_header.id = work_order_header.quotation_id
                INNER JOIN disp_header ON work_order_header.id = disp_header.work_header
                INNER JOIN final_disp_header ON disp_header.id = final_disp_header.disp_auth
                WHERE quotation_header.id = '$quot_id'";

     $sql2 = mysqli_query($con_main,$query2);
     $num_rows1 = mysqli_num_rows($sql2);
     $i = 0;
     if($num_rows1>0){
        while($res2 = mysqli_fetch_assoc($sql2)){
             $data[$i] = $res2;
             $i++;   
        }  
     }
     $responce['data'] = $data;

    $query3 = "SELECT
                    mas_invoice_header.invoice_no,
                    mas_invoice_header.invoice_date
                FROM
                    mas_invoice_header
                WHERE
                    mas_invoice_header.reference = 'quotation'
                AND mas_invoice_header.reference_no = '$quot_id'
                AND mas_invoice_header.status = '1'";

        $sql3 = mysqli_query($con_main,$query3);
        $num_rows2 = mysqli_num_rows($sql3);
        $y = 0;
        if($num_rows2>0){
             while($res3 = mysqli_fetch_assoc($sql3)){
                 $data2[$y] = $res3;
                 $y++;  
             }
        }

    $query4 = "SELECT
                    mas_invoice_header.invoice_no,
                    mas_invoice_header.invoice_date
                FROM
                    mas_invoice_header
                INNER JOIN final_disp_header ON mas_invoice_header.reference_no = final_disp_header.id
                INNER JOIN disp_header ON final_disp_header.disp_auth = disp_header.id
                INNER JOIN work_order_header ON disp_header.work_header = work_order_header.id
                WHERE
                    mas_invoice_header.reference = 'dispatch'
                AND work_order_header.quotation_id = '$quot_id'";

         $sql4 = mysqli_query($con_main,$query4);
         $num_rows3 = mysqli_num_rows($sql4);
         if($num_rows3>0){
             while($res4 = mysqli_fetch_assoc($sql4)){
                 $data2[$y] = $res4;
                 $y++;  
             }
         }
    
    $responce['data2'] = $data2;

    $query5 = "SELECT
                    quotation_payments_header.receipt_no,
                    quotation_payments_header.receipt_date
                FROM
                    quotation_payments_detail
                INNER JOIN quotation_payments_header ON quotation_payments_detail.header_id = quotation_payments_header.id
                INNER JOIN quotation_header ON quotation_payments_detail.reference_no = quotation_header.quotation_no
                WHERE
                    quotation_payments_detail.payment_for = 'Quotation'
                AND quotation_header.id = '$quot_id'
                GROUP BY
                    quotation_payments_detail.reference_no";

    $sql5 = mysqli_query($con_main,$query5);
    $num_rows4 = mysqli_num_rows($sql5);
    $k = 0;
    if($num_rows4>0){
         while($res5 = mysqli_fetch_assoc($sql5)){
             $data3[$k] = $res5;
             $k++;  
         }
    }
    
    $responce['data3'] = $data3;

    echo(json_encode($responce));  
?>    