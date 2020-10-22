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
                <i class="gi gi-podium"></i>Expenses<br><small>Insert Expenses</small>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li><li>Cash Collector </li></li>
    </ul>
    <!-- END Blank Header -->
		
 <!------------------------------- this section use all php pages ----------------------------------------->             
<?php 
ob_start();
session_start();

echo "<input type='hidden' id='disable_id' name='disable_id' class='form-control' value='0'>";

$session_var = "";
$_SESSION['disb_session'] = $session_var;

?>
 <!------------------------------ end section  ------------------------------------------------------------> 
    <div class="row">
        <div class="col-md-12">
            <!-- Basic Form Elements Block -->
            <div class="block">
                <!-- Basic Form Elements Title -->
                <div class="block-title">
					<h2>Cash Collector </h2>
				</div>
                <!-- END Form Elements Title -->

                <!-- Basic Form Elements Content -->
                <form id="form-main" name="form-main" action="provider_crud.php" method="post"  class="form-horizontal form-bordered">

                <div class="form-group">
                    <label class="col-md-2 control-label" for="cash_name">Cash Collector Name</label>
                        <div class="col-md-4">
                           <input type="text" id="cash_name" name="cash_name" class="form-control"  placeholder="Cash Collector Name" size="1">
                        </div> 
                             <label class="col-md-2 control-label" for="status">Status</label>
                        <div class="col-md-4">
                            <select id="status" name="status" class="select-chosen"> 
                                   <option value="1">Active</option>
                                   <option value="0">Inactive</option>
                               </select>
                          </div><!--End col-md-4-->
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

        <div class="block full">
        <!-- Table Title -->
        <div class="block-title">
            <h2>Expenses</h2><small>Expenses currently exist in the system</small>
        </div>
        <!-- END Table Title -->

        <!-- Table Content -->
        <div class="table-responsive"><table id="table-data" class="table table-condensed table-striped table-hover"></table></div>
        <!-- END Table Content -->
</div>


<?php include $prefix.'page_footer.php'; ?>
<?php include $prefix.'template_scripts.php'; ?>
<?php include $prefix.'template_end.php'; ?>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

 /*------------------------------- this js section use all php pages ----------------------------------------*/     

console.log(typeof(Storage));
console.log(sessionStorage.getItem("dis_name"));

document.getElementById("disable_id").value = sessionStorage.getItem("dis_name");


if(sessionStorage.getItem("dis_name") == "DISABLE"){
    $("button[type=submit]").attr("disabled",true);
      $("#dis_button").prop("disabled",true);
    $("#active_button").prop("disabled",false);

}else{
    $("button[type=submit]").attr("disabled",false);
    $("#dis_button").prop("disabled",false);
    $("#active_button").prop("disabled",true);
}

 /*------------------------------- end js section use all php pages ----------------------------------------*/  

     App.datatables();

    var dt = $('#table-data').DataTable({
        "processing": true,
        "serverSide": true,
        "select": true,
        "columns": [
            // { "data": "id", "name": "id", "title":"ID"}, //0
            { "data": "cash_name", "name": "cash_name", "title":"Cash Collector Name"}, //1
               { "data": "status", "name": "status", "title":"Status"},//13
            // {"data": "actions", "name": "actions","title":"Actions", "searchable": false, "orderable": false, 
            //     mRender: function (data, type, row) {
            //         return '<div class="btn-group btn-group-xs"><button id="btn-row-edit" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></button></div>'
            //     }//4
            // }
        ],
        "columnDefs":[
            {"className": "dt-center", "targets": [0,1]}
        ],
        "language": {
            "emptyTable": "No expenses to show..."
        },
        "ajax": "data/gird_cash_collection.php"
    });
  
    $('.dataTables_filter input').attr('placeholder', 'Search');

    $("#table-data tbody").on('click', '#btn-row-edit', function() {
        var str_id = $(this).closest('tr').attr('id');
        var arr_id = str_id.split("_");

        var row_id = arr_id[1];
     // alert (row_id);

        // $.ajax({
        //     url: 'data/data_cash_lending.php',
        //     data: {
        //         id: row_id
        //     },
        //     method: 'POST',
        //     dataType: 'json',
        //     beforeSend: function () {
        //         $('#table-data tbody #'+str_id+' #btn-row-edit').button('loading');
        //         NProgress.start();
        //     },
        //     error: function (e) {
        //         $.bootstrapGrowl('<h4>Error!</h4> <p>Error retrieving expenses data</p>', {
        //             type: 'danger',
        //             delay: 2500,
        //             allow_dismiss: true
        //         });

        //         $('#table-data tbody #'+str_id+' #btn-row-edit').button('reset');
        //         NProgress.done();
        //     },
        //     success: function (r) {
        //         if (!r.result) {
        //             $.bootstrapGrowl('<h4>Error!</h4> <p>'+r.message+'</p>', {
        //                 type: 'danger',
        //                 delay: 2500,
        //                 allow_dismiss: true
        //             });
        //         }else{ 
        //               $('#id').val(r.data[0].ID);                 
        //               $('#status').val(r.data[0].status); 
        //               $('#status').trigger("chosen:updated");
        //               $('#id').val(r.data[0].id);
        //               $('#cash_name').val(r.data[0].cash_name);
        //               $('#cash_day').val(r.data[0].cash_day);                                                                          
        //         }

        //         $('#table-data tbody #'+str_id+' #btn-row-edit').button('reset');
        //         NProgress.done();
        //     }
        // });
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
			url: 'cash_collection_crud.php',
			data: formdata,
			success: function(r){
				// var msg_typ = "info";
    //             var msg_txt = "";

                if (r.result){
                    //msg_typ = 'success';
                    //msg_txt = '<h4>Success!</h4> <p>Expense saved</p>';
                    swal("Succes","Transaction Expenses Saved","success");

                    dt.ajax.reload();
                        dt.draw();

                    $('#form-main').trigger('reset');
                }else{
                  
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

        $('#cash_name').val("");
        $('#status').val("");
        $('#id').val("");
    });
    /*********** Form Control End ***********/
		
	</script>
	
	<?php mysqli_close($con_main); ?>