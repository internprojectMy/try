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
                <i class="gi gi-user_add"></i>Branch Profile<br><small>Create, Update or Remove branch</small>
            </h1>
        </div>
    </div>

    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li>Branch Profiles</li>
    </ul>
    <!-- END Header -->

    <div class="row">

        <div class="col-md-12">
            <!-- Form Elements Block -->
            <div class="block">
                <!-- Form Elements Title -->
                <div class="block-title">
            <h2>Branch</h2>
        </div>
                <!-- END Form Elements Title -->

                <!-- Form Elements Content -->
                <form id="form-main" name="form-main" action="" method="post" class="form-horizontal form-bordered">


     <fieldset>
              <legend><i class="fa fa-angle-right"></i>Branch Details</legend>        
                        <div class="form-group">                           
                                <label class="col-md-2 control-label" for="branch_name">Branch name</label>
                                     <div class="col-md-4">
                                        <input type="text" id="branch_name" name="branch_name" class="form-control"  placeholder="Branch Name" size="1">
                                        <!-- <div class="error error_branch_name" id="error_branch_name"></div> -->
                                     </div><!--End col-md-4-->

                                <label class="col-md-2 control-label" for="branch_code">Branch Code</label>
                                <div class="col-md-4">
                                     <input type="text" id="branch_code" name="branch_code" class="form-control"  placeholder="Branch Code" size="1">
                                </div><!--End col-md-4-->
                        </div><!--End form-group-->

                        <div class="form-group">
                                <label class="col-md-2 control-label" for="branch_comment">Comment</label>
                                <div class="col-md-4">
                                    <textarea class="form-control" id="branch_comment" name="branch_comment"></textarea>
                                </div><!--End col-md-4-->

                                <label class="col-md-2 control-label" for="branch_date">Date</label>
                                    <div class="col-md-4">
                                        <input type="text" id="branch_date" name="branch_date" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd">
                                  </div><!--End col-md-4-->                                                                   
                        </div><!--End for-group-->
                         
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
                           <button type="reset" id="btn-reset" class="btn btn-warning"><i class="fa fa-repeat"></i>New</button>
                        </div><!--End col-md-12-->
                    </div><!--End form-group-->

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
</div>


<?php include $prefix.'page_footer.php'; ?>
<?php include $prefix.'template_scripts.php'; ?>
<?php include $prefix.'template_end.php'; ?>



<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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

