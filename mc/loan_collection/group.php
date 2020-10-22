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
                <i class="gi gi-user_add"></i>Group Profile<br><small>Create, Update or Remove Customers</small>
            </h1>
        </div>
    </div>

    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li>Group Profiles</li>
    </ul>
    <!-- END Header -->
    <div class="row">
        <div class="col-md-12">
            <!-- Form Elements Block -->
            <div class="block">
                <!-- Form Elements Title -->
                <div class="block-title">
            <h2>Group</h2>
        </div>
                <!-- END Form Elements Title -->

                <!-- Form Elements Content -->
                <form id="form-main" name="form-main" action="" method="post" class="form-horizontal form-bordered">
                   
          <fieldset>
              <legend><i class="fa fa-angle-right"></i>Group Details</legend>                          
                        <div class="form-group">                           
                                <label class="col-md-2 control-label" for="branch_name">Branch name</label>
                                     <div class="col-md-4">
                                       <select id="branch_name" name="branch_name" class="select-chosen" data-placeholder="Select Branch Name"> 
                                <option></option>
                                   <?php
                                    $query="SELECT
                                              BRA.branch_id AS ID,
                                              BRA.branch_name AS `NAME`,
                                              BRA.branch_code AS `CODE`
                                              FROM
                                              branch AS BRA
                                              WHERE
                                              BRA.`status` = 1
                                              ORDER BY
                                              `NAME` ASC";

                                    $sql = mysqli_query($con_main, $query);
                                                                            
                                    while ($branches = mysqli_fetch_assoc($sql)){
                                        echo ("<option value=\"".$branches['ID']."\">".$branches['NAME']."</option>");
                                    }
                                   ?>
                            </select>
                                     </div><!--End col-md-4-->

                                <label class="col-md-2 control-label" for="branch_code">Branch Code</label>
                                <div class="col-md-4">
                                    <input type="text" id="branch_code" name="branch_code" class="form-control"  placeholder="Branch Code" size="1" readonly="">
                                </div><!--End col-md-4-->
                        </div><!--End form-group-->

                        <div class="form-group">                           
                                <label class="col-md-2 control-label" for="center_name">Center name</label>
                                     <div class="col-md-4">
                                        <select id="center_name" name="center_name" class="select-chosen" data-placeholder="Select Center Name"> 
                                <option></option>
                            </select>
                                     </div><!--End col-md-4-->

                                <label class="col-md-2 control-label" for="center_code">Center Code</label>
                                <div class="col-md-4">
                                     <input type="text" id="center_code" name="center_code" class="form-control"  placeholder="Center Code" size="1" readonly="">      
                                        </select><!--End branch code-->
                                </div><!--End col-md-4-->
                        </div><!--End form-group-->

                         <div class="form-group">
                                <label class="col-md-2 control-label" for="group_name">Group Name</label>
                                <div class="col-md-4">
                                    <input type="text" id="group_name" name="group_name" class="form-control"  placeholder="Group Name" size="1">
                                </div><!--End col-md-4-->

                                <label class="col-md-2 control-label" for="group-code">Group Code</label>
                                <div class="col-md-4">
                                    <input type="text" id="group_code" name="group_code" class="form-control"  placeholder="Group Code" size="1">
                                </div><!--End col-md-4-->                                                                                           
                        </div><!--End for-group-->
                         
                        <div class="form-group">  
                         <label class="col-md-2 control-label" for="group_date">Date</label>
                                    <div class="col-md-4">
                                        <input type="text" id="group_date" name="group_date" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd">
                                  </div><!--End col-md-4-->   

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
                        </div><!--End col-md-12-->
                    </div><!--End from-group-->
                </form><!--End from-->
        </div>
             
        </div>
    </div>  
<div class="block full">
        <!-- Table Title -->
        <div class="block-title">
            <h2>Adds</h2><small>Leaves currently exist in the system</small>
        </div><!-- END Table Title -->
        
        <!-- Table Content -->
        <div class="table-responsive">
          <table id="table-data" class="table table-condensed table-striped table-hover"></table>
        </div><!--End table-responsive-->
    </div><!-- END Table Block --> 
    
