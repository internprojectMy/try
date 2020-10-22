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
                <i class="gi gi-user_add"></i>Cash Collector Profile<br><small>Create, Update or Remove Cash Collectors</small>
            </h1>
        </div>
    </div>

    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li>Cash Collector Profile</li>
    </ul>
    <!-- END Header -->
  <div class="row">
        <div class="col-md-12">
             <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                       <label class="col-md-2 control-label" for="search">Search</label>
                            <div class="col-md-9">
                                 <select name="search" id="search" style="width:100%;">
                                     <option value="" selected disabled>Select Customer ID</option>
                                </select> 
                            </div>   
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- Form Elements Block -->
            <div class="block">
                <!-- Form Elements Title -->
                <div class="block-title">
            <h2>Center</h2>
        </div>
                <!-- END Form Elements Title -->

                <!-- Form Elements Content -->
                <form id="form-main" name="form-main" action="" method="post" class="form-horizontal form-bordered">


     <fieldset>
              <legend><i class="fa fa-angle-right"></i>Cash Collector Details</legend>                          
                        <div class="form-group">                           
                                <label class="col-md-2 control-label" for="cash_name">collector name</label>
                                     <div class="col-md-4">
                                        <input type="text" id="cash_name" name="cash_name" class="form-control"  placeholder="Collector Name" size="1">
                                        <!-- <div class="error error_branch_name" id="error_branch_name"></div> -->
                                     </div><!--End col-md-4-->

                                <label class="col-md-2 control-label" for="cash_day">Collector Day</label>
                                <div class="col-md-4">
                                      <select id="cash_day" name="cash_day" class="select-chosen" data-placeholder="Select collector Day">
                                <option></option>
                                <option value="Sunday">Sunday</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                            </select>
                                </div><!--End col-md-4-->
                        </div><!--End form-group-->

                        <div class="form-group">  
                                 <label class="col-md-2 control-label" for="status">Status</label>
                        <div class="col-md-4">
                            <select id="status" name="status" class="select-chosen"> 
                                   <option value="1">Active</option>
                                   <option value="0">Inactive</option>
                               </select>
                          </div><!--End col-md-4-->
                        </div><!--End group-->
        </fieldset><!--End center-fieldset-->


          <div class="form-group form-actions">
                        <input type="hidden" name="id" id="id" value="0" />
          
                        <div class="col-md-12">
                            <button type="submit" id="btn_submit" class="btn btn-success primary-btn pull-right"><i class="fa fa-angle-right"></i> Submit</button>
                           <button type="button" id="btn-reset" class="btn btn-warning"><i class="fa fa-repeat"></i>New</button>
                        </div><!--End col-md-12-->
                    </div><!--End form-group-->
                </form><!--End form-->    
        </div><!--End block-->
             
        </div>
    </div>
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
    <!-- END Table Block -->  
</div>
 

<?php include $prefix.'page_footer.php'; ?>
<?php include $prefix.'template_scripts.php'; ?>
<?php include $prefix.'template_end.php'; ?>

<!--  DataTables CSS library -->
<!-- <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
 -->
<!-- jQuery library -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->

<!-- DataTables JS library -->
<!-- <script type="text/javascript" src="DataTables/datatables.min.js"></script> --> -->

<!-- <script src="<?php echo ($prefix); ?>js/lib/jquery.maskedinput.js"></script>
<script src="<?php echo ($prefix); ?>js/lib/jquery.validate.js"></script>
<script src="<?php echo ($prefix); ?>js/lib/jquery.form.js"></script>
<script src="<?php echo ($prefix); ?>js/lib/j-forms.js"></script> -->
  
 
<script src="<?php echo ($prefix); ?>js/lib/bootbox.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



<script type="text/javascript">

// // BRANCH DATA TABLE VIEW

App.datatables();

    var dt = $('#table-data').DataTable({
        "processing": true,
        "serverSide": true,
        "select": true,
        "columns": [
            { "data": "cash_name", "name": "cash_name", "title":"Cash Collector Name" },
            { "data": "cash_day", "name": "cash_day", "title":"Cash Collector Day" },
            {"data": "actions", "name": "actions","title":"Actions", "searchable": false, "orderable": false, 
                mRender: function (data, type, row) {
                    return '<div class="btn-group btn-group-xs"><button id="btn-row-edit" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></button></div>'
                }
            }
        ],
        "columnDefs":[
            {"className": "dt-center", "targets": [0,1,2]}
        ],
        "language": {
            "emptyTable": "No expenses to show..."
        },
        "ajax": "data/grid_data_cash.php"
    });
  
    $('.dataTables_filter input').attr('placeholder', 'Search');

    $("#table-data tbody").on('click', '#btn-row-edit', function() {
        var str_id = $(this).closest('tr').attr('id');
        var arr_id = str_id.split("_");

        var row_id = arr_id[1];
       // alert (row_id);

        $.ajax({
            url: 'data/data-cash.php',
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
                      $('#status').val(r.data[0].status); 
                      $('#status').trigger("chosen:updated");
                      $('#cash_name').val(r.data[0].cash_name);
                      $('#cash_day').val(r.data[0].cash_day);                                                                              
                }

                $('#table-data tbody #'+str_id+' #btn-row-edit').button('reset');
                NProgress.done();
            }
        });
    });