//CENTER DATA VIEW 
  App.datatables();

    var dt = $('#table-data').DataTable({
        "processing": true,
        "serverSide": true,
        "select": true,
        "columns": [
            { "data": "branch_name", "name": "branch_name", "title":"Branch Name"}, //0
            { "data": "branch_code", "name": "branch_code", "title":"Branch code"}, //1
            { "data": "branch_comment", "name": "branch_comment", "title":"Branch Comment"},//2
            { "data": "branch_date", "name": "branch_date", "title": "Date" },//3
       
        ],
        "columnDefs":[
            {"className": "dt-center", "targets": [0,1,2]}
        ],
        "language": {
            "emptyTable": "No expenses to show..."
        },
        "ajax": "data/grid_data_branch.php"
    });
  
    $('.dataTables_filter input').attr('placeholder', 'Search');

    $("#table-data tbody").on('click', '#btn-row-edit', function() {
        var str_id = $(this).closest('tr').attr('id');
        var arr_id = str_id.split("_");

        var row_id = arr_id[1];
    

        $.ajax({
            url: 'data/data-branch.php',
            data: {
                branch_id: row_id
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
                      $('#branch_name').val(r.data[0].NAME);
                      $('#branch_code').val(r.data[0].CODE);
                      $('#branch_comment').val(r.data[0].COMMENT);                                                                              
                }

                $('#table-data tbody #'+str_id+' #btn-row-edit').button('reset');
                NProgress.done();
            }
        });
    });
    /*********** Table Control End ***********/

    $('#form-main').on('submit', function (e){

        e.preventDefault();
         var id = $('#id').val();
         var op = (id == 0) ? "insert" : "update";
         var validation = false;

         var formdata = $('#form-main').serializeArray();
         formdata.push({'name':'operation','value':op});

      var branch_name = $('#branch_name').val();
      var branch_code = $('#branch_code').val();
      var branch_comment = $('#branch_comment').val();
      var branch_date = $('#branch_date').val();
      var status = $('#status').val();

if(branch_name == "" || branch_code == "" ){
   
   //BRANCH NAME VALIDATE
     if(branch_name == ""){

        document.getElementById('branch_name').style.borderColor = "red";
        document.getElementById("branch_name").value = "BRANCH NAME IS REQUIRED";
        document.getElementById("branch_name").style.color = "red";

          $("#branch_name").mousedown(function(){
              
              $('#branch_name').val('');
              document.getElementById('branch_name').style.borderColor = "blue";
              document.getElementById("branch_name").style.color = "black";
          });

     }

    
    //BRANCH CODE VALIDATE
      if(branch_code == ""){

      document.getElementById('branch_code').style.borderColor = "red";
      document.getElementById("branch_code").value = "BRANCH CODE IS REQUIRED";
      document.getElementById("branch_code").style.color = "red";

      $("#branch_code").mousedown(function(){

        $('#branch_code').val('');
        document.getElementById('branch_code').style.borderColor = "blue";
        document.getElementById("branch_code").style.color = "black";
      });
    }


      //BRANCH DATA VALIDATE
      if(branch_date == ""){

      document.getElementById('branch_date').style.borderColor = "red";
      document.getElementById("branch_date").value = "DATE REQUIRED";
      document.getElementById("branch_date").style.color = "red";

      $("#branch_date").mousedown(function(){

        $('#branch_date').val('');
        document.getElementById('branch_date').style.borderColor = "blue";
        document.getElementById("branch_date").style.color = "black";
      });
    }
}
 
else if(branch_name!="BRANCH NAME IS REQUIRED" || branch_code!="BRANCH CODE IS REQUIRED"){

        document.getElementById('branch_name').style.borderColor = "";
        document.getElementById('branch_code').style.borderColor = "";
        document.getElementById('branch_date').style.borderColor = "";
            // $('#btn_submit').prop('disabled', true);
            // $("i", '#btn_submit').toggleClass("fa fa-angle-right fa fa-spinner fa-spin");
        
       $.ajax({
      url: 'branch_crud.php',
      data: formdata,
      success: function(r){
        var msg_typ = "info";
                var msg_txt = "";

                if (r.result){
                    msg_typ = 'success';
                    msg_txt = '<h4>Success!</h4> <p>Branch saved</p>';

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
        $('#branch_name').val("");
        $('#branch_code').val("");
         $('#branch_comment').val("");
    });
    /*********** Form Control End ***********/



/** ******** button disabled functions *******************************************************/
       $('#dis_button').on('click', function (e){

       if (typeof(Storage) != "undefined") {
      // Store
      sessionStorage.setItem("dis_name", "DISABLE");

      // Retrieve
      document.getElementById("disable_id").value = sessionStorage.getItem("dis_name");
         $("button[type=submit]").attr("disabled",true);
         $("#active_button").prop("disabled",false);
         $("#dis_button").prop("disabled",true);


    } else {
      document.getElementById("disable_id").value = "Sorry";
    }
  
    });
/** ******** end button disabled functions *******************************************************/

/** ******** button active functions *******************************************************/       
       $('#active_button').on('click', function (e){

        console.log(sessionStorage.getItem("dis_name"));

        sessionStorage.removeItem('dis_name');

        console.log(sessionStorage.getItem("dis_name"));
         document.getElementById("disable_id").value = sessionStorage.getItem("dis_name");
        $("button[type=submit]").attr("disabled",false);
        $("#active_button").prop("disabled",true);
        $("#dis_button").prop("disabled",false);

    });

 /** ******** end button active functions *******************************************************/   
     
    </script>
    
  <?php mysqli_close($con_main); ?>
