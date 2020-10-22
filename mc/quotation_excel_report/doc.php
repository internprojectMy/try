
<?php
  session_start();
  if (empty($_SESSION['ACCESS_CODE']) || $_SESSION['ACCESS_CODE'] == NULL){
    header ('Location: login.php');
    exit;
  }
  $folder_depth = "";
  $prefix = "";
  $folder_depth = substr_count($_SERVER["PHP_SELF"] , "/");
  $folder_depth = ($folder_depth == false) ? 2 : (int)$folder_depth;
  $prefix = str_repeat("../", $folder_depth - 2);  
  $title_suffix = "Reports Master";
?>
<?php include $prefix.'config.php'; ?>
<?php include $prefix.'menu.php'; ?>
<?php include $prefix.'template_start.php'; ?>
<?php include $prefix.'page_head.php'; ?>

<div id="page-content">
  <div class="content-header">
    <div class="header-section">
      <h1>
        <i class="gi gi-podium"></i>Document Quick Search<br><small></small>
      </h1>
    </div>
   </div>
   <ul class="breadcrumb breadcrumb-top">
     <li><a href="../home.php">Home</a></li>
     <li>Document Quick Search</li>
   </ul>
   
   <div class="row">
    <div class="col-md-12">
      <div class="block">
        <div class="block-title">
          <h2>Document Quick Search</h2>
        </div>
        <form id="form-main" name="form-main" action="excel_quotation.php" method="post"  class="form-horizontal form-bordered">
          <div class="form-group">          
            <div class="col-md-3">    
                <select id="quot_id" name="quot_id"  class="select-chosen" data-placeholder="Select Quotation">
                  <option></option>
                   <?php 
                 $query="SELECT
                            quotation_header.id,
                            quotation_header.quotation_no,
                            quotation_header.is_work_order_issued,
                            quotation_header.status,
                            mas_customer.CustomerName
                        FROM
                            quotation_header
                        INNER JOIN mas_customer ON quotation_header.customer_id = mas_customer.ID
                        WHERE
                            quotation_header.status = 'CONFIRMED' 
                        ORDER BY quotation_header.id DESC";
                $sql = mysqli_query($con_main, $query);
                                                        
                 while ($type = mysqli_fetch_array($sql)){
                      echo ("<option value=\"".$type['id']."\">" .$type['quotation_no']." - ".$type['status']."</option>");
                  }
                  ?>

                </select>
                <span class="help-block">Quotation No</span>
                 <span id="cn"></span>
              
             </div>

             
            <div class="col-md-3">                  
                <select id="wo_id" name="wo_id"  class="select-chosen" data-placeholder="Select Workorder" > 

                  <option></option>
                    <?php 
                 $query = "SELECT
                work_order_header.id,
                work_order_header.work_order_no,
                quotation_header.quotation_no
              FROM
                work_order_header
              INNER JOIN quotation_header ON work_order_header.quotation_id = quotation_header.id
              ORDER BY work_order_header.id DESC";

         $sql = mysqli_query($con_main,$query);
         while($res = mysqli_fetch_assoc($sql)){
                 echo('<option value='.$res['id'].'>'.$res['work_order_no'].'</option>');
         }
                ?>

                </select>
                <span class="help-block">Workorder No</span>
                 <span id="wo"></span>
                     
            </div>
          <!-- </div>
            <div class="form-group"> -->
           
            <div class="col-md-3">                  
                <select id="disp_id" name="disp_id"  class="select-chosen" data-placeholder="Select Dispatch" > 

                  <option></option>
                   <?php 
                 $query="SELECT
                            final_disp_header.id,
                            final_disp_header.disp
                          FROM
                            final_disp_header
                          ORDER BY
                            final_disp_header.disp DESC";
                $sql = mysqli_query($con_main, $query);
                                                        
                 while ($type = mysqli_fetch_array($sql)){
                      echo ("<option value=\"".$type['id']."\">" .$type['disp']."</option>");
                  }?>
                </select>
                <span class="help-block">Dispatch No</span>
                 <span id="cn"></span>
             </div>

            <div class="col-md-3">                  
                <select id="inv_id" name="inv_id"  class="select-chosen" data-placeholder="Select Invoice" > 

                  <option></option>
                   <?php 
                 $query="SELECT
                        mas_invoice_header.invoice_no,
                        mas_invoice_header.id
                        FROM
                        mas_invoice_header
                        ORDER BY invoice_no DESC";
                $sql = mysqli_query($con_main, $query);
                                                        
                 while ($type = mysqli_fetch_array($sql)){
                      echo ("<option value=\"".$type['id']."\">" .$type['invoice_no']."</option>");
                  }?>
                </select>
                <span class="help-block">Invoice No</span>
                 <span id="cn"></span>

               </div>
             </div>


                <div class="form-group">
                        <div class="col-md-4">
                            <input type="text" id="customer_name"  class="form-control" readonly>
                            <span class="help-block">Customer Name</span>
                        </div>

                        <div class="col-md-4">
                            <input type="text" id="quot_date"  class="form-control" readonly>
                            <span class="help-block">Quotation No / Date</span>
                        </div>  
                     
                        <div class="col-md-4">
                            <input type="text" id="wo_date"  class="form-control" readonly>
                            <span class="help-block">Workorder No / Date</span>
                        </div>
                    </div>
        </form>
       </div> 

    <div class="block">
        <div class="block-title"><h2><strong>Fully Detailed</strong></h2></div>
        <div class="row">
            <div class="col-sm-4">
                <div class="block">
                    <div class="table-responsive">
                       <table class="table table-vcenter table-striped">
                         <thead>
                          <tr>
                              <th style="font-size: 15px;">Invoice No</th>
                              <th style="font-size: 15px;">Inv.Date</th>
                          </tr>
                         </thead>
                         <tbody id="invoice_items"></tbody>
                       </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="block">
                    <div class="table-responsive">
                       <table class="table table-vcenter table-striped">
                         <thead>
                          <tr>
                              <th style="font-size: 15px;">Dispatch No</th>
                              <th style="font-size: 15px;">Dis.Date</th>
                          </tr>
                         </thead>
                         <tbody id="disp_items"></tbody>
                       </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="block">
                    <div class="table-responsive">
                       <table class="table table-vcenter table-striped">
                         <thead>
                          <tr>
                              <th style="font-size: 15px;">Receipt No</th>
                              <th style="font-size: 15px;">Receipt.Date</th>
                          </tr>
                         </thead>
                         <tbody id="receipts_items"></tbody>
                       </table>
                    </div>
                </div>
            </div>
        </div>
    </div>   
     </div>
   </div>
 </div>

