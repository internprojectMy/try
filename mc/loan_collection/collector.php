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
                <i class="gi gi-podium"></i>Collectors Master<br><small>Create, Update or Delete Collectors</small>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li><li>Collectors</li></li>
    </ul>
    <!-- END Blank Header -->
		
	
    <div class="row">
        <div class="col-md-12">
            <!-- Basic Form Elements Block -->
            <div class="block">
                <!-- Basic Form Elements Title -->
                <div class="block-title">
					<h2>Collectors</h2>
				</div>
                <!-- END Form Elements Title -->

                <!-- Basic Form Elements Content -->
                <form id="form-main" name="form-main"  method="post"  class="form-horizontal form-bordered">

                <div class="form-group">
                    <label class="col-md-2 control-label" for="colcode">Collector Code</label>
                    <div class="col-md-4">
                      <input type="text" id="colcode" name="colcode" class="form-control" placeholder="Enter Collector Code">  
                      </div> 

                        <label class="col-md-2 control-label" for="colname">Collector Name</label>
                        <div class="col-md-4">
                            <input type="text" id="colname" name="colname" class="form-control" placeholder="Enter Collector Name">                                  
                        </div>
                </div> 

                <div class="form-group">
                    <label class="col-md-2 control-label" for="username">User Name</label>
                    <div class="col-md-4">
                      <input type="text" id="username" name="username" class="form-control" placeholder="Enter User Name">  
                      </div> 

                        <label class="col-md-2 control-label" for="pass">Password</label>
                        <div class="col-md-4">
                            <input type="text" id="pass" name="pass" class="form-control" placeholder="Enter Password">                                  
                        </div>
                </div> 

                <div class="form-group">
                    <label class="col-md-2 control-label" for="status">Status</label>
                        <div class="col-md-4">
                            <select id="status" name="status" class="select-chosen" data-placeholder="Choose Customer Status"> 
                                   <option value="1">Active</option>
                                   <option value="0">Inactive</option>
                               </select>
                        </div>
                </div> 
     
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

    <!-- Table Block -->
    <div class="block full">
        <!-- Table Title -->
        <div class="block-title">
            <h2>Adds</h2><small>Collectors currently exist in the system</small>
        </div>
        <!-- END Table Title -->

        <!-- Table Content -->
        <div class="table-responsive"><table id="table-data" class="table table-condensed table-striped table-hover"></table></div>
        <!-- END Table Content -->
    </div>
    <!-- END Table Block -->
<!-- END Page Content -->
</div>

