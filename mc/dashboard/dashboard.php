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
    
    $title_suffix = " Dashboard";

    $sp = (isset($_REQUEST['service_provider']) && !empty($_REQUEST['service_provider'])) ? $_REQUEST['service_provider'] : 1;
    $ct = (isset($_REQUEST['con_type']) && !empty($_REQUEST['con_type'])) ? $_REQUEST['con_type'] : 1;
    $yr = (isset($_REQUEST['year']) && !empty($_REQUEST['year'])) ? $_REQUEST['year'] : date('Y', strtotime('today'));
    $mn = (isset($_REQUEST['month']) && !empty($_REQUEST['month'])) ? $_REQUEST['month'] : date('n', strtotime('last month'));
?>
<?php include $prefix.'config.php'; ?>
<?php include $prefix.'menu.php'; ?>
<?php include $prefix.'template_start.php'; ?>
<?php include $prefix.'page_head.php'; ?>

<!-- Page content -->
<div id="page-content">
    <!-- Header -->
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i class="gi gi-dashboard"></i>Dashboard<br><small>&nbsp;</small>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li>Dashboard</li>
    </ul>
 
    <div class="container" style="background-color: #fff;">
        <h3 class="text-center">Quick Access</h3>
        <div class="row" >
            <div class="col-md-2">
                <div class="icon">
                    <img src="img/boss.png" width="100px;" alt="">
                </div><!--End icon-->
                <h4><a href="http://bamicrocredit.online/mc/loan_collection/customer.php">Add customer</a></h4>
            </div>
                        
               <div class="col-md-2">
                <div class="icon">
                    <img src="img/payment-method.png" width="100px;" alt="">
                </div><!--End icon-->
                <h4><a href="http://bamicrocredit.online/mc/loan_collection/cash_lending.php">Cash Lending</a></h4>
            </div>

             <div class="col-md-2">
                <div class="icon">
                    <img src="img/cash.png" width="100px;" alt="">
                </div><!--End icon-->
                <h4><a href="http://bamicrocredit.online/mc/loan_collection/cash_collecting.php">Cash Collecting</a></h4>
            </div>

               <div class="col-md-2">
                <div class="icon">
                    <img src="img/reading.png" width="100px;" alt="">
                </div><!--End icon-->
                <h4><a href="http://bamicrocredit.online/mc/loan_collection/cash_book_summary.php">Cash Book</a></h4>
            </div>

                <div class="col-md-2">
                <div class="icon">
                    <img src="img/report.png" width="100px;" alt="">
                </div><!--End icon-->
                <h4><a href="http://bamicrocredit.online/mc/loan_collection/loan_summary.php">Loan Summery</a></h4>
            </div>

               <div class="col-md-2">
                <div class="icon">
                    <img src="img/charts.png" width="100px;" alt="">
                </div><!--End icon-->
                <h4><a href="http://bamicrocredit.online/mc/loan_collection/lost_profit_summary.php">PROFIT & LOSS</a></h4>
            </div>
        </div>
    </br>
        <div class="row">
            <div class="col-md-1" style="font:red">
                Start Date
            </div>
            <div class="col-md-2">
                <div  data-date-format="yyyy-mm-dd">
                        <input type="text" id="start_date" name="start_date" class="form-control text-center start_date" placeholder="Select Date" disabled="disabled">
                </div>
            </div>
              <div class="col-md-2">
                <div>
                        <button type="button" id="edit_btn" class="btn btn-danger">Edit</button>
                </div>
            </div>
        </div>
    </br>
        <div class="row">
        </div>

    </div>

   </div> 
   

<?php include $prefix.'page_footer.php'; ?>
<?php include $prefix.'template_scripts.php'; ?>
<?php include $prefix.'template_end.php'; ?>

<script type="text/javascript">

