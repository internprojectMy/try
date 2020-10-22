<?php
header('Content-Type: application/json');

include ('../config.php');

$where = "";
$responce = array();
$data = array();
$result = true;
$message = "";
$no_of_copies = 0;

$customerid = (isset($_REQUEST['customerid']) && $_REQUEST['customerid'] != NULL && !empty($_REQUEST['customerid'])) ? $_REQUEST['customerid'] : 0;

$customerauthid = (isset($_REQUEST['customerauthid']) && $_REQUEST['customerauthid'] != NULL && !empty($_REQUEST['customerauthid'])) ? $_REQUEST['customerauthid'] : 0;

$id = (isset($_REQUEST['id']) && $_REQUEST['id'] != NULL && !empty($_REQUEST['id'])) ? $_REQUEST['id'] : 0;
$type =  (isset($_REQUEST['type']) && $_REQUEST['type'] != NULL && !empty($_REQUEST['type'])) ? $_REQUEST['type'] : 0;





if($customerid>0){
   
   $data3 = "";
   $query3 = 

              "SELECT customer_return_auth.cus_id, customer_return_auth.cr_auth
              FROM customer_return_auth
              
              WHERE customer_return_auth.cus_id = '$customerid'";

    $sql3 = mysqli_query($con_main,$query3);
    $num_rows3 = mysqli_num_rows($sql3);
    if ($num_rows3 > 0){
     $i = 0;
    while ($rows = mysqli_fetch_assoc ($sql3)){
        $data3[$i] = $rows;
        $i++;
     
     }
    }
} 

if(!empty($customerauthid)){
   
   $data4 = "";
   $query4 = "SELECT quotation_header.id, quotation_header.quotation_no, quotation_header.quotation_date
FROM quotation_header
WHERE quotation_header.id = (SELECT customer_return_auth.qid
FROM customer_return_auth
WHERE customer_return_auth.cr_auth = '$customerauthid')";
$sql4 = mysqli_query($con_main,$query4);
$res4 = mysqli_fetch_assoc($sql4);
$responce['quotation_no'] = $res4['quotation_no'];
$responce['quotation_date'] = $res4['quotation_date'];
$responce['quotation_id'] = $res4['id'];

$data5 = "";
   $query5 = "SELECT customer_return_auth.qtbr
  FROM customer_return_auth
  WHERE customer_return_auth.cr_auth = '$customerauthid'";
  $sql5 = mysqli_query($con_main,$query5);
  $res5 = mysqli_fetch_assoc($sql5);
  $responce['qtbr'] = $res5['qtbr'];

}



if($type==1){

$query21= "SELECT
customer_return_auth.qtbr
FROM `customer_return_auth`
WHERE
customer_return_auth.cr_auth='CRA-001'";

$sql4 = mysqli_query($con_main,$query21);

}


if($id>0){
  
   $query = "SELECT
              mas_quotation.length,
              mas_quotation.width,
              mas_quotation.glass_mark,
              mas_finish_good.item_description,
              mas_job_type.job_type,
              service_items.quantity AS WO_QTY,
              service_items.id,
              work_order_header.work_order_no,
              customer_return_auth.won_id,
              customer_return_auth.qtbr,
              customer_return_auth.cr_auth,
              quotation_header.project_reference
            FROM
              quotation_header
            LEFT JOIN mas_quotation ON quotation_header.id = mas_quotation.quotation_header_id
            LEFT JOIN mas_finish_good ON mas_quotation.fg_item_id = mas_finish_good.id
            LEFT JOIN mas_job_type ON mas_quotation.job_type_id = mas_job_type.id
            LEFT JOIN service_items ON mas_quotation.id = service_items.item_id
            LEFT JOIN work_order_header ON quotation_header.id = work_order_header.quotation_id
            -- LEFT JOIN customer_return_auth ON customer_return_auth.won_id = work_order_header.work_order_no
            LEFT JOIN customer_return_auth ON customer_return_auth.cus_id = quotation_header.id
            WHERE
              quotation_header.id = '$id'";

  $sql = mysqli_query($con_main,$query);
  $y = 0;
  while($res = mysqli_fetch_assoc($sql)){
       
       $serv_id = $res['id'];

       $disp_query = "SELECT
                        SUM(disp_final.disp_qty) AS TOTAL_DISPATCHED
                      FROM
                        dispatch
                      INNER JOIN disp_final ON dispatch.id = disp_final.item_id
                      WHERE
                        dispatch.Item_id = '$serv_id'";

       $disp_sql = mysqli_query($con_main,$disp_query);
       $disp_res = mysqli_fetch_assoc($disp_sql);

       $qm_disp_qty = ($disp_res['TOTAL_DISPATCHED'] == null) ? "0" : $disp_res['TOTAL_DISPATCHED'];
       $data[$y] = $res;
       $data[$y] = array_push_assoc($data[$y],'dispatch_qty',$qm_disp_qty);
       $y++;  

  }
}

 while ($rows = mysqli_fetch_assoc ($sql1)){
 $query1= "SELECT
          quotation_header.quotation_no,
          work_order_header.work_order_no,
          customer_return_auth.cr_auth
          FROM
          quotation_header
          INNER JOIN work_order_header ON quotation_header.id = work_order_header.quotation_id
          INNER JOIN customer_return_auth ON customer_return_auth.qid = quotation_header.id
          WHERE
          work_order_header.quotation_id";
          $sql1 = mysqli_query($con_main,$query1);}

function array_push_assoc($array, $key, $value){
    $array[$key] = $value;
    return $array;
}

$responce['data3'] = $data3;

$responce['data'] = $data;

echo(json_encode($responce));

mysqli_close($con_main);
?>