//     /*********** Table Control End ***********/
  

$('#sweet').on('click',function(){
  swal("Success","ok","success");
});

// $('#search').select2({
//             minimumInputLength:2,
//             ajax: {
//                 url: 'data/branch_select.php',
//                 dataType: 'json',
//                 delay: 100,
//                 data: function (term) {
//                   // alert(term);
//                     return term;
//                 },
//                 processResults: function (data) {
//                     return {
//                         results: $.map(data, function (item) {
//                             return {
//                                 text: branch_name,
//                                 id: branch.id
//                             }
//                         })
//                     };
//                 }
//             }
//         });


// //SEARCH IN DATA
// $('#search').on('change', function (e){
//             var branch_id = $('#search').select2('val');
//                  alert();
//             $.ajax({
//                 url: 'data/branch_set.php',
//                 data: {
//                     id: branch_id
//                 },
//                 method: 'POST',
//                 dataType: 'json',
//                 error: function (e){
//                     alert ("Something went wrong when getting Center.");
//                 },
//                 success: function (r){
//                     var result = r.result;
//                     var message = r.message;
//                     var data = r.data;

//                     if (result){
//                      $('#id').val(data.branch_id);
//                      $('#branch_name').val(data.branch_name);
//                      $('#branch_code').val(data.branch_code);
//                      $('#branch_comment').val(data.branch_comment);
//                      $('#branch_date').val(data.branch_date);
//                      $('#status').val(data.status);
//                      $('#status').trigger("chosen:updated");

//                         }else{
//                           alert (message);
//                     }
//                 }
//             });
//         });

    $('#form-main').on('submit', function (e){

        e.preventDefault();
         var id = $('#id').val();
         var op = (id == 0) ? "insert" : "update";
         var validation = false;

         var formdata = $('#form-main').serializeArray();
         formdata.push({'name':'operation','value':op});

      var cash_name = $('#cash_name').val();
      var cash_day = $('#cash_day').val();
      var status = $('#status').val();

if(cash_name == "" || cash_day == ""){
   
   //BRANCH NAME VALIDATE
     if(cash_name == ""){

        document.getElementById('cash_name').style.borderColor = "red";
        document.getElementById("cash_name").value = "COLLECTOR NAME IS REQUIRED";
        document.getElementById("cash_name").style.color = "red";

          $("#cash_name").mousedown(function(){
              
              $('#cash_name').val('');
              document.getElementById('cash_name').style.borderColor = "blue";
              document.getElementById("cash_name").style.color = "black";
          });

     }

    
    //BRANCH CODE VALIDATE
      if(cash_day == ""){

      document.getElementById('cash_day').style.borderColor = "red";
      document.getElementById("cash_day").value = "COLLECTOR DAY IS REQUIRED";
      document.getElementById("cash_day").style.color = "red";

      $("#cash_day").mousedown(function(){

        $('#cash_day').val('');
        document.getElementById('cash_day').style.borderColor = "blue";
        document.getElementById("cash_day").style.color = "black";
      });
    }

}
 
else if(cash_name!="COLLECTOR NAME IS REQUIRED" || cash_day!="COLLECTOR CODE IS REQUIRED"){

        document.getElementById('cash_name').style.borderColor = "";
        document.getElementById('cash_day').style.borderColor = "";
            // $('#btn_submit').prop('disabled', true);
            // $("i", '#btn_submit').toggleClass("fa fa-angle-right fa fa-spinner fa-spin");
        
            $.ajax({
            url: 'cash_crud.php',
            data: formdata,
            success: function(r){
                if (r.result){
                    $('#sweet').on('click',function(){
                      swal("Success","ok","success");
                    });

                  }else{
               }
                dt.ajax.reload();
                dt.draw();
           
              },
              complete: function(e) {
                   $('#sweet').on('click',function(){
  swal("Success","ok","success");
});
                 }
        });
      }
    });

   $('#form-main').on('reset', function (e){
        $('#id').val("0");

        $('#status').val("");
        $('#status').trigger("chosen:updated");
        $('#cash_name').val("");
        $('#cash_day').val("");
    });
    /*********** Form Control End ***********/
    </script>
    
  <?php mysqli_close($con_main); ?>
