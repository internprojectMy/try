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
                <i class="gi gi-podium"></i>Customer Summary Report<br>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li><li>Reports</li></li>
        <li><li>Customer Summary</li></li>
    </ul>
    <!-- END Blank Header -->
		
	
    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <!-- Basic Form Elements Content -->
<form id="form-main" name="form-main" action="provider_crud.php" method="post"  class="form-horizontal form-bordered">

    <div class="form-group">
        <label class="col-md-2 control-label" for="search">Search</label>
            <div class="col-md-9">
                <select name="search" id="search" style="width:100%;">
                    <option value="" selected disabled>Select Customer</option>
                </select>
            </div>     
    </div>

    <div class="form-group">
            <label class="col-md-2 control-label" for=" from">From</label>
                <div class="col-md-4">
                       <input type="text" id="from" name="from" class="form-control" placeholder="yyyy-mm-dd">
                </div>

            <label class="col-md-1 control-label" for="to">To</label>
                <div class="col-md-4">
                    <input type="text" id="to" name="to" class="form-control" placeholder="yyyy-mm-dd">
                </div>              
    </div>

    <div class="form-group form-actions">
        <input type="hidden" name="report_url" id="report_url" value="reports/customer_summary_report.php"/>                  
            <div class="col-md-12">
                <button type="submit" class="btn btn-success primary-btn pull-right"><i class="fa fa-angle-right"></i> Submit</button>
                <button type="button" id="btn-reset" class="btn btn-warning"><i class="fa fa-repeat"></i>New</button>
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

    $('#from').datepicker({
            format: 'yyyy-mm-dd',
            //startDate: '-3d'
        });
                    $('#to').datepicker({
            format: 'yyyy-mm-dd',
            //startDate: '-3d'
        });
    $('#search').select2({
            minimumInputLength:2,
            ajax: {
                url: 'data/customer_select.php',
                dataType: 'json',
                delay: 100,
                data: function (term) {
                    return term;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
         
	$('#form-main').on('submit', function (e){
		e.preventDefault();
        var report_url = $('#report_url').val();
        var form_data = $(this).serialize();
    if (report_url == 0 || report_url == "") return;

    window.open(report_url+"?"+form_data);	
	});

    $('#form-main').on('reset', function (e){
        $('#id').val("0");

        $('#search').val("");
        $('#search').trigger("chosen:updated");
        $('#from').val("");
        $('#to').val("");
    });
    /*********** Form Control End ***********/
		
	</script>
	
	<?php mysqli_close($con_main); ?>