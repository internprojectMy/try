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
    
    $title_suffix = " User Profile";
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
                <i class="gi gi-user_add"></i>User Profile<br><small>Create, Update or Remove Users</small>
            </h1>
        </div>
    </div>

    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li>User Profiles</li>
    </ul>
    <!-- END Header -->
	
    <div class="row">
        <div class="col-md-12">
            <!-- Form Elements Block -->
            <div class="block">
                <!-- Form Elements Title -->
                <div class="block-title">
				    <h2>User</h2>
				</div>
                <!-- END Form Elements Title -->

                <!-- Form Elements Content -->
                <form id="form-main" name="form-main" action="user_profile_crud.php" method="post" class="form-horizontal form-bordered">
                    <fieldset>
					    <legend><i class="fa fa-angle-right"></i> Personal Details</legend>
					
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2 col-md-offset-1" align="center">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <img id="photo" width="150" height="150" src="profile_pix/avatar_guest.jpg" style="background:#EAEAEA;border:#C4C4C4 1px dashed;">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" style="padding-top:5px;">
                                            <a id="toggle-uploader" class="btn btn-sm btn-info" data-toggle="tooltip" data-placement="bottom" title="Click to upload profile picture" style="min-width:150px;">
                                                <i class="fa fa-upload"></i> Upload Image
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="first_name">First Name</label>
                                        <div class="col-md-4">
                                            <input type="text" id="first_name" name="first_name" class="form-control"  placeholder="Enter First Name" size="1">
                                        </div>
                                    
                                        <label class="col-md-2 control-label" for="last_name">Last Name</label>
                                        <div class="col-md-4">
                                            <input type="text" id="last_name" name="last_name" class="form-control"  placeholder="Enter Last Name" size="1">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="gender">Gender</label>
                                        <div class="col-md-4">
                                            <select id="gender" name="gender" class="select-chosen" data-placeholder="Select Gender" size="1">
                                                <Option value=""></option>
                                                <Option value="Male">Male</Option>
                                                <Option value="Female">Female</Option>
                                            </select>
                                        </div>
                                        
                                        <label class="col-md-2 control-label" for="nic">NIC</label>
                                        <div class="col-md-4">
                                            <input type="text" id="nic" name="nic" class="form-control"  placeholder="Enter NIC No" size="1">
                                        </div>
                                    </div>

                                    <!-- <div class="form-group">
                                        <label class="col-md-2 control-label" for="nic">NIC</label>
                                        <div class="col-md-4">
                                            <input type="text" id="nic" name="nic" class="form-control"  placeholder="Enter NIC No" size="1">
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
					</fieldset>
                   
					<fieldset>
					    <legend><i class="fa fa-angle-right"></i>Collector Details</legend>
					
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="emp_no">Collector Code</label>
                            <div class="col-md-4">
                                <input type="text" id="emp_no" name="emp_no" class="form-control"  placeholder="Enter Collector Code" size="1">
                            </div>

                            <label class="col-md-2 control-label" for="joined_date">Date joined</label>
                            <div class="col-md-4">
                                <input type="text" id="joined_date" name="joined_date" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd">
                            </div>
					    </div>
					</fieldset>
					
					<fieldset>
					    <legend><i class="fa fa-angle-right"></i> Contact Details</legend>
					
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="phone">Phone Number</label>
                            <div class="col-md-4">
                                <input type="text" id="phone" name="phone" class="form-control"  placeholder="Enter Phone Number" size="1">
                            </div>
                            
                            <label class="col-md-2 control-label" for="email">Email</label>
                            <div class="col-md-4">
                                <input type="text" id="email" name="email" class="form-control"  placeholder="Enter Email" size="1">
                            </div>
                        </div>
					</fieldset>

                    <fieldset>
					    <legend><i class="fa fa-angle-right"></i> System Access Details</legend>
					
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="username">Username</label>
                            <div class="col-md-4">
                                <input type="text" id="username" name="username" class="form-control"  placeholder="Enter Username" size="1">
                            </div>
                            
                            <label class="col-md-2 control-label" for="password">Password</label>
                            <div class="col-md-4">
                                <input type="password" id="password" name="password" class="form-control"  placeholder="Enter Password" size="1">
                            </div>
                        </div>
					</fieldset>
					
					<fieldset>
                        <legend><i class="fa fa-angle-right"></i> Availability Details</legend>
                        
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="resigned_date">Resigned Date</label>
                            <div class="col-md-4">
                                <input type="text" id="resigned_date" name="resigned_date" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd">
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
					</fieldset>
					
					<div class="form-group form-actions">
                        <input type="hidden" name="id" id="id" value="0" />
					
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success primary-btn pull-right"><i class="fa fa-angle-right"></i> Submit</button>
                            <button type="button" id="btn-reset" class="btn btn-warning"><i class="fa fa-repeat"></i> New</button>
                        </div>
                    </div>
                </form>
                <!-- END Content -->  
		    </div>
            <!-- END Form Elements Block -->

            <div id="modal-upload" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h3 class="modal-title">Upload Image</h3>
                        </div>
                        <div class="modal-body">
                            <!-- Upload Content -->
                            <form action="user_profile_crud.php" class="dropzone" id="uploader">
                                <input type="hidden" name="operation" id="operation" value="upload-image" />
                                <input type="hidden" name="obj_id" id="obj_id" value="0" />
                                <div class="fallback">
                                    <input name="file" type="file" multiple />
                                </div>
                            </form>
                            <!-- END  Content -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btn-upload-done" class="btn btn-sm btn-primary" data-dismiss="modal">Done</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Block -->
    <div class="block full">
        <!-- Table Title -->
        <div class="block-title">
            <h2>User Profiles </h2><small>User Profiles currently exist in the system</small>
        </div>
        <!-- END Table Title -->

        <!-- Table Content -->
        <div class="table-responsive"><table id="table-data" class="table table-condensed table-striped table-hover"></table></div>
        <!-- END Table Content -->
    </div>
    <!-- END Table Block -->
