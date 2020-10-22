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
            <!-- Basic Form Elements Block -->
            <div class="block">
                <!-- Basic Form Elements Title -->
                <div class="block-title">
					<h1>Cash Collecting</h1>
				</div>
                <!-- END Form Elements Title -->

                <!-- Basic Form Elements Content -->
                <form id="form-main" name="form-main" action="provider_crud.php" method="post"  class="form-horizontal form-bordered">
               <fieldset>
               	 <legend><i class="fa fa-angle-right"></i>Cash Collecting</legend> 
                <div class="form-group">                     


                   <label class="col-md-2 control-label" for="cusname">Customer Name</label>
                        <div class="col-md-4">
                            <select id="cusname" name="cusname" class="select-chosen" data-placeholder="Select Customer Name"> 
                                <option></option>
                                   <?php
                                    $query="SELECT
                        												loan_customer.id,
                        												loan_customer.calling_name
                        											FROM
                        												`loan_customer`
                        											WHERE
                        												loan_customer.`status` = '1'";

                                    $sql = mysqli_query($con_main, $query);
                                                                            
                                    while ($type = mysqli_fetch_array($sql)){
                                        echo ("<option value=\"".$type['id']."\">".$type['calling_name']."</option>");
                                    }
                                   ?>
                            </select>
                        </div>
                </div>  
                

                <div class="form-group" id="update_form">
        <div class="col-md-12">  
            <h4>Items</h4>                                        
            <table class="table">
                <tr>
                    <th>Item</th>
                    <th>Glass mark</th>
                    <th>Length(mm)</th>
                    <th>Width(mm)</th>
                    <th>Quote Qty</th>
                    <th>Prod.QTY</th>
                    <th>Quot. Bal.</th>
                    <th>prev. dispat. QTY</th>
                    <th>Avail. Qty</th>
                    <th>Release to Customer QTY</th>
                    <th>Comment for Dispatch</th>
                    <th>Comment for Customer</th>
                </tr>
                <tbody id="rows">
                </tbody>                                      
            </table>            
        </div> 
    </div>
     </fieldset>
                    <div class="form-group form-actions">
                        <input type="hidden" name="id" id="id" value="0" />

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success primary-btn pull-right"><i class="fa fa-angle-right"></i> Submit</button>
                            <button type="reset" class="btn btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                        </div>
                    </div>
                </form>
                <!-- END Basic Form Elements Block -->
		    </div>
            <!-- END Example Content -->
        </div>
        <!-- END Example Block -->
    </div>  
</div>

<?php include $prefix.'page_footer.php'; ?>
<?php include $prefix.'template_scripts.php'; ?>
<?php include $prefix.'template_end.php'; ?>

<script type="text/javascript">

/*********** Form Validation and Submission ***********/
// $('#search').select2({
//             minimumInputLength:1,
//             ajax: {
//                 url: 'data/invoice_select.php',
//                 dataType: 'json',
//                 delay: 100,
//                 data: function (term) {
//                     return term;
//                 },
//                 processResults: function (data) {
//                     return {
//                         results: $.map(data, function (item) {
//                             return {
//                                 text: item.name,
//                                 id: item.id
//                             }
//                         })
//                     };
//                 }
//             }
//         });

// $('#search').on('change', function (e){
//             var crn_id = $('#search').select2('val');

//             $.ajax({
//                 url: 'data/today_loan_edit.php',
//                 data: {
//                     id: crn_id
//                 },
//                 method: 'POST',
//                 dataType: 'json',
//                 error: function (e){
//                     alert ("Something went wrong when getting loan details.");
//                 },
//                 success: function (r){
//                     var result = r.result;
//                     var message = r.message;
//                     var data = r.data;

//                     if (result){
//                      $('#id').val(r.data[0].collectid);                     
//                      $('#collectdate').val(r.data[0].collect);

//                      $('#cusname').val(r.data[0].customer);
//                      $('#cusname').trigger("chosen:updated");

//                      $('#loanno').val(r.data[0].loanid);
//                      $('#loanno').trigger("chosen:updated");

//                      $('#collector').val(r.data[0].collector_name);
//                      $('#amount').val(r.data[0].loan_amt);
//                      $('#type').val(r.data[0].loan_tp);
//                      $('#received').val(r.data[0].total_paid_amount);
//                      $('#balance').val(r.data[0].balance_amt);
//                      $('#dueamount').val(r.data[0].outstanding);
//                      $('#billamt').val(r.data[0].bill);
//                      $('#lateamt').val(r.data[0].late);                      
//                      $('#totalamt').val(r.data[0].total);
//                        }else{
//                           alert (message);
//                     }
//                 }
//             });
//         });

  $('#cusname').on('change', function(){
        var cato = $('#cusname').val();
        
        $.ajax({
            url: 'data/agent_loan_id.php',
            data: {
                cusid : cato
            },
            method: 'post',
            error: function(e){
                alert ('Error requesting provider data');
            },
            success: function(r){
                 $('#loanno').html('<option value=""></option>');

                if (r.result){
                    if (r.data.length > 0){
                        $.each(r.data, function (k, v){
                            let option_markup = "";

                            option_markup += "<option value='"+v.id+"'>";
                            option_markup += v.loanid;
                            option_markup += "</option>";

                            $('#loanno').append(option_markup)
                            
                        });
                    }
                }

                $('#loanno').trigger("chosen:updated");

            }
        });
    });


$('#loanno').on('change', function(){
        var cato = $('#loanno').val();
        
        $.ajax({
            url: 'data/agent_loan_details.php',
            data: {
                loanid : cato
            },
            method: 'post',
            error: function(e){
                alert ('Error requesting data');
            },
            success: function(r){
                 $('#member_number').val(r.data[0].member_number);
                 $('#name_full').val(r.data[0].name_full);
                 $('#net_payment').val(r.data[0].net_payment);
                 $('#Paid').val(r.data[0].Paid);
                 // $('#balance').val(r.data[0].balance_amt);
                 // $('#collector').val(r.data[0].collector_name);
            }
        });
    });


$('#lateamt').on('keydown',function(e){
     if(e.which==9){
    var bill = $('#billamt').val();
    var late = $('#lateamt').val();
    $('#totalamt').val(bill - (-late));
 }
});

$( "#totalamt" ).mousedown(function() {
 var amount = $('#loanamount').val();
    var bill = $('#billamt').val();
    var late = $('#lateamt').val();
    $('#totalamt').val(bill - (-late));
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