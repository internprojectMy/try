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
                <i class="gi gi-podium"></i>Expenses Category Master<br><small>Create, Update or Delete Expenses Category</small>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li><li>Expenses Category</li></li>
    </ul>
    <!-- END Blank Header -->
		
	
    <div class="row">
        <div class="col-md-12">
            <!-- Basic Form Elements Block -->
            <div class="block">
                <!-- Basic Form Elements Title -->
                <div class="block-title">
					<h2>Expenses</h2>
				</div>
                <!-- END Form Elements Title -->

                <!-- Basic Form Elements Content -->
                <form id="form-main" name="form-main" action="provider_crud.php" method="post"  class="form-horizontal form-bordered">

                <div class="form-group">
                    
                    <div class="col-md-4">
                    <span>Expense Type</span>
                      <select id="expen_type" name="expen_type" class="select-chosen" data-placeholder="Choose Expense Type">
                            <option></option>
                            <?php
                                    $query="SELECT
                                                    pl_expense.id,
                                                    pl_expense.category,
                                                    pl_expense.status
                                                    FROM
                                                    pl_expense";

                                    $sql = mysqli_query($con_main, $query);
                                                                            
                                    while ($type = mysqli_fetch_array($sql)){
                                        echo ("<option value=\"".$type['id']."\">".$type['category']." </option>");
                                    }
                                   ?>
                            </select> 
                    </div> 

                    <div class="col-md-4">
                    <span>Expense Category</span>
                      <input type="text" id="category" name="category" class="form-control" placeholder="Enter Category">  
                    </div>

                      
                    <div class="col-md-2">
                    <span>Status</span> 
                        <select id="status" name="status" class="select-chosen"> 
                                   <option value="1" selected="">Active</option>
                                   <option value="0">Inactive</option>
                               </select>
                    </div>
                </div>  
     
                    <div class="form-group form-actions">
                        <input type="hidden" name="id" id="id" value="0" />

                        <div class="col-md-12">
                            <button type="submit" id="btn_submit" class="btn btn-success primary-btn pull-right"><i class="fa fa-angle-right"></i> Submit</button>
                            <button type="reset" class="btn btn-warning"><i class="fa fa-repeat"></i> Reset</button>
            <div class="form-group">
                <label class="col-md-2 control-label">END DATE</label>
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
            <h2>Adds</h2><small>Leaves currently exist in the system</small>
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


    App.datatables();

    var dt = $('#table-data').DataTable({
        "processing": true,
        "serverSide": true,
        "select": true,
        "columns": [
            { "data": "type", "name": "type", "title":"Expense Type" },
            { "data": "category", "name": "category", "title":"Expense Category" },
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
            "emptyTable": "No expenses to show..."
        },
        "ajax": "data/grid_data_expenses.php"
    });
	
    $('.dataTables_filter input').attr('placeholder', 'Search');

    $("#table-data tbody").on('click', '#btn-row-edit', function() {
        var str_id = $(this).closest('tr').attr('id');
        var arr_id = str_id.split("_");

        var row_id = arr_id[1];
       // alert (row_id);

        $.ajax({
            url: 'data/data_expenses.php',
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
                $.bootstrapGrowl('<h4>Error!</h4> <p>Error retrieving expenses data</p>', {
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
                      $('#expen_type').val(r.data[0].type_id); 
                      $('#expen_type').trigger("chosen:updated");               
                      $('#status').val(r.data[0].status); 
                      $('#status').trigger("chosen:updated");
                      $('#category').val(r.data[0].category);                                                                              
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
		
		var id = $('#id').val();
		var op = (id == 0) ? "insert" : "update";
		
		var formdata = $('#form-main').serializeArray();
		formdata.push({'name':'operation','value':op});

        var cat = $('#category').val();
        var type = $('#expen_type').val();

        if (cat == '' || cat == null || type == '' || type == null) 
        {
          if (cat == '' || cat == null) 
          {
            document.getElementById('cat').style.borderColor = "red";
            // document.getElementById("comment").value = "COMMENT IS REQUIRED";
            document.getElementById("cat").style.color = "red";

            $("#cat").mousedown(function()
            {
              $('#cat').val('');
              document.getElementById('cat').style.borderColor = "";
              document.getElementById("cat").style.color = "black";
            });  
          }
          if (type == '' || type == null) 
          {
            document.getElementById('type').style.borderColor = "red";
            // document.getElementById("amount").value = "AMOUNT IS REQUIRED";
            document.getElementById("type").style.color = "red";

            $("#type").mousedown(function()
            {
              $('#type').val('');
              document.getElementById('type').style.borderColor = "";
              document.getElementById("type").style.color = "black";
            });  
          }
        }
        else
        {   
    		$.ajax({
    			url: 'expenses_crud.php',
    			data: formdata,
    			success: function(r){
    				var msg_typ = "info";
                    var msg_txt = "";

                    if (r.result){
                        msg_typ = 'success';
                        msg_txt = '<h4>Success!</h4> <p>Expense saved</p>';

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
    			},
    			complete: function(e) {
                        $('#btn_submit').prop('disabled', false);
                       $("i", '#btn_submit').toggleClass("fa fa-spinner fa-spin fa fa-angle-right");
                        
                }
    		});
        }
	});

    $('#form-main').on('reset', function (e){
        $('#id').val("0");

        $('#status').val("");
        $('#status').trigger("chosen:updated");
        $('#category').val("");
        $('#expen_type').val(''); 
        $('#expen_type').trigger("chosen:updated");
    });
    /*********** Form Control End ***********/
		
	</script>
	
	<?php mysqli_close($con_main); ?>