<?php
	session_start();
	
	if (empty($_SESSION['ACCESS_CODE']) || $_SESSION['ACCESS_CODE'] == NULL){
		header ('Location: login.php');
		exit;
	}

	$user_code = $_SESSION['USER_CODE'];
	
	$folder_depth = "";
	$prefix = "";
	
	$folder_depth = substr_count($_SERVER["PHP_SELF"] , "/");
	$folder_depth = ($folder_depth == false) ? 2 : (int)$folder_depth;
	
    $prefix = str_repeat("../", $folder_depth - 2);
    
    $title_suffix = " Department Master";
?>
<?php include $prefix.'config.php'; ?>
<?php include $prefix.'menu.php'; ?>
<?php include $prefix.'template_start.php'; ?>
<?php include $prefix.'page_head.php'; ?>

  <!-- Page content -->
<div id="page-content">
    <!-- Blank Header -->
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i class="gi gi-podium"></i>Cash Collecting<br>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li><li>Cash Collecting</li></li>
    </ul>

    <div class="row">
      <div class="col-md-12">
        <div class="block">
           <div class="block-title">
					   <h1>Cash Collecting</h1>
				   </div>
                
           <form id="form-main" name="form-main" action="provider_crud.php" method="post"  class="form-horizontal form-bordered">
             <fieldset>
              <legend><i class="fa fa-angle-right"></i>Cash Collector</legend>                          
                <div class="form-group">                           
                  <label class="col-md-2 control-label" for="member_number">Member Number</label>
                     <div class="col-md-4">
                       <input type="text" id="member_number" name="member_number" class="form-control"  placeholder="Member Number" size="1" readonly=""> 
                     </div>

                  <label class="col-md-2 control-label" for="name_full">Name</label>
                    <div class="col-md-4">
                       <input type="text" id="name_full" name="name_full" class="form-control"  placeholder="Name" size="1" readonly="">    
                    </div>
                </div>

               <div class="form-group">
                  <label class="col-md-2 control-label" for="net_payment">Amount</label>
                  <div class="col-md-4">
                      <input type="text" id="net_payment" name="net_payment" class="form-control"  placeholder="Amount" size="1" readonly="">
                  </div>

                  <label class="col-md-2 control-label" for="paid">Paid Amount</label>
                  <div class="col-md-4">
                      <input type="text" id="Paid" name="Paid" class="form-control"  placeholder="Paid Amount" size="1">
                  </div>                                                                                       
               </div>
                         
              <div class="form-group">  
                <label class="col-md-2 control-label" for="total">Total Amount</label>
                    <div class="col-md-4">
                        <input type="text" id="total" name="total" class="form-control"  placeholder="total" size="1" readonly="">
                    </div>

                <label class="col-md-2 control-label" for="status">Status</label>
                <div class="col-md-4">
                    <select id="status" name="status" class="select-chosen"> 
                         <option value="1">Active</option>
                         <option value="0">Inactive</option>
                    </select>
                  </div>
              </div>
               <div class="form-group form-actions">
                  <input type="hidden" name="id" id="id" value="0" />
                    <div class="col-md-12">
                        <button type="submit" id="btn_submit" class="btn btn-success primary-btn pull-right"><i class="fa fa-angle-right"></i> Submit</button>
                        <button type="button" id="btn-reset" class="btn btn-warning"><i class="fa fa-repeat"></i>New</button>
                    </div>
                </div>
              </fieldset>

               <fieldset>
               	 <legend>Cash Collecting</legend> 
                    <div class="form-group">                           
                        <label class="col-md-2 control-label" for="branch_name">Branch</label>
                            <div class="col-md-4">
                                <select id="branch_name" name="branch_name" class="select-chosen" data-placeholder=" Branch Name"> 
                                  <option></option>
                                       <?php
                                        $query="SELECT
                                                  BRA.branch_id AS ID,
                                                  BRA.branch_name AS `NAME`,
                                                  BRA.branch_code AS `CODE`
                                                  FROM
                                                  branch AS BRA
                                                  WHERE
                                                  BRA.`status` = 1
                                                  ORDER BY
                                                  `NAME` ASC";

                                        $sql = mysqli_query($con_main, $query);
                                                                            
                                    while ($branches = mysqli_fetch_assoc($sql)){
                                        echo ("<option value=\"".$branches['ID']."\">".$branches['NAME']."</option>");
                                    }
                                   ?>
                                </select><!--End selete branch-->
                            </div><!--End col-md-4-->

                    <label class="col-md-2 control-label" for="center_name">Center</label>
                      <div class="col-md-4">
                          <select id="center_name" name="center_name" class="select-chosen" data-placeholder=" Center Name"> 
                              <option></option>
                          </select><!--End center selete-->
                      </div><!--End col-md-4-->
                    </div><!--End from-group-->
                </div><!--End cash block-->
             </fieldset><!--End fieldset-->
          </form>
		    </div>
      </div>
        <!-- END Example Block -->
      <div class="block full">
        <div class="table-responsive">
            <table class="table table-vcenter table-striped">
               <thead>
                  <tr>
                      <th style="font-size: 15px;">Member No</th>
                      <th style="font-size: 15px;">Name</th>
                      <th style="font-size: 15px;">Amount</th>
                      <th style="font-size: 15px;">Outstanding</th>
                  </tr>
              </thead>
              <tbody id="line_items">
              </tbody>
            </table>
        </div>
      </div><!-- END Table Content -->
    </div>

