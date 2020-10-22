<?php
	session_start();
	
	if (empty($_SESSION['ACCESS_CODE']) || $_SESSION['ACCESS_CODE'] == NULL){
		header ('Location: login.php');
		exit;
	}
	
	$folder_depth = "";
	$prefix = "";
   // $title_suffix = "";
	
	$folder_depth = substr_count($_SERVER["PHP_SELF"] , "/");
	$folder_depth = ($folder_depth == false) ? 2 : (int)$folder_depth;
	
    $prefix = str_repeat("../", $folder_depth - 2);
    
    $title_suffix = " Module Master";
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
                <i class="gi gi-cogwheels"></i>Module Master<br><small>Create, Update or Delete Modules</small>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li>Modules</li>
    </ul>
    <!-- END Blank Header -->
		
	
    <div class="row">
        <div class="col-md-12">
            <!-- Basic Form Elements Block -->
            <div class="block">
                <!-- Basic Form Elements Title -->
                <div class="block-title">
					<h2>Module</h2>
				</div>
                <!-- END Form Elements Title -->

                <!-- Basic Form Elements Content -->
                <form id="form-main" name="form-main" action="module_crud.php" method="post"  class="form-horizontal form-bordered" >
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="mod_name">Module</label>
                        <div class="col-md-4">
                            <input id="mod_name" name="mod_name" class="form-control" placeholder="Enter Module">
                            <span class="help-block">Name of the module</span>
                        </div>

                        <label class="col-md-2 control-label" for="check_code">Validation Code</label>
                        <div class="col-md-4">
                            <input id="check_code" name="check_code" class="form-control" placeholder="Enter Code">
                            <span class="help-block">Unique code for the module</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="url">URL</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon"><?php echo ($company['MAIN_DOC_PATH']); ?></span>
                                <input id="url" name="url" class="form-control" placeholder="Enter URL">
                            </div>
                            <span class="help-block">URL relative to document root</span>
                        </div>

                        <label class="col-md-2 control-label" for="menu_url">Internal Menu URL</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon"><?php echo ("&ltmodule url>"); ?></span>
                                <input id="menu_url" name="menu_url" class="form-control" placeholder="Enter Menu URL">
                            </div>
                            <span class="help-block">URL relative to module root</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="icon">Icon</label>
                        <div class="col-md-4">
                            <input id="icon" name="icon" class="form-control icp icp-auto" placeholder="Pick or enter icon code">
                            <span class="help-block">Pick an icon or enter icon code here. Ex: <code>fa-user</code></span>
                        </div>

                        <label class="col-md-2 control-label" for="menu_level">Menu Depth</label>
                        <div class="col-md-4">
                            <select id="menu_level" name="menu_level" class="select-chosen" data-placeholder="Choose Depth">
                                <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                            <span class="help-block">Depth in main expandable menu</span>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-1">
                            <label class="switch switch-primary"><input type="checkbox" name="is_in_menu" id="is_in_menu" value="1"><span></span></label>
                            <span class="help-block">Is display in menu?</span>
                        </div>

                        <div class="col-md-3 col-md-offset-1">
                            <label class="switch switch-primary"><input type="checkbox" name="is_main_module" id="is_main_module" value="1"><span></span></label>
                            <span class="help-block">Is main/parent module?</span>
                        </div>

                        <div class="col-md-3 col-md-offset-1">
                            <label class="switch switch-primary"><input type="checkbox" name="is_openable" id="is_openable" value="1"><span></span></label>
                            <span class="help-block">Is openable in menu?</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="parent_module">Parent Module</label>
                        <div class="col-md-4">
                            <select id="parent_module" name="parent_module" class="select-chosen" data-placeholder="Choose Parent Module">
                                <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
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
            <h2>Modules</h2><small>Modules currently exist in the system</small>
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
<link href="<?php echo($prefix) ?>css/fontawesome-iconpicker.min.css" rel="stylesheet">
<script src="<?php echo($prefix) ?>js/vendor/fontawesome-iconpicker.min.js"></script>

