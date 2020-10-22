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
                <i class="gi gi-podium"></i>Collector Collections Details Report<br>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li><li>Reports</li></li>
        <li><li>loans collect collector wise</li></li>
    </ul>
    <!-- END Blank Header -->
		
	
    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <!-- Basic Form Elements Content -->
<form id="form-main" name="form-main" action="receipts.php" method="post"  class="form-horizontal form-bordered">

<div class="form-group">   
  <label class="col-md-2 control-label" for="collector">Collector Name</label>
                        <div class="col-md-4">
                            <select id="collector" name="collector" class="select-chosen" data-placeholder="Select Collector Name"> 
                                <option></option>
                                   <?php
                                    $query="SELECT
                                    cash_collector.cash_name,
                                    cash_collector.id
                                    FROM
                                    cash_collector";


                                    $sql = mysqli_query($con_main, $query);
                                                                            
                                    while ($type = mysqli_fetch_array($sql)){
                                        echo ("<option value=\"".$type['cash_name']."\">".$type['cash_name']." </option>");
                                    }
                                   ?>
                            </select>
                        </div>

                        <!-- <label class="col-md-2 control-label" for="loanno">Loan No</label>
                        <div class="col-md-4">
                            <select id="loanno" name="loanno" class="select-chosen" data-placeholder="Choose Loan No"> 
                                <option></option>
                            </select>
                        </div> -->
</div>
    <div class="form-group form-actions">
        <input type="hidden" name="report_url" id="report_url" value="reports/loan_collector_report1.php"/>                  
            <div class="col-md-12">
                <button type="submit" class="btn btn-success primary-btn pull-right"><i class="fa fa-angle-right"></i> Submit</button>
            </div>

                 <div class="col-md-12">
                    <input type="hidden" name="repo_type" id="repo_type" value="DETAILED">
                  <button type="button" class="btn btn-primary" id="detail_submit2"><i class="fa fa-file-excel-o"></i> Excel</button>
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
	$('#form-main').on('submit', function (e){
		e.preventDefault();
        var report_url = $('#report_url').val();
        var form_data = $(this).serialize();
    if (report_url == 0 || report_url == "") return;

    window.open(report_url+"?"+form_data);	
	});

    $('#form-main').on('reset', function (e){
        $('#id').val("0");

        $('#collector').val("");
        $('#collector').trigger("chosen:updated");
        
    });
    /*********** Form Control End ***********/



    $('#detail_submit2').on('click',function(){
   var collector = $('#collector').val();
       // window.open("export_data_collector.php?collector="+collector);
  window.open("export_data_collector.php?coll_name="+collector);
});
		
	</script>
	
	<?php mysqli_close($con_main); ?>