<?php include $prefix.'page_footer.php'; ?>
<?php include $prefix.'template_scripts.php'; ?>
<?php include $prefix.'template_end.php'; ?>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">

	/*********** Data-table Initialize ***********/
    App.datatables();

    var dt = $('#table-data').DataTable({
        "processing": true,
        "serverSide": true,
        "select": true,
        "columns": [
            { "data": "collectorcode", "name": "collectorcode", "title":"Collector Code" },
            { "data": "collectorname", "name": "collectorname", "title": "Collector Name" },
            { "data": "username", "name": "username", "title": "User Name" },
             { "data": "pass", "name": "pass", "title": "Password" },
            { "data": "status", "name": "status", "title": "Status" },
            {"data": "actions", "name": "actions","title":"Actions", "searchable": false, "orderable": false, 
                mRender: function (data, type, row) {
                    return '<div class="btn-group btn-group-xs"><button id="btn-row-edit" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></button></div>'
                }
            }
        ],
        "columnDefs":[
            {"className": "dt-center", "targets": [1,2,3]}
        ],
        "language": {
            "emptyTable": "No collectors to show..."
        },
        "ajax": "data/grid_data_collector.php"
    });
	
    $('.dataTables_filter input').attr('placeholder', 'Search');

    $("#table-data tbody").on('click', '#btn-row-edit', function() {
        var str_id = $(this).closest('tr').attr('id');
        var arr_id = str_id.split("_");

        var row_id = arr_id[1];
       // alert (row_id);

        $.ajax({
            url: 'data/data_collector.php',
            data: {
                id: row_id
            },
            method: 'POST',
            dataType: 'json',
            beforeSend: function () {
                $('#table-data tbody #'+str_id+' #btn-row-edit').button('loading');
                NProgress.start();
            },
            error: function (e) {
                $.bootstrapGrowl('<h4>Error!</h4> <p>Error retrieving collectors data</p>', {
                    type: 'danger',
                    delay: 2500,
                    allow_dismiss: true
                });

                $('#table-data tbody #'+str_id+' #btn-row-edit').button('reset');
                NProgress.done();
            },
            success: function (r) {
                if (!r.result) {
                    $.bootstrapGrowl('<h4>Error!</h4> <p>'+r.message+'</p>', {
                        type: 'danger',
                        delay: 2500,
                        allow_dismiss: true
                    });
                }else{ 
                      $('#id').val(r.data[0].id);                 
                      $('#status').val(r.data[0].status); 
                      $('#status').trigger("chosen:updated");
                      $('#colcode').val(r.data[0].collector_code);
                      $('#colname').val(r.data[0].collector_name); 
                      $('#username').val(r.data[0].user_name);
                      $('#pass').val(r.data[0].password);                                                                             
                }

                $('#table-data tbody #'+str_id+' #btn-row-edit').button('reset');
                NProgress.done();
            }
        });
    });
    /*********** Table Control End ***********/

    /*********** Form Validation and Submission ***********/
	$('#form-main').on('submit', function (e){
		e.preventDefault();

		var col_code = $('#colcode').val();
		var col_name = $('#colname').val();

		var id = $('#id').val();
		var op = (id == 0) ? "insert" : "update";
		
		var formdata = $('#form-main').serializeArray();
		formdata.push({'name':'operation','value':op});

	
	        if(col_code == "" || col_name == ""){
			  
			  if(col_code == ""){

			  	  document.getElementById('colcode').style.borderColor = "red";
			  	  document.getElementById("colcode").value = "COLLECTOR CODE IS REQUIRED";
			  	  document.getElementById("colcode").style.color = "red";
			  	
                        $( "#colcode" ).mousedown(function() {
						    $('#colcode').val('');
						    document.getElementById("colcode").style.color = "black";
						    
						 });
			  }

			  if(col_name == ""){
			  	document.getElementById('colname').style.borderColor = "red";
			  	document.getElementById("colname").value = "COLLECTOR NAME IS REQUIRED";
			  	document.getElementById("colname").style.color = "red";

			  	$( "#colname" ).mousedown(function() {
						    $('#colname').val('');
						    document.getElementById("colname").style.color = "black";
						    
						 });
			  	$('#colcode').on('keydown',function(e){
							     if(e.which==9){
							    $('#colname').val('');
							    document.getElementById("colname").style.color = "black";
							 }
							});			  	
			  }
			 
		}
		else{

   
         document.getElementById('colcode').style.borderColor = "";
         document.getElementById('colname').style.borderColor = "";
		
		$.ajax({
			url: 'collector_crud.php',
			data: formdata,
			success: function(r){
				var msg_typ = "info";
                var msg_txt = "";

                if (r.result){
                    msg_typ = 'success';
                    msg_txt = '<h4>Success!</h4> <p>Collector saved</p>';
                    //swal("Collector Saved!","", "success");

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
	}
	});

    $('#form-main').on('reset', function (e){
        $('#id').val("0");

        $('#status').val("");
        $('#status').trigger("chosen:updated");
        $('#colcode').val("");
        $('#colname').val("");
        $('#username').val("");
        $('#pass').val("");
    });
    /*********** Form Control End ***********/
		
	</script>
	
	<?php mysqli_close($con_main); ?>