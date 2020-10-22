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
                <i class="gi gi-podium"></i>Balance Sheet Summary Report<br>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li><li>Reports</li></li>
        <li><li>Balance Sheet Statement</li></li>
    </ul>
    <!-- END Blank Header -->
		
	
    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <!-- Basic Form Elements Content -->
<form id="form-main" name="form-main" action="provider_crud.php" method="post"  class="form-horizontal form-bordered">
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
     <div class="form-group">
             <label class="col-md-2 control-label" for="branch_id">Branch Name</label>
                                     <div class="col-md-4">
                                       <select id="branch_id" name="branch_id" class="select-chosen" data-placeholder=" Branch Name"> 
                                <option></option>
                                   <?php
                                    $query="SELECT
                                                branch.branch_id,
                                                branch.branch_name,
                                                branch.branch_code,
                                                branch.branch_comment,
                                                branch.branch_date
                                                        FROM
                                                        branch";
                                                

                                    $sql = mysqli_query($con_main, $query);
                                                                            
                                    while ($branch_id = mysqli_fetch_assoc($sql)){
                                        echo ("<option value=\"".$branch_id['branch_id']."\">".$branch_id['branch_name']."</option>");
                                    }
                                   ?>
                            </select>
                </div><!--End col-md-4-->
            </div>

    <div class="form-group form-actions">
        <input type="hidden" name="report_url" id="report_url" value="reports/balance_sheet_report.php"/>                  
            <div class="col-md-12">
                <button type="submit" class="btn btn-success primary-btn pull-right"><i class="fa fa-angle-right"></i> Submit</button>
                 <a href="export_pl.php" class="btn btn-success">Export</a>
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