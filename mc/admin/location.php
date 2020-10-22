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
    
    $title_suffix = " Location Master";
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
                <i class="gi gi-factory"></i>Location Master<br><small>Create, Update or Delete Locations</small>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li>Locations</li>
    </ul>
    <!-- END Blank Header -->	
	
    <div class="row">
        <div class="col-md-12">
            <!-- Basic Form Elements Block -->
            <div class="block">
                <!-- Basic Form Elements Title -->
                <div class="block-title">
                    <h1>Location</h1>
                </div>
                <!-- END Form Elements Title -->

                <!-- Basic Form Elements Content -->
                <form id="form-main" name="form-main" action="location_crud.php" method="post"  class="form-horizontal form-bordered" >
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="location">Location</label>
                        <div class="col-md-8">
                            <input type="text" id="location" name="location" class="form-control" placeholder="Enter location">
                            <span class="help-block">Enter location name</span>
                        </div>

                        <div class="col-md-2" align="center">
                            <a href="#modal-map" class="btn btn-lg btn-success" data-toggle="modal" title="Click to mark location on map">
                                <span class="fa-stack">
                                    <i class="fa fa-map fa-stack-2x text-info"></i>
                                    <i class="fa fa-map-marker fa-stack-1x fa-inverse text-danger"></i>
                                </span>
                            </a>
                        </div>
                    </div>

                    <fieldset>
                        <legend><i class="fa fa-angle-right"></i> Address</legend>
                        
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="line01">Address Line 01</label>
                            <div class="col-md-4">
                                <input id="line01" name="line01" class="form-control" placeholder="Enter Address Line 01" size="1">
                            </div>
                                
                            <label class="col-md-2 control-label" for="line02">Address Line 02</label>
                            <div class="col-md-4">
                                <input id="line02" name="line02" class="form-control" placeholder="Enter Address Line 02" size="1">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="line03">Address Line 03</label>
                            <div class="col-md-4">
                                <input id="line03" name="line03" class="form-control" placeholder="Enter Address Line 03" size="1">
                            </div>

                            <label class="col-md-2 control-label" for="city">City</label>
                            <div class="col-md-4">
                                <input id="city" name="city" class="form-control" placeholder="Enter City" size="1">
                            </div>
                        </div>
                    </fieldset>
                        
                    <fieldset>
                        <legend><i class="fa fa-angle-right"></i> Contacts</legend>
                        
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="tp1">Phone No 01</label>
                            <div class="col-md-4">
                                <input id="tp1" name="tp1" class="form-control" placeholder="Enter Phone 01" size="1">
                            </div>
                                
                            <label class="col-md-2 control-label" for="tp2">Phone No 02</label>
                            <div class="col-md-4">
                                <input id="tp2" name="tp2" class="form-control" placeholder="Enter Phone 02" size="1">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="fax1">Fax No 01</label>
                            <div class="col-md-4">
                                <input id="fax1" name="fax1" class="form-control" placeholder="Enter Fax 01" size="1">
                            </div>
                            
                            <label class="col-md-2 control-label" for="fax2">Fax No 02</label>
                            <div class="col-md-4">
                                <input id="fax2" name="fax2" class="form-control" placeholder="Enter Fax 02" size="1">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label" for="email">Email Address</label>
                            <div class="col-md-10">
                                <input id="email" name="email" class="form-control" placeholder="Enter Email" size="1">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend><i class="fa fa-angle-right"></i> Other</legend>

                        <div class="form-group">
                            <label class="col-md-2 control-label" for="system_specific">System Specific</label>
                            <div class="col-md-4">
                                <select id="system_specific" name="system_specific" class="select-chosen" data-placeholder="Choose System">
                                    <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                    <option value="0" selected>All Systems</option>
                                    <?php
                                        $systems_query = "SELECT
                                        MM.MOD_CODE,
                                        MM.MOD_NAME
                                        FROM
                                        mas_module AS MM
                                        WHERE
                                        MM.MAIN_MODULE = 1 AND
                                        MM.`STATUS` = 1
                                        ORDER BY
                                        MM.MOD_NAME ASC";

                                        $systems_sql = mysqli_query ($con_main, $systems_query);

                                        while ($systems = mysqli_fetch_assoc ($systems_sql)){
                                            echo ("<option value=\"".$systems['MOD_CODE']."\">".$systems['MOD_NAME']."</option>");
                                        }
                                    ?>
                                </select>
                                <span class="help-block">Select system if specific</span>
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

                    <div id="modal-map" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h3 class="modal-title">Mark Location</h3>
                                </div>
                                <div class="modal-body">
                                    <span class="label label-info"><i class="fa fa-info-circle"></i> Click on the map to set marker</span>

                                    <!-- Geolocation Block -->
                                    <div class="block full">
                                        <!-- Geolocation Title -->
                                        <div class="block-title">
                                            <h4><strong>Geolocation</strong> Map</h4>
                                        </div>
                                        <!-- END Geolocation Title -->

                                        <!-- Geolocation Content -->
                                        <div id="gmap-geolocation" class="gmap" style="height:350px;"></div>
                                        <!-- END Geolocation Content -->
                                    </div>
                                    <!-- END Geolocation Block -->

                                    <input type="hidden" name="latitude" id="latitude" value="0" />
                                    <input type="hidden" name="longitude" id="longitude" value="0" />
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Done</button>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                    <div class="form-group form-actions">
                        <input type="hidden" name="id" id="id" value="0" />

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success primary-btn pull-right"><i class="fa fa-angle-right"></i> Submit</button>
                            <button type="reset" class="btn btn-warning"><i class="fa fa-repeat"></i> Reset </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- END Basic Form Elements Block -->
        </div>
        <!-- END Example Block -->
    </div>

    <!-- Table Block -->
    <div class="block full">
        <!-- Table Title -->
        <div class="block-title">
            <h2>Locations</h2><small>Locations currently exist in the system</small>
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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6JTWfGgFgnw3MML9tyeYvkYjYQDJmIiA"></script>
<script src="<?php echo($prefix) ?>js/helpers/gmaps.min.js"></script>