// reload function - must include all pages
	  $(document).ready(function () {

			  $.ajax({
                     url : 'session_crud.php',
                     data : {
                     	op : 'get'
                     },
                     method: 'POST',
                     dataType: 'json',
                     error: function (e) {
                        // swal("Error !","Connection error.","error");
                     },
                     success: function(r){
                         if(r.result){                         	
                          
                             $("#start_date").val(r.data[0].session_date);

                         }else{
                         
                           
                         } 
                     }

                 });
			  });


//---------- edit button function -----------------------------------------------------
	$('#edit_btn').on('click', function (e){

		e.preventDefault();

		$("#start_date").removeAttr("disabled");
		var s_date = $("#start_date").val();

		  $.ajax({
                     url : 'session_crud.php',
                     data : {
                     	op : 'get'
                     },
                     method: 'POST',
                     dataType: 'json',
                     error: function (e) {
                        // swal("Error !","Connection error.","error");
                     },
                     success: function(r){
                         if(r.result){                         	
                          
                             $("#start_date").val(r.data[0].session_date);

                         }else{
                         
                           
                         } 
                     }

                 });

		    $('#start_date').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            autoclose: true,
            startDate : s_date
    	});

	});
	
//-------- edit date function --------------------------------------
	$('#start_date').on('change', function (e){
		e.preventDefault();

		var date = $('#start_date').val();

		       $.ajax({
                     url : 'session_crud.php',
                     data : {
                     	date : date,
                     	op : 'update'
                     },
                     method: 'POST',
                     dataType: 'json',
                     error: function (e) {
                         swal("Error !","Connection error.","error");
                     },
                     success: function(r){
                         if(r.result){
                          			  $.ajax({
                     url : 'session_crud.php',
                     data : {
                     	op : 'get'
                     },
                     method: 'POST',
                     dataType: 'json',
                     error: function (e) {
                        // swal("Error !","Connection error.","error");
                     },
                     success: function(r){
                         if(r.result){                         	
                          
                             $("#start_date").val(r.data[0].session_date);

                         }else{
                         
                           
                         } 
                     }

                 });
                            
                         }else{
                            
                         } 
                     }

                 });


		 $("#start_date").prop("disabled",true);
	});

//---------------------- end date all functions -----------------

    $('.draggable-blocks').sortable({
        connectWith: '.block',
        items: '.block',
        opacity: 0.75,
        handle: '.block-title',
        placeholder: 'draggable-placeholder',
        tolerance: 'pointer',
        start: function(e, ui){
            ui.placeholder.css('height', ui.item.outerHeight());
        }
    });

    // Get the elements where we will attach the charts
    var chartClassic = $('#chart-classic');
    var data_json_array = <?php include('data_month_overview_con_type.php'); ?>;

    // Classic Chart
    $.plot(chartClassic,data_json_array.coords,
        {
            colors: ['#3498db', '#333333'],
            legend: {show: true, position: 'nw', margin: [15, 10]},
            grid: {borderWidth: 0, hoverable: true, clickable: true},
            yaxis: {ticks: 4, tickColor: '#eeeeee'},
            xaxis: {ticks: data_json_array.x_axis, tickColor: '#ffffff'}
        }
    );

    // Creating and attaching a tooltip to the classic chart
    var previousPoint = null, ttlabel = null;
    chartClassic.bind('plothover', function(event, pos, item) {

        if (item) {
            if (previousPoint !== item.dataIndex) {
                previousPoint = item.dataIndex;

                $('#chart-tooltip').remove();
                var x = item.datapoint[0], y = item.datapoint[1];

                if (item.seriesIndex === 1) {
                    ttlabel = 'Rs <strong>' + y + '</strong>';
                } else {
                    ttlabel = 'Rs <strong>' + y + '</strong>';
                }

                $('<div id="chart-tooltip" class="chart-tooltip">' + ttlabel + '</div>')
                    .css({top: item.pageY - 45, left: item.pageX + 5}).appendTo("body").show();
            }
        }
        else {
            $('#chart-tooltip').remove();
            previousPoint = null;
        }
    });

 
 
</script>