<script type="text/javascript">
    $('.icp-auto').iconpicker();

	/*********** Data-table Initialize ***********/
    App.datatables();

    var dt = $('#table-data').DataTable({
        "processing": true,
        "serverSide": true,
        "select": true,
        "columns": [
			{ "data": "module", "name": "module", "title": "Module" },
			{ "data": "check_code", "name": "check_code", "title": "Validation Code" },
			{ "data": "parent_module", "name": "parent_module", "title": "Parent Module" },
            { "data": "status", "name": "status", "title": "Status", "searchable": false, "orderable": false },
            /* ACTIONS */ 
             {	"data": "actions", "name": "actions","title":"Actions", "searchable": false, "orderable": false, 
                mRender: function (data, type, row) {
                    return '<div class="btn-group btn-group-xs"><button id="btn-row-edit" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></button></div>'
                }
            }
        ],
        "columnDefs": [
            {"className": "dt-center", "targets": [1,2,3,4]}
        ],
        "language": {
            "emptyTable": "No modules to show..."
        },
        "ajax": "data/grid_data_module.php"
    });
	
    $('.dataTables_filter input').attr('placeholder', 'Search');

    $("#table-data tbody").on('click', '#btn-row-edit', function() {
        var str_id = $(this).closest('tr').attr('id');
        var arr_id = str_id.split("_");

        var row_id = arr_id[1];

        $.ajax({
            url: 'data/data_module.php',
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
                $.bootstrapGrowl('<h4>Error!</h4> <p>Error retrieving module data</p>', {
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
                    var icon_str_full = r.data[0].ICON;
                    var icon_split_array = icon_str_full.split(" ",2);
                    var icon_code = icon_split_array[1];
                    var menu_level = r.data[0].MENU_LEVEL;
                    var parent_mod_code = r.data[0].PARENT_MODULE_CODE;

                    $('#id').val(r.data[0].ID);
                    $('#mod_name').val(r.data[0].MODULE_NAME);
                    $('#check_code').val(r.data[0].CHECK_CODE);
                    $('#url').val(r.data[0].URL);
                    $('#menu_url').val(r.data[0].INTERNAL_MENU_URL);
                    $('#icon').val(icon_code);
                    $('#menu_level').val(menu_level).trigger("chosen:updated");
                    $('#status').val(r.data[0].STATUS).trigger("chosen:updated");

                    var is_in_menu = (r.data[0].IS_IN_MENU == 1) ? true : false;
                    var is_main = (r.data[0].IS_MAIN == 1) ? true : false;
                    var is_openable = (r.data[0].IS_OPENABLE == 1) ? true : false;

                    $('#is_in_menu').prop('checked',is_in_menu);
                    $('#is_main_module').prop('checked',is_main);
                    $('#is_openable').prop('checked',is_openable);

                    menu_level = (menu_level > 1) ? menu_level - 1 : menu_level;

                    $.ajax({
                        url: 'data/data_module.php',
                        data: {
                            menu_level: menu_level,
                            status: 1
                        },
                        error: function(e){
                            $.bootstrapGrowl('<h4>Error!</h4> <p>Error retrieving parent modules</p>', {
                                type: 'danger',
                                delay: 2500,
                                allow_dismiss: true
                            });
                        },
                        success: function(r){
                            $('#parent_module').html("<option></option>").trigger("chosen:updated");

                            var op = r.data;

                            $.each(op, function (K,L) {
                                $('#parent_module').append("<option value='"+L.ID+"'>"+L.MODULE_NAME+"</option>").trigger("chosen:updated");
                            });
                            
                            $('#parent_module').val(parent_mod_code).trigger("chosen:updated");
                        }
                    });
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
			url: 'module_crud.php',
			data: formdata,
            error: function (e){
                $.bootstrapGrowl('<h4>Error!</h4> <p>Error saving module data</p>', {
                    type: 'danger',
                    delay: 2500,
                    allow_dismiss: true
                });
            },
			success: function(r){
				var msg_typ = "info";
                var msg_txt = "";

                if (r.result){
                    msg_typ = 'success';
                    msg_txt = '<h4>Success!</h4> <p>'+r.message+'</p>';

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

    $('#menu_level').on('change', function (e) {
        var menu_lvl = $('#menu_level').val();

        if (menu_lvl == "" || menu_lvl == null || menu_lvl == "0") return;

        menu_lvl = menu_lvl - 1;
        
        $('#parent_module').html("<option></option>").trigger("chosen:updated");

        if (menu_lvl == "0") return;

        $.ajax({
			url: 'data/data_module.php',
			data: {
                menu_level: menu_lvl,
                status: 1
            },
            error: function(e){
                $.bootstrapGrowl('<h4>Error!</h4> <p>Error retrieving parent modules</p>', {
                    type: 'danger',
                    delay: 2500,
                    allow_dismiss: true
                });
            },
			success: function(r){
                $('#parent_module').html("<option></option>").trigger("chosen:updated");

                var op = r.data;

                $.each(op, function (K,L) {
                    $('#parent_module').append("<option value='"+L.ID+"'>"+L.MODULE_NAME+"</option>").trigger("chosen:updated");
                });
            }
        });
    });

    $('#form-main').on('reset', function (e){
        $('#id').val("0");

        $('#menu_level').val("").trigger("chosen:updated");
        $('#parent_module').html("<option></option>").trigger("chosen:updated");

        $('#status').val(1);
        $('#status').trigger("chosen:updated");
    });
    /*********** Form Control End ***********/
		
	</script>
	
	