<script type="text/javascript">
	/*********** Map and Map Model Initialize ***********/
    var gmapGeolocation = "";

    $('#modal-map').on('shown.bs.modal', function (e) {
        var cur_lat = $('#latitude').val();
        var cur_lng = $('#longitude').val();

        // Initialize map geolocation
        gmapGeolocation = new GMaps({
            div: '#gmap-geolocation',
            lat: cur_lat,
            lng: cur_lng,
            zoom: 12,
            scrollwheel: true,
            click: function(e) {
                $('#latitude').val(e.latLng.lat());
                $('#longitude').val(e.latLng.lng());

                add_marker (e.latLng.lat(), e.latLng.lng());
            }
        });

        if (cur_lat == 0 && cur_lng == 0){
            GMaps.geolocate({
                success: function(position) {
                    gmapGeolocation.setCenter(position.coords.latitude, position.coords.longitude);
                    gmapGeolocation.addMarker({
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                        animation: google.maps.Animation.DROP,
                        title: 'GeoLocation',
                        infoWindow: {
                            content: '<div class="text-success"><i class="fa fa-map-marker"></i> <strong>Your location!</strong></div>'
                        }
                    });
                },
                error: function(error) {
                    alert('Geolocation failed: ' + error.message);
                },
                not_supported: function() {
                    alert("Your browser does not support geolocation");
                },
                always: function() {
                    // Message when geolocation succeed
                }
            });
        }else{
            add_marker (cur_lat, cur_lng);
        }
    });

    function add_marker (lt, lg) {
        gmapGeolocation.removeMarkers();

        gmapGeolocation.addMarker({
            lat: lt,
            lng: lg
        });
    }
    /*********** Map Control End ***********/


    /*********** Data-table Initialize ***********/
    App.datatables();

    var dt = $('#table-data').DataTable({
        "processing": true,
        "serverSide": true,
        "select": true,
        "columns": [
            { "data": "location", "name": "location", "title": "Location" },
            { "data": "city", "name": "city", "title": "City" },
            { "data": "tel", "name": "tel", "title": "Tel" },
            { "data": "system_effected", "name": "system_effected", "title": "System Effected", "searchable": false, "orderable": false },
            { "data": "status", "name": "status", "title": "Status", "searchable": false, "orderable": false },
            /* ACTIONS */ 
            {	"data": "actions", "name": "actions","title":"Actions", "searchable": false, "orderable": false, 
                mRender: function (data, type, row) {
                    return '<div class="btn-group btn-group-xs"><button id="btn-row-edit" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></button></div>'
                }
            }
        ],
        "columnDefs": [
            {"className": "dt-center", "targets": [3,4,5]}
        ],
        "language": {
            "emptyTable": "No locations to show..."
        },
        "ajax": "data/grid_data_location.php"
    });

    $('.dataTables_filter input').attr('placeholder', 'Search');

    $("#table-data tbody").on('click', '#btn-row-edit', function() {
        var str_id = $(this).closest('tr').attr('id');
        var arr_id = str_id.split("_");

        var row_id = arr_id[1];

        $.ajax({
            url: 'data/data_location.php',
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
                $.bootstrapGrowl('<h4>Error!</h4> <p>Error retrieving location data</p>', {
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
                    $('#id').val(r.data[0].LOC_CODE);
                    $('#location').val(r.data[0].LOCATION);
                    $('#line01').val(r.data[0].ADDRESS_LINE1);
                    $('#line02').val(r.data[0].ADDRESS_LINE2);
                    $('#line03').val(r.data[0].ADDRESS_LINE3);
                    $('#city').val(r.data[0].CITY);
                    $('#tp1').val(r.data[0].TEL1);
                    $('#tp2').val(r.data[0].TEL2);
                    $('#fax1').val(r.data[0].FAX1);
                    $('#fax2').val(r.data[0].FAX2);
                    $('#email').val(r.data[0].EMAIL);

                    $('#system_specific').val(r.data[0].SYSTEM_ID);
                    $('#system_specific').trigger("chosen:updated");

                    $('#status').val(r.data[0].STATUS);
                    $('#status').trigger("chosen:updated");

                    $('#latitude').val(r.data[0].LATITUDE);
                    $('#longitude').val(r.data[0].LONGITUDE);
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
			url: 'location_crud.php',
			data: formdata,
			success: function(r){
                var msg_typ = "info";
                var msg_txt = "";

                if (r.result){
                    msg_typ = 'success';
                    msg_txt = '<h4>Success!</h4> <p>Location saved</p>';

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
        $('#longitude').val("0");
        $('#latitude').val("0");
        $('#id').val("0");

        $('#system_specific').val(0);
        $('#system_specific').trigger("chosen:updated");

        $('#status').val(1);
        $('#status').trigger("chosen:updated");
    });
    /*********** Form Control End ***********/
</script>
	
<?php mysqli_close($con_main); ?>