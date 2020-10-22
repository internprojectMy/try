
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
        <i class="gi gi-podium"></i>Transaction Listing<br><small></small>
      </h1>
    </div>
   </div>
   <ul class="breadcrumb breadcrumb-top">
     <li><a href="../home.php">Home</a></li>
     <li>Transaction Listing</li>
   </ul>
   
   <div class="row">
    <div class="col-md-12">
      <div class="block">
        <div class="block-title">
          <h2>Transaction Listing</h2>
        </div>
        <form id="form-main" name="form-main" action="opdf.php" method="post"  class="form-horizontal form-bordered">
          <div class="form-group">
            <label class="col-md-2 control-label" for="cus_type">Select Type</label>
             <div class="col-md-3">                         
                <select id="quot" name="quot" class="select-chosen" data-placeholder="Select Main Category">
                  
                  <option value="wo_status" Selected>Work Order(Based on released date)</option>
                  <option value="qstatus">Quotation</option>
                  <option value="invoice">Invoice</option>
                  <option value="disp">Dispatch</option>
                      </select>
             </div> 

            <label class="col-md-1 control-label" for="from_date">From Date</label>
             <div class="col-md-2">                         
               <input type="text" name="from" id="from" class="form-control input input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" required="" >
             </div> 

             <label class="col-md-1 control-label" for="to_date" required="">To Date</label>
             <div class="col-md-2">                         
               <input type="text" name="to" id="to" class="form-control input input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" required="">
             </div> </div>
          <div class="form-group form-actions">
           <input type="hidden" name="id" id="id" value="0"/>
          <div class="col-md-12">
            <button type="submit" class="btn btn-success primary-btn pull-right" id="detail_submit" =""><i class="fa-file-excel-o"></i> Report</button>
            <button type="reset" class="btn btn-warning"><i class="fa fa-repeat"></i> Reset</button>
          </div>
         </div>
        </form>
       </div>      
     </div>
   </div>
 </div>

<?php include $prefix.'page_footer.php'; ?>
<?php include $prefix.'template_scripts.php'; ?>
<?php include $prefix.'template_end.php'; ?>

<script type="text/javascript">

 $('#form-main').on('submit',function(e){
   e.preventDefault();
   var from = $('#from').val();
   var to = $('#to').val();
   if($('#quot').val() == "wo_status"){
    window.open("opdf.php?from="+from+"&to="+to);
   }else if($('#quot').val() == "qstatus"){
    window.open("opdf.php?from="+from+"&to="+to);
   }else if($('#quot').val() == "invoice"){
     window.open("opdf.php?from="+from+"&to="+to);
   }else if($('#quot').val() == "disp"){
     window.open("dispdf.php?from="+from+"&to="+to);
   }
 });                  
  
/*********** Form Validation and Submission ***********/
// $('#form-main').on('submit', function (e){
//  e.preventDefault();
//  var formdata = $(this).serialize();
//     window.open("excel_mobile_details.php?"+form_data,"_self");
// });

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




  