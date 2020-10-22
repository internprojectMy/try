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
        <i class="gi gi-podium"></i>Order Track<br><small></small>
      </h1>
    </div>
   </div>
   <ul class="breadcrumb breadcrumb-top">
     <li><a href="../home.php">Home</a></li>
     <li>Order Track</li>
   </ul>
   
   <div class="row">
    <div class="col-md-12">
      <div class="block">
        <div class="block-title">
				 <h2>Order Track</h2>
			  </div>
       <form id="form-main" name="form-main" action="settlement_summary.php" method="post"  class="form-horizontal form-bordered">
        <div class="form-group">
           <label class="col-md-2 control-label" for="cus_type">Select Customer</label>    
             <div class="col-md-3"> 

            <select id="cus_type" name="cus_type" class="select-chosen" data-placeholder="Select customer">
              <!-- <option selected disabled>Select customer</option> -->
              <option value="All">All</option>
              <?php
                $query="SELECT mas_customer.CustomerName,mas_customer.ID FROM mas_customer";
                $sql = mysqli_query($con_main, $query);                           
                while ($type = mysqli_fetch_array($sql)){
                    echo ("<option value=\"".$type['ID']."\">"."  ".$type['CustomerName']."</option>");
                }
              ?>
            </select>
          </div>

          <div class="col-md-2">
            <input type="radio" name="r_button" id="quotation" value="quotation"> <label for="quotation">Quotation</label>
          </div>

          <div class="col-md-2">
           <input type="radio" name="r_button" id="work_order" value="work_order"> <label for="work_order">Work Order</label>
          </div>  

          <div class="col-md-2">
            <select id="ref_no" name="ref_no" class="select-chosen" data-placeholder="">
            </select>
          </div>     
        </div>   
          <div class="form-group form-actions">
           <input type="hidden" name="id" id="id" value="0"/>
          <div class="col-md-12">
            <button type="submit" class="btn btn-success primary-btn pull-right" id="detail_submit" =""><i class="fa-file-excel-o"></i> Report</button>
            <button type="reset" class="btn btn-warning"><i class="fa fa-repeat"></i> Reset</button>
            <marquee><b><font color="blue"> Order Track Report.<b> </marquee>
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

$('#form-main').on('reset', function (e){
    $('#id').val("0");
    $('#status').val("1");
    $('#status').trigger("chosen:updated");
    $('#countrycode').val("");
    $('#countryname').val("");
    $('#currencycode').val("");
    $('#currencyname').val("");
});


$('#cus_type').on('change',function(){
  $('#quotation').prop('checked',false);
  $('#work_order').prop('checked',false);
});

$('input[type=radio][name=r_button]').change(function() {
    if (this.value == 'quotation') {
      var a = $('#quotation').val();
      var cus = $('#cus_type').val();
      $.ajax({
          url: 'data_details.php',
          data: {
              type : a,
              customer : cus
          },
          method: 'post',
          error: function(e){
              alert ('Error requesting provider data');
          },
          success: function(r){
             
              $('#ref_no').html('<option value=""></option>');

              if (r.result){
                  if (r.data.length > 0){
                      $.each(r.data, function (k, v){
                          let option_markup = "";

                          option_markup += "<option value='"+v.id+"'>";
                          option_markup += v.quotation_no;
                          option_markup += "</option>";

                          $('#ref_no').append(option_markup)
                      });
                  }
               }
              $('#ref_no').trigger("chosen:updated");
            
          }
      }); 
    }
    else if (this.value == 'work_order') {
      var b = $('#work_order').val();
      var cus = $('#cus_type').val();
       $.ajax({
          url: 'data_details.php',
          data: {
              type : b,
               customer : cus
          },
          method: 'post',
          error: function(e){
              alert ('Error requesting provider data');
          },
          success: function(r){
             
              $('#ref_no').html('<option value=""></option>');

              if (r.result){
                  if (r.data.length > 0){
                      $.each(r.data, function (k, v){
                          let option_markup = "";

                          option_markup += "<option value='"+v.id+"'>";
                          option_markup += v.work_order_no;
                          option_markup += "</option>";

                          $('#ref_no').append(option_markup)
                      });
                  }
               }
              $('#ref_no').trigger("chosen:updated");
            
          }
      });
    }
});


</script>
<?php mysqli_close($con_main); ?>