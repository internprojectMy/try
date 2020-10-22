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
                <i class="gi gi-podium"></i>Loan Payment Details Report<br>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li><li>Reports</li></li>
        <li><li>Loan Payments</li></li>
    </ul>
    <!-- END Blank Header -->
		
	
    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <!-- Basic Form Elements Content -->
<form id="form-main" name="form-main" action="provider_crud.php" method="post"  class="form-horizontal form-bordered">

<div class="form-group">   
  <label class="col-md-2 control-label" for="cusname">Customer Name</label>
                        <div class="col-md-4">
                            <select id="name_full" name="name_full" class="select-chosen" data-placeholder="Select Customer Name"> 
                                <option></option>
                                   <?php
                                    $query="SELECT
                                                loan_customer.id,
                                                loan_customer.name_full,
                                                loan_customer.nic

                                            FROM
                                                `loan_customer`
                                            WHERE
                                                loan_customer.`status` = '1'";

                                    $sql = mysqli_query($con_main, $query);
                                                                            
                                    while ($type = mysqli_fetch_array($sql)){
                                        echo ("<option value=\"".$type['name_full']."\">".$type['nic']." - ".$type['name_full']."</option>");
                                    }
                                   ?>
                            </select>
                        </div>

                        <label class="col-md-2 control-label" for="loanno">Loan No</label>
                        <div class="col-md-4">
                            <select id="loanno" name="loanno" class="select-chosen" data-placeholder="Choose Loan No"> 
                                <option></option>
                            </select>
                        </div>
                    </div>

    <div class="form-group form-actions">
        <input type="hidden" name="report_url" id="report_url" value="reports/customer_payments_report.php"/>                  
            <div class="col-md-12">
                <button type="submit" class="btn btn-success primary-btn pull-right"><i class="fa fa-angle-right"></i> Submit</button>
                <button type="reset" id="btn-reset" class="btn btn-warning"><i class="fa fa-repeat"></i> New</button>
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

	/*********** Data-table Initialize ***********/


 $('#name_full').on('change', function(){
        var id = $('#name_full').val();

        
        $.ajax({
            url: 'data/agent_loan_id.php',
            data: {
                id : id
            },
            method: 'post',
            error: function(e){
                alert ('Error requesting provider data');
            },
            success: function(r){
                 $('#loanid').html('<option value=""></option>');

                if (r.result){
                    if (r.data.length > 0){
                        $.each(r.data, function (k, v){
                            let option_markup = "";

                            option_markup += "<option value='"+v.loanid+"'>";
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


//  $('#name_full').on('change', function(){

//     let name_full = $(this).val();

//     $.ajax({

//         url: 'data/data_name.php',
//         data : {
//             name_full : name_full
//         },

//         method : 'POST',
//         dataType : 'json',

//         error : function(e){
//             console.log(e);
//         },

//         success : function(r){
//             if(r.result){
//                 let member_number = r.data[0].member_number;


//                 $('member_number').val(member_number);
//             }else{
//                 console.log(r.debug);
//             }
//         }
//     });

// });





    $('#from').datepicker({
            format: 'yyyy-mm-dd',
            //startDate: '-3d'
        });
        
    $('#to').datepicker({
            format: 'yyyy-mm-dd',
            //startDate: '-3d'
        });    
        
	$('#form-main').on('submit', function (e){
		e.preventDefault();
        var report_url = $('#report_url').val();
        var form_data = $('#form-main').serialize();
        var name_full = $('#name_full').val();
        var loanno = $('#loanno').val();
    // if (report_url == 0 || report_url == "") return;
    window.open(report_url+"?"+"name_full="+name_full+"&"+"loanno="+loanno);	
	});

    $('#form-main').on('reset', function (e){
        $('#id').val("0");

        $('#name_full').val("");
        $('#cusname').trigger("chosen:updated");
        $('#loanno').val("");
        $('#loanno').trigger("chosen:updated");                               
       
    });
    /*********** Form Control End ***********/
		
	</script>
	
	<?php mysqli_close($con_main); ?>