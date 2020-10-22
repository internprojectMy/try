<?php
header('Content-Type: application/json');

include ('../config.php');

$where = "";
$responce = array();
$data = array();
$result = true;
$message = "";

$qno = (isset($_REQUEST['qno']) && $_REQUEST['qno'] != NULL && !empty($_REQUEST['qno'])) ? $_REQUEST['qno'] : 0;

if($qno >0){
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
              quotation_header.id = '$qno'";

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
$responce['data'] = $data;

echo(json_encode($responce));

mysqli_close($con_main);
?>