<?php include $prefix.'page_footer.php'; ?>
<?php include $prefix.'template_scripts.php'; ?>
<?php include $prefix.'template_end.php'; ?>

<script type="text/javascript">

$('#quot_id').on('change',function(){

  $('#invoice_items').html('');
  $('#disp_items').html('');
  $('#receipts_items').html('');
  $('#customer_name').val('');
  $('#quot_date').val('');
  $('#wo_date').val('');

   var quot_id = $('#quot_id').val();
   $.ajax({
      url:'details_from_quotation.php',
      data:{
          quot_id:quot_id
      },
      method:'post',
      error:function(r){
      },
      success:function(r){
        let row = "";
        let row2 = "";
        let row3 = "";

         $('#customer_name').val(r.customer_name);
         $('#quot_date').val(r.quot_no+' / '+r.approved_date);
         $('#wo_date').val(r.wo_no+' / '+r.workorder_date);
         
         if(r.data.length > 0){
           $.each(r.data,(idx,data)=>{  
              row += '<tr><td>'+data.disp+'</td><td>'+data.date+'</td></tr>';
           }); 
         }else{
              row += '<tr><td colspan="2" class="text-center">No Dispatches</td></tr>';
         }
         $('#disp_items').append(row);

         if(r.data2.length > 0){
           $.each(r.data2,(idx,dt)=>{  
            row2 += '<tr><td>'+dt.invoice_no+'</td><td>'+dt.invoice_date+'</td></tr>';
           });
         }else{
            row2 += '<tr><td colspan="2" class="text-center">No Invoices</td></tr>';
         }
         $('#invoice_items').append(row2);

         if(r.data3.length > 0){
           $.each(r.data3,(idx,dti)=>{  
            row3 += '<tr><td>'+dti.receipt_no+'</td><td>'+dti.receipt_date+'</td></tr>';
           });
         }else{
            row3 += '<tr><td colspan="2" class="text-center">No Receipts</td></tr>';
         }
         $('#receipts_items').append(row3);
      }
   });
});

$('#wo_id').on('change',function(){

  $('#invoice_items').html('');
  $('#disp_items').html('');
  $('#receipts_items').html('');
  $('#customer_name').val('');
  $('#quot_date').val('');
  $('#wo_date').val('');

   var wo_id = $('#wo_id').val();
   $.ajax({
      url:'details_from_quotation.php',
      data:{
          wo_id:wo_id
      },
      method:'post',
      error:function(r){
      },
      success:function(r){
        let row = "";
        let row2 = "";
        let row3 = "";

         $('#customer_name').val(r.customer_name);
         $('#quot_date').val(r.quot_no+' / '+r.approved_date);
         $('#wo_date').val(r.wo_no+' / '+r.workorder_date);
         
         if(r.data.length > 0){
           $.each(r.data,(idx,data)=>{  
              row += '<tr><td>'+data.disp+'</td><td>'+data.date+'</td></tr>';
           }); 
         }else{
              row += '<tr><td colspan="2" class="text-center">No Dispatches</td></tr>';
         }
         $('#disp_items').append(row);

         if(r.data2.length > 0){
           $.each(r.data2,(idx,dt)=>{  
            row2 += '<tr><td>'+dt.invoice_no+'</td><td>'+dt.invoice_date+'</td></tr>';
           });
         }else{
            row2 += '<tr><td colspan="2" class="text-center">No Invoices</td></tr>';
         }
         $('#invoice_items').append(row2);

         if(r.data3.length > 0){
           $.each(r.data3,(idx,dti)=>{  
            row3 += '<tr><td>'+dti.receipt_no+'</td><td>'+dti.receipt_date+'</td></tr>';
           });
         }else{
            row3 += '<tr><td colspan="2" class="text-center">No Receipts</td></tr>';
         }
         $('#receipts_items').append(row3);
      }
   });
});