</div>
<!-- END Page Content -->

<?php include $prefix.'page_footer.php'; ?>
<?php include $prefix.'template_scripts.php'; ?>
<?php include $prefix.'template_end.php'; ?>

<script src="<?php echo ($prefix); ?>js/lib/jquery.maskedinput.js"></script>
<script src="<?php echo ($prefix); ?>js/lib/jquery.validate.js"></script>
<script src="<?php echo ($prefix); ?>js/lib/jquery.form.js"></script>
<script src="<?php echo ($prefix); ?>js/lib/j-forms.js"></script>

	
<!--Bootbox-->
	
<script type="text/javascript">
    $('#location').on('change', function (ev) {
        var loc_code = $('#location').val();

        $.ajax({
            url: 'data/data_department.php',
            data: {
                location: loc_code,
                status: 1
            },
            method: 'POST',
            error: function (re) {
                $.bootstrapGrowl('<h4>Error!</h4> <p>Error retrieving departments</p>', {
                    type: 'danger',
                    delay: 2500,
                    allow_dismiss: true
                });
            },
            success: function (re) {
                $('#department').html('<option value=""></option>');

                $.each(re.data, function (k,v){
                    $('#department').append('<option value="' + v.DEP_CODE + '">' + v.DEPARTMENT + '</option>');
                });

                $("#department").trigger("chosen:updated");
            }
        });
    });
	
	/*********** Data-table Initialize ***********/	 	
	App.datatables();

    var dt = $('#table-data').DataTable({
        "processing": true,
        "serverSide": true,
        "select": true,
        "columns": [
			{ "data": "emp_no", "name": "emp_no", "title": "Emp No" },
            { "data": "emp_name", "name": "emp_name", "title": "Name" },
            /*{ "data": "first_name", "name": "first_name", "title": "First Name" },
            { "data": "last_name", "name": "last_name", "title": "Last Name" },*/
			{ "data": "designation", "name": "designation", "title": "Designation" },
			{ "data": "location", "name": "location", "title": "Location" },
			{ "data": "department", "name": "department", "title": "Department" },
			{ "data": "phone", "name": "phone", "title": "Phone" },
			{ "data": "email", "name": "email", "title": "Email" },
			{ "data": "status", "name": "status", "title": "Status", "searchable": false, "orderable": false, },
			
            /* ACTIONS */ 
            { "data": "actions", "name": "actions","title":"Actions", "searchable": false, "orderable": false, 
                mRender: function (data, type, row) {
                    return '<div class="btn-group btn-group-xs"><button id="btn-row-edit" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></button></div>'
                }
            }
        ],
       "columnDefs": [
            {"className": "dt-center", "targets": [4,5,7,8]}
        ],
        "language": {
            "emptyTable": "No files to show..."
        },
        "ajax": "data/grid_data_user_profile.php"
    });

	$('.dataTables_filter input').attr('placeholder', 'Search');

    $("#table-data tbody").on('click', '#btn-row-edit', function() {
        var str_id = $(this).closest('tr').attr('id');
        var arr_id = str_id.split("_");

        var row_id = arr_id[1];

        $.ajax({
            url: 'data/data_user_profile.php',
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
                $.bootstrapGrowl('<h4>Error!</h4> <p>Error retrieving User data</p>', {
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
                    $('#id').val(r.data[0].USER_CODE);
                    $('#obj_id').val(r.data[0].USER_CODE);
                    $('#first_name').val(r.data[0].FIRST_NAME);
                    $('#last_name').val(r.data[0].LAST_NAME);
                    $('#gender').val(r.data[0].GENDER).trigger("chosen:updated");
                    $('#dob').val(r.data[0].DOB);
                    $('#nic').val(r.data[0].NIC);
                    $('#emp_no').val(r.data[0].EMP_NO);
                    $('#designation').val(r.data[0].DESIGNATION).trigger("chosen:updated");
                    $('#location').val(r.data[0].LOCATION).trigger("chosen:updated").trigger('change');
                    $('#cost_center').val(r.data[0].COST_CENTER).trigger("chosen:updated");
                    $('#joined_date').val(r.data[0].DATE_JOINED);
                    $('#phone').val(r.data[0].MOBILE_NO);
					$('#email').val(r.data[0].EMAIL);
					$('#username').val(r.data[0].USERNAME);
					$('#password').val(r.data[0].PASSWORD);
					$('#resigned_date').val(r.data[0].DATE_LEFT);
                    $('#status').val(r.data[0].STATUS).trigger("chosen:updated");

                    setTimeout(function (e){
                        $('#department').val(r.data[0].DEPARTMENT).trigger("chosen:updated");
                    }, 500);

                    if (r.data[0].PHOTO != null){ 
                        $('#photo').prop('src',r.data[0].PHOTO + '?' + new Date().getTime());
                    }else{
                        $('#photo').prop('src','profile_pix/avatar_guest.jpg?' + new Date().getTime());
                    }
                }

                $('#table-data tbody #'+str_id+' #btn-row-edit').button('reset');
                NProgress.done();
            }
        });
    });

    $('#form-main').on('submit', function (e){
		e.preventDefault();
		
		var id = $('#id').val();
		var op = "insert";

        op = (id == 0) ? "insert" : "update";
		
		var formdata = $('#form-main').serializeArray();
		formdata.push({'name':'operation','value':op});
		
		$.ajax({
			url: 'user_profile_crud.php',
			data: formdata,
			success: function(r){
                $('#id').val(r.id);
                $('#obj_id').val(r.id);
				
                var msg_title = "Error";
                var msg_body = "Unknown result";
                var msg_type = "danger";

                if (r.result){
                    msg_title = "Success!";
                    msg_body = r.message;
                    msg_type = 'success';

                    //msg_body = (r.operation == "insert") ? "User create succeed." : "User update succeed.";
                }else{
                    msg_title = "Failed!";
                    msg_body = r.message;
                    msg_type = 'danger';

                    //msg_body = (r.operation == "insert") ? "User create failed." : "User update failed.";
                }

                $.bootstrapGrowl('<h4>' + msg_title + '</h4> <p>' + msg_body + '</p>', {
                    type: msg_type,
                    delay: 2500,
                    allow_dismiss: true
                });

                dt.ajax.reload();
                dt.draw();
			}
		});
	});

    $('#btn-reset').on('click', function (e){
        $('#form-main').trigger('reset');

        $("#gender").val('').trigger("chosen:updated");
        $("#designation").val('').trigger("chosen:updated");
        $("#location").val('').trigger("chosen:updated");
        $("#department").html('<option value=""></option>').trigger("chosen:updated");
        $("#cost_center").val('').trigger("chosen:updated");
        $("#status").val('1').trigger("chosen:updated");

        $('#id').val('0');
        $('#obj_id').val('0');

        $('#photo').prop('src','profile_pix/avatar_guest.jpg');
    });

    $('#toggle-uploader').on('click', function (){
        if ($('#obj_id').val() > 0){
            $('#modal-upload').modal('show');
        }else{
            $.bootstrapGrowl('<h4>Warning!</h4> <p>Please save or select an employee before try to upload the image</p>', {
                type: 'warning',
                delay: 2500,
                allow_dismiss: true
            });
        }
    });

    $('#modal-upload').on('shown.bs.modal', function (e) {
        Dropzone.forElement("#uploader").removeAllFiles(true);
    });

    $('#modal-upload').on('hide.bs.modal', function (e) {
        Dropzone.forElement("#uploader").removeAllFiles(true);
    });

    Dropzone.options.uploader = {
        method: 'post',
        uploadMultiple: false,
        resizeWidth: 200,
        resizeMimeType: 'image/jpeg',
        resizeMethod: 'resizeWidth',
        maxFiles: 1,
        acceptedFiles: 'image/*',
        dictDefaultMessage: 'Drop image here',
        success: function (r){
            $.bootstrapGrowl('<h4>Success!</h4> <p>Image uploaded successfully.</p>', {
                type: 'success',
                delay: 2500,
                allow_dismiss: true
            });

            var user_id = $('#obj_id').val();

            $.ajax({
                url: 'data/data_user_profile.php',
                data: {
                    id: user_id
                },
                method: 'POST',
                dataType: 'json',
                beforeSend: function () {
                    $('#btn-upload-done').button('loading');
                    NProgress.start();
                },
                error: function (e) {
                    $.bootstrapGrowl('<h4>Error!</h4> <p>Error retrieving uploaded image</p>', {
                        type: 'danger',
                        delay: 2500,
                        allow_dismiss: true
                    });

                    $('#btn-upload-done').button('reset');
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
                        if (r.data[0].PHOTO != null){ 
                            $('#photo').prop('src',r.data[0].PHOTO + '?' + new Date().getTime());
                        }else{
                            $('#photo').prop('src','profile_pix/avatar_guest.jpg?' + new Date().getTime());
                        }
                    }

                    $('#btn-upload-done').button('reset');
                    NProgress.done();
                }
            });
        }
    };
</script>
	
<?php mysqli_close($con_main); ?>