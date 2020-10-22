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
                <i class="gi gi-podium"></i>Department Master<br><small>Create, Update or Delete Departments</small>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li>Departments</li>
    </ul>
    <!-- END Blank Header -->
		
	
    <div class="row">
        <div class="col-md-12">
            <!-- Basic Form Elements Block -->
            <div class="block">
                <!-- Basic Form Elements Title -->
                <div class="block-title">
					<h2>Department</h2>
				</div>
                <!-- END Form Elements Title -->

                <!-- Basic Form Elements Content -->
                <form id="form-main" name="form-main" action="department_crud.php" method="post"  class="form-horizontal form-bordered" >
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="department">Department</label>
                        <div class="col-md-10">
                            <input id="department" name="department" class="form-control" placeholder="Enter Department">
                            <span class="help-block">Enter department name</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="location">Location</label>
                        <div class="col-md-4">
                            <select id="location" name="location" class="select-chosen" data-placeholder="Choose Location">
                                <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
								<?php
								    $query="SELECT
                                    mas_location.LOCATION,
                                    mas_location.LOC_CODE
                                    FROM
                                    mas_location

                                    WHERE
                                    mas_location.`STATUS` = '1'";

                                    $sql = mysqli_query($con_main, $query);
                                                                            
                                    while ($type = mysqli_fetch_array($sql)){
                                        echo ("<option value=\"".$type['LOC_CODE']."\">".$type['LOCATION']."</option>");
                                    }
								?>
                            </select>
                        </div>

                        <label class="col-md-2 control-label" for="status">Status</label>
                        <div class="col-md-4">
                            <select id="status" name="status" class="select-chosen" data-placeholder="Choose Status">
                                <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                <option value="1" selected>Active</option>
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
            <h2>Departments</h2><small>Departments currently exist in the system</small>
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

	/*********** Data-table Initialize ***********/
    App.datatables();

    var dt = $('#table-data').DataTable({
        "processing": true,
        "serverSide": true,
        "select": true,
        "columns": [
			{ "data": "department", "name": "department", "title": "Department" },
			{ "data": "location", "name": "location", "title": "Location" },
            { "data": "status", "name": "status", "title": "Status", "searchable": false, "orderable": false },
            /* ACTIONS */ 
             {	"data": "actions", "name": "actions","title":"Actions", "searchable": false, "orderable": false, 
                mRender: function (data, type, row) {
                    return '<div class="btn-group btn-group-xs"><button id="btn-row-edit" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></button></div>'
                }
            }
        ],
        "columnDefs": [
            {"className": "dt-center", "targets": [1,2,3]}
        ],
        "language": {
            "emptyTable": "No departments to show..."
        },
        "ajax": "data/grid_data_department.php"
    });
	
    $('.dataTables_filter input').attr('placeholder', 'Search');

    $("#table-data tbody").on('click', '#btn-row-edit', function() {
        var str_id = $(this).closest('tr').attr('id');
        var arr_id = str_id.split("_");

        var row_id = arr_id[1];

        $.ajax({
            url: 'data/data_department.php',
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
                $.bootstrapGrowl('<h4>Error!</h4> <p>Error retrieving department data</p>', {
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
                    $('#id').val(r.data[0].DEP_CODE);
                    $('#department').val(r.data[0].DEPARTMENT);

                    $('#location').val(r.data[0].LOC_CODE);
                    $('#location').trigger("chosen:updated");

                    $('#status').val(r.data[0].STATUS);
                    $('#status').trigger("chosen:updated");
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
		
		$.ajax({
			url: 'department_crud.php',
			data: formdata,
			success: function(r){
				var msg_typ = "info";
                var msg_txt = "";

                if (r.result){
                    msg_typ = 'success';
                    msg_txt = '<h4>Success!</h4> <p>Department saved</p>';

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

        $('#location').val("");
        $('#location').trigger("chosen:updated");

        $('#status').val(1);
        $('#status').trigger("chosen:updated");
    });
    /*********** Form Control End ***********/
		
	</script>
	
	<?php mysqli_close($con_main); ?>