$('#disp_id').on('change',function(){

  $('#invoice_items').html('');
  $('#disp_items').html('');
  $('#receipts_items').html('');
  $('#customer_name').val('');
  $('#quot_date').val('');
  $('#wo_date').val('');

   var disp_id = $('#disp_id').val();
   $.ajax({
      url:'details_from_quotation.php',
      data:{
          disp_id:disp_id
      },
      method:'post',
      error:function(r){
      },
      success:function(r){
        let row = "";
        let row2 = "";
        let row3 = "";

         $('#customer_name').val(r.customer_name);
         $('#quot_date').val(r.quot_no+' / '+r.approved_date);
         $('#wo_date').val(r.wo_no+' / '+r.workorder_date);
         
         if(r.data.length > 0){
           $.each(r.data,(idx,data)=>{  
              row += '<tr><td>'+data.disp+'</td><td>'+data.date+'</td></tr>';
           }); 
         }else{
              row += '<tr><td colspan="2" class="text-center">No Dispatches</td></tr>';
         }
         $('#disp_items').append(row);

         if(r.data2.length > 0){
           $.each(r.data2,(idx,dt)=>{  
            row2 += '<tr><td>'+dt.invoice_no+'</td><td>'+dt.invoice_date+'</td></tr>';
           });
         }else{
            row2 += '<tr><td colspan="2" class="text-center">No Invoices</td></tr>';
         }
         $('#invoice_items').append(row2);

         if(r.data3.length > 0){
           $.each(r.data3,(idx,dti)=>{  
            row3 += '<tr><td>'+dti.receipt_no+'</td><td>'+dti.receipt_date+'</td></tr>';
           });
         }else{
            row3 += '<tr><td colspan="2" class="text-center">No Receipts</td></tr>';
         }
         $('#receipts_items').append(row3);
      }
   });
});

$('#inv_id').on('change',function(){

  $('#invoice_items').html('');
  $('#disp_items').html('');
  $('#receipts_items').html('');
  $('#customer_name').val('');
  $('#quot_date').val('');
  $('#wo_date').val('');

   var inv_id = $('#inv_id').val();
   $.ajax({
      url:'details_from_quotation.php',
      data:{
          inv_id:inv_id
      },
      method:'post',
      error:function(r){
      },
      success:function(r){
        let row = "";
        let row2 = "";
        let row3 = "";

         $('#customer_name').val(r.customer_name);
         $('#quot_date').val(r.quot_no+' / '+r.approved_date);
         $('#wo_date').val(r.wo_no+' / '+r.workorder_date);
         
         if(r.data.length > 0){
           $.each(r.data,(idx,data)=>{  
              row += '<tr><td>'+data.disp+'</td><td>'+data.date+'</td></tr>';
           }); 
         }else{
              row += '<tr><td colspan="2" class="text-center">No Dispatches</td></tr>';
         }
         $('#disp_items').append(row);

         if(r.data2.length > 0){
           $.each(r.data2,(idx,dt)=>{  
            row2 += '<tr><td>'+dt.invoice_no+'</td><td>'+dt.invoice_date+'</td></tr>';
           });
         }else{
            row2 += '<tr><td colspan="2" class="text-center">No Invoices</td></tr>';
         }
         $('#invoice_items').append(row2);

         if(r.data3.length > 0){
           $.each(r.data3,(idx,dti)=>{  
            row3 += '<tr><td>'+dti.receipt_no+'</td><td>'+dti.receipt_date+'</td></tr>';
           });
         }else{
            row3 += '<tr><td colspan="2" class="text-center">No Receipts</td></tr>';
         }
         $('#receipts_items').append(row3);
      }
   });
});

$('#form-main').on('reset', function (e){
    $('#id').val("0");
    $('#quot_status').val("1");
    $('#quot_status').trigger("chosen:updated");
    $('#countrycode').val("");
    $('#countryname').val("");
    $('#currencycode').val("");
    $('#currencyname').val("");
});
</script>
<?php mysqli_close($con_main); ?>




  