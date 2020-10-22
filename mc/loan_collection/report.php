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
    
    $title_suffix = " Mobile Reports";
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
                <i class="fa fa-file-text"></i>Reports<br><small>Reports collection</small>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li>Reports</li>
    </ul>
    <!-- END Blank Header -->

    <!-- Reports Block -->
    <div class="block">
        <!-- Reports Title -->
        <div class="block-title">
            <h2>Reports</h2>
        </div>
        <!-- END Reports Title -->

        <!-- Reports Content -->
        <!-- Reports Form Content -->
        <form id="form-reports" name="form-reports" class="form-horizontal form-bordered" >
            <div class="form-group">
                <label class="col-md-2 control-label" for="report">Reports</label>
                <div class="col-md-8">
                    <select id="report" name="report" class="select-chosen" data-placeholder="Select Report">
                        <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                        <option value="report_ui/agents.php">Agents Comission</option>
                        <!-- <option value="report_ui/leaders.php">Leaders Comission</option> -->
                        <option value="report_ui/allagents.php">Agents Advertisements Details</option>
                        <!-- <option value="report_ui/override_comission.php">Override Comission Details For Agents</option> -->
                        <option value="report_ui/override_comission_leader.php">Allowance For Leaders</option>
                        <option value="report_ui/owner_comission.php">Managers Total Comission</option>
                        <option value="report_ui/agentscomission.php">Agents Payments</option>
                        
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-info primary-btn"><i class="fa fa-angle-right"></i> Go</button>
                </div>
            </div>
        </form>
        <!-- END Reports Form Content -->
        <!-- END Reports Content -->
    </div>
    <!-- END Reports Block -->

    <!-- Reports Block -->
    <div class="block">
        <!-- Reports Title -->
        <div class="block-title">
            <h2>Report Filters</h2>
        </div>
        <!-- END Reports Title -->

        <!-- Reports Content -->
        <form id="form-filters" name="form-filters" class="form-horizontal form-bordered">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <h3 class="text-muted">
                        <i class="fa fa-info-circle"></i> Select report from above, to load filters.
                    </span>
                </div>
            </div>
            <br>
        </form>
        <!-- END Reports Content -->
    </div>
    <!-- END Reports Block -->
</div>
<!-- END Page Content -->

<?php include $prefix.'page_footer.php'; ?>
<?php include $prefix.'template_scripts.php'; ?>
<?php include $prefix.'template_end.php'; ?>

<script type="text/javascript">
$('#form-reports').on('submit', function (ev){
    ev.preventDefault();

    var ui_url = $('#report').val();
    if (ui_url == "") return;

    $.ajax({
        url: ui_url,
        type: 'POST',
	    dataType: 'text',
        error: function(er) {
            alert("An error has occurred when getting interface.\nPlease contact administrator.");
        },
        success: function(re) {
            $('#form-filters').html(re);
        }
    });
});

$('#form-filters').on('submit', function (ev){
    ev.preventDefault();
    var report_url = $('#report_url').val();
    var form_data = $(this).serialize();
    //alert(report_url);

    if (report_url == 0 || report_url == "") return;

    window.open(report_url+"?"+form_data);
});
</script>