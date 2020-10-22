
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
        <i class="gi gi-podium"></i>Quotation Report<br><small></small>
      </h1>
    </div>
   </div>
   <ul class="breadcrumb breadcrumb-top">
     <li><a href="../home.php">Home</a></li>
     <li>Quotation Report</li>
   </ul>
   
   <div class="row">
    <div class="col-md-12">
      <div class="block">
        <div class="block-title">
				  <h2>Quotation Summary Report</h2>
			  </div>
        <form id="form-main" name="form-main" action="excel_quotation.php" method="post"  class="form-horizontal form-bordered">
          <div class="form-group">
            <label class="col-md-2 control-label" for="from_date">From Date</label>
             <div class="col-md-4">                         
               <input type="text" name="from" id="from" class="form-control input input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd">
             </div> 

             <label class="col-md-2 control-label" for="to_date">To Date</label>
             <div class="col-md-4">                         
               <input type="text" name="to" id="to" class="form-control input input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd">
             </div> 
          </div>
          <div class="form-group">
            <label class="col-md-2 control-label" for="cus_type">Customer</label>
             <div class="col-md-3">                         
                <select id="cus_type" name="cus_type" class="select-chosen" data-placeholder="Select Main Category">
                  <option value="All" selected>All</option>
                    <?php
                    $query="SELECT
                     mas_customer.id,
                     mas_customer.CustomerName
                     FROM mas_customer";
                     $sql = mysqli_query($con_main, $query);                                       
                     while ($type = mysqli_fetch_array($sql)){
                     echo ("<option value=\"".$type['id']."\">".$type['CustomerName']."</option>");
                     }
                    ?>
                </select>
             </div> 

          <label class="col-md-3 control-label" for="sales_person">Salesman</label>        
           <div class="col-md-3">                         
            <select id="sales_person" name="sales_person" class="select-chosen" data-placeholder>
              <option value="All" selected>All</option>
              <?php
                $query="SELECT
                        mas_employee.first_name,
                        mas_employee.last_name,
                        mas_employee.id
                        FROM
                        mas_employee ORDER BY first_name,last_name ASC";
                $sql = mysqli_query($con_main, $query);
                                                        
                while ($type = mysqli_fetch_array($sql)){
                    echo ("<option value=\"".$type['id']."\">".$type['first_name']. " "  .$type['last_name']);
                }
              ?>
            </select>
           </div>
       </div>

             



          <div class="form-group">
            <label class="col-md-2 control-label" for="fg_cat">FG Category</label>        
              <div class="col-md-2">                         
                <select id="fg_cat" name="fg_cat" class="select-chosen" data-placeholder>
                  <option value="All" selected>All</option>
                  <?php
                    $query="SELECT
                            finish_good_items.finish_good_type,
                            finish_good_items.id
                            FROM
                            finish_good_items";
                    $sql = mysqli_query($con_main, $query);
                                                            
                    while ($type = mysqli_fetch_array($sql)){
                        echo ("<option value=\"".$type['id']."\">".$type['finish_good_type']);
                    }
                  ?>  
                
            
           </select>
           </div>


            <label class="col-md-4 control-label" for="job_tp">Job Type</label>        
            <div class="col-md-4">                         
              <select id="job_tp" name="job_tp" class="select-chosen" data-placeholder>
                <option value="All" selecte>All</option>
                <?php
                  $query="SELECT
                          mas_job_type.id,
                          mas_job_type.job_type
                          FROM
                          mas_job_type";
                          

                  $sql = mysqli_query($con_main, $query);
                                                          
                  while ($type = mysqli_fetch_array($sql)){
                      echo ("<option value=\"".$type['id']."\">".$type['job_type']);
                  }
                ?>
             </select>
            </div>
          </div>
          

             <div class="form-group"> 

             <label class="col-md-2 control-label" for="fg_item">FG Item</label>        
           <div class="col-md-4">                         
            <select id="fg_item" name="fg_item" class="select-chosen" data-placeholder>
              <option value="All" selected>All</option> 
              <?php
                $query="SELECT
                        mas_finish_good.id,
                        mas_finish_good.item_description
                        FROM
                        mas_finish_good";
                                            
                $sql = mysqli_query($con_main, $query);
                                                        
                while ($type = mysqli_fetch_array($sql)){
                    echo ("<option value=\"".$type['id']."\">".$type['item_description']);
                }
              ?>
             </select>
          
           </div>
        

        
           <label class="col-md-2 control-label" for="quot_status">Quotation Status</label>        
           <div class="col-md-2">                         
            <select id="quot_status" name="quot_status" class="select-chosen" data-placeholder>
              <option value="All" selected>All (Except Void)</option>
              <option value="APPROVED">Approved</option>
              <option value="CONFIRMED">Confirmed</option>
              <option value="DRAFT">Draft</option>
              <option value="Void">Void</option>
            </select>
           </div>
          </div>

         
          <div class="form-group"> 
           <label class="col-md-2 control-label" for="order_tp">Order Type</label>        
              <div class="col-md-2">                         
                <select id="order_tp" name="order_tp" class="select-chosen" data-placeholder>
                  <option value="All" selected>All</option>
                    <?php
                      $query="SELECT
                              project_type.id,
                              project_type.project_type
                              FROM
                              project_type";
                      $sql = mysqli_query($con_main, $query);
                                                              
                      while ($type = mysqli_fetch_array($sql)){
                          echo ("<option value=\"".$type['id']."\">".$type['project_type']); 
                      }
                    ?>       
                </select>
              </div></div>

       
            
         

          <div class="form-group form-actions">
           <input type="hidden" name="id" id="id" value="0"/>
          <div class="col-md-12">
            <button type="submit" class="btn btn-success primary-btn pull-right" id="detail_submit" =""><i class="fa-file-excel-o"></i> Report</button>
            <button type="reset" class="btn btn-warning"><i class="fa fa-repeat"></i> Reset</button>
            <marquee><b><font color="blue"> Quotation Report.<b> </marquee>
           
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




  