<?php include $prefix.'page_footer.php'; ?>
<?php include $prefix.'template_scripts.php'; ?>
<?php include $prefix.'template_end.php'; ?>

<script type="text/javascript">

  $('#branch_name').on('change',function(){

      var brval = $('#branch_name').val();
      $.ajax({
        url: 'data/data-branch.php',
        data: {
          branch : brval
        },
        method: 'POST',
        dataType: 'json',
        error: function (e){
          console.error(e);
        },
        success: function (r){
          if(r.result){
            if(r.data.length>0){
             
             $.each(r.data,function(k,v){
                let om = "";
                om += "<option value='"+v.center_id+"'>";
                om += v.center_name;
                om += "</option>";

                $('#center_name').append(om);
             });     
            }
          }
          $('#center_name').trigger("chosen:updated")
        }
      });
  });

  $('#center_name').on('change',function(){

     var cnt = $('#center_name').val();
     $.ajax({
        url: 'data/data-branch.php',
        data: {
          center_id : cnt
        },
        method: 'POST',
        dataType: 'json',
        error: function (e){
          console.error(e);
        },
        success: function (r){
          if(r.result){
            if(r.data.length>0){
             
             $.each(r.data,function(k,v){
                let om = "";
                om += "<tr>";
                om += "<td>"+v.member_number+"</td>";
                om += "<td>"+v.name_full+"</td>";
                om += "<td>"+v.net_payment+"</td>";
                om += "<td>"+v.center_name+"</td>";
                om += "<td>"+v.center_name+"</td>";
                om += "<tr>";

                $('#center_name').append(om);
             });     
            }
          }
        }
      });
  });


$( "#total" ).mousedown(function() {
 var amount = $('#total').val();
    var bill = $('#net_payment').val();
    var late = $('#paid').val();
    $('#total').val(bill - (-late));
});


	$('#form-main').on('submit', function (e){
		e.preventDefault();
		
		var id = $('#id').val();
		var op = (id == 0) ? "insert" : "update";
		
		var formdata = $('#form-main').serializeArray();
		formdata.push({'name':'operation','value':op});
		
		$.ajax({
			url: 'cash_collecting_crud.php',
			data: formdata,
			success: function(r){
				var msg_typ = "info";
                var msg_txt = "";

                if (r.result){
                    msg_typ = 'success';
                    msg_txt = '<h4>Success!</h4> <p>Payment saved</p>';

                    $('#form-main').trigger('reset');
                }else{
                    msg_typ = 'danger';
                    msg_txt = '<h4>Error!</h4> <p>'+r.message+'</p>';
                }

                $.bootstrapGrowl(msg_txt, {
                    type: msg_typ,
                    delay: 2500,
                    allow_dismiss: true
                });

                dt.ajax.reload();
                dt.draw();
			}
		});
	});

    $('#form-main').on('reset', function (e){
        $('#id').val("0");

        $('#cusname').val("");
        $('#cusname').trigger("chosen:updated");

        $('#loanno').val("");
        $('#loanno').trigger("chosen:updated");      
        $('#amount').val("");
        $('#type').val("");
        $('#balance').val("");
        $('#dueamount').val("");
        $('#lateamt').val("");
        $('#billamt').val("");
        $('#totalamt').val("");
    });
    /*********** Form Control End ***********/
		
	</script>
	
	<?php mysqli_close($con_main); ?>