</div><!--End containner-->
 

<?php include $prefix.'page_footer.php'; ?>
<?php include $prefix.'template_scripts.php'; ?>
<?php include $prefix.'template_end.php'; ?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-growl/1.0.6/bootstrap-growl.min.js"></script>

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



//GROUP DATA VIEW
   App.datatables();

    var dt = $('#table-data').DataTable({
        "processing": true,
        "serverSide": true,
        "select": true,
        "columns": [
            { "data": "branch_name", "name": "branch_name", "title":"Branch Name"}, //0
            { "data": "center_name", "name": "center_name", "title":"Center Name"}, //1
            { "data": "center_code", "name": "branch_code", "title":"Center code"},//2
            { "data": "group_name", "name": "group_name", "title": "group Name" },//3
            { "data": "group_code", "name": "group_code", "title": "group Code" },//4
            // {"data": "actions", "name": "actions","title":"Actions", "searchable": false, "orderable": false, 
            //     mRender: function (data, type, row) {
            //         return '<div class="btn-group btn-group-xs"><button id="btn-row-edit" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></button></div>'
            //     }//4
            // }
        ],
        "columnDefs":[
            {"className": "dt-center", "targets": [0,1,2,3,4]}
        ],
        "language": {
            "emptyTable": "No expenses to show..."
        },
        "ajax": "data/grid_data_group.php"
    });
  
    $('.dataTables_filter input').attr('placeholder', 'Search');

    $("#table-data tbody").on('click', '#btn-row-edit', function() {
        var str_id = $(this).closest('tr').attr('id');
        var arr_id = str_id.split("_");

        var row_id = arr_id[1];
     // alert (row_id);

        $.ajax({
            url: 'data/data-groups.php',
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
                      $('#branch_id').val(r.data[0].id);                 
                      $('#status').val(r.data[0].status); 
                      $('#status').trigger("chosen:updated");
                      $('#branch_name').val(r.data[0].branch_name);
                      $('#center_name').val(r.data[0].center_name);
                      $('#center_code').val(r.data[0].branch_code);
                      $('#group_name').val(r.data[0].NAME);
                      $('#group_code').val(r.data[0].CODE);                                                                              
                }

                $('#table-data tbody #'+str_id+' #btn-row-edit').button('reset');
                NProgress.done();
            }
        });
    });
    /*********** Table Control End ***********/
    

  




//CODE CODDE DISPLAY
$('#center_name').on('change', function (e){
  let center_id = $(this).val();
    
  $.ajax({
    url: 'data/data-center-code.php',
    data: {
      center_id: center_id
    },
    method: 'POST',
    dataType: 'json',
    error: function (e){
      console.error(e);
    },
    success: function (r){
      if (r.result){
        let center_code = r.data[0].CODE;

        $('#center_code').val(center_code);
      }else{
        console.error(r.debug);
      }
    }
  });
});

  //CENTER NAME DISPLAY
$('#branch_name').on('change', function (e){
  let branch_id = $(this).val();
  
  $.ajax({
    url: 'data/data-branch.php',
    data: {
      branch_id: branch_id
    },
    method: 'POST',
    dataType: 'json',
    error: function (e){
      console.error(e);
    },
    success: function (r){
      if (r.result){
        let branch_code = r.data[0].CODE;

        $('#branch_code').val(branch_code);
      }else{
        console.error(r.debug);
      }
    }
  });

  $.ajax({
    url: 'data/data-centers.php',
    data: {
      branch_id: branch_id,
      //center_id: center_id
    },
    method: 'POST',
    dataType: 'json',
    error: function (e){
      console.error(e);
    },
    success: function (r){
      $('#center_name').html('<option></option>');

      if (r.result){
        $.each(r.data, function (k, v){
          let center_name = v.NAME;
          let center_id = v.ID;
          // let center_code = center_code;
          let html = "";

          html = "<option value='"+center_id+"'>"+center_name+"</option>";

          $('#center_name').append(html);
        });
      }else{
        console.error(r.debug);
      }

      $('#center_name').trigger("chosen:updated");
    }
  });
});




    
     $('#form-main').on('submit', function (e){

        e.preventDefault();
         var id = $('#id').val();
         var op = (id == 0) ? "insert" : "update";
         var validation = false;

         var formdata = $('#form-main').serializeArray();
         formdata.push({'name':'operation','value':op});

      var branch_name = $('#branch_name').val();
      var branch_code = $('#branch_code').val();
      var center_name = $('#center_name').val();
      var center_code = $('#center_code').val();
      var group_name = $('#group_name').val();
      var group_code= $('#group_code').val();
      var group_date = $('#group_date').val();
      var status = $('#status').val();

if(branch_name == "" || branch_code == "" || center_name == "" || center_code == "" || group_name == "" || group_code == "" || group_date == ""){
   
   //CENTER NAME VALIDATE
     // if(center_name == ""){

     //    document.getElementById('center_name').style.borderColor = "red";
     //    document.getElementById("center_name").value = "CENTER NAME IS REQUIRED";
     //    document.getElementById("center_name").style.color = "red";

     //      $("#center_name").mousedown(function(){
              
     //          $('#center_name').val('');
     //          document.getElementById('center_code').style.borderColor = "blue";
     //          document.getElementById("center_name").style.color = "black";
     //      });

     // }

    
    //CENTER CODE VALIDATE
    //   if(center_code == ""){

    //   document.getElementById('center_code').style.borderColor = "red";
    //   document.getElementById("center_code").value = "CENTER CODE IS REQUIRED";
    //   document.getElementById("center_code").style.color = "red";

    //   $("#center_code").mousedown(function(){

    //     $('#center_code').val('');
    //     document.getElementById('center_code').style.borderColor = "blue";
    //     document.getElementById("center_code").style.color = "black";
    //   });
    // }

    if(group_name == ""){

      document.getElementById('group_name').style.borderColor = "red";
      document.getElementById("group_name").value = "GROUP NAME IS REQUIRED";
      document.getElementById("group_name").style.color = "red";

      $("#group_name").mousedown(function(){

        $('#group_name').val('');
        document.getElementById('group_name').style.borderColor = "blue";
        document.getElementById("group_name").style.color = "black";
      });
    }


     if(group_code == ""){

      document.getElementById('group_code').style.borderColor = "red";
      document.getElementById("group_code").value = "GROUP CODE IS REQUIRED";
      document.getElementById("group_code").style.color = "red";

      $("#group_code").mousedown(function(){

        $('#group_code').val('');
        document.getElementById('group_code').style.borderColor = "blue";
        document.getElementById("group_code").style.color = "black";
      });
    }



      if(group_date == ""){

      document.getElementById('group_date').style.borderColor = "red";
      document.getElementById("group_date").value = "DATE REQUIRED";
      document.getElementById("group_date").style.color = "red";

      $("#group_date").mousedown(function(){

        $('#group_date').val('');
        document.getElementById('group_date').style.borderColor = "blue";
        document.getElementById("group_date").style.color = "black";
      });
    }

}
 
else if(group_name!="CENTER NAME IS REQUIRED" || group_code!="CENTER CODE IS REQUIRED" || group_date!="DATE IS REQUIRED"){

        document.getElementById('group_name').style.borderColor = "";
        document.getElementById('group_code').style.borderColor = "";
        document.getElementById('group_date').style.borderColor = "";
        // $('#btn_submit').prop('disabled', true);
        // $("i", '#btn_submit').toggleClass("fa fa-angle-right fa fa-spinner fa-spin");
        
            $.ajax({
            url: 'group_crud.php',
            data: formdata,
            success: function(r){
                var msg_typ = "info";
                var msg_txt = "";

               
                if (r.result){
                    msg_typ = 'success';
                    msg_txt = '<h4>Success!</h4> <p>Group saved</p>';

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
                  // $("i", '#btn_submit').toggleClass("fa fa-spinner fa-spin fa fa-angle-right");

                  swal("Succes","Group Saved","success");

                   dt.ajax.reload();
                    dt.draw();

                    $('#form-main').trigger('reset');
                }
        });
  }
});

   
    </script>
    
    <?php mysqli_close($con_main); ?> 
