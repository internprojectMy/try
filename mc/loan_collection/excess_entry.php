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
                <i class="gi gi-podium"></i>Excess entry Master<br><small>Create, Update or Delete Expenses</small>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li><li>Excess Entry</li></li>
    </ul>
    <!-- END Blank Header -->
        
    
    <div class="row">
        <div class="col-md-12">
            <!-- Basic Form Elements Block -->
            <div class="block">
                <!-- Basic Form Elements Title -->
                <div class="block-title">
                    <h2>Excess Entry</h2>
                </div>
                <!-- END Form Elements Title -->

                <!-- Basic Form Elements Content -->
                <form id="form-main" name="form-main" action="provider_crud.php" method="post"  class="form-horizontal form-bordered">

                <div class="form-group">
                    <label class="col-md-2 control-label" for="category">Amount</label>
                    <div class="col-md-4">
                      <input type="text" id="category" name="category" class="form-control" placeholder="Enter Amount">  
                      </div> 

                        <label class="col-md-2 control-label" for="subject">Subject</label>
                        <div class="col-md-4">
                           <textarea class="form-control" id="text" name="text" ></textarea>
                        </div>
                </div>

                  <div class="form-group">

                 <label class="col-md-2 control-label" for="date">Date</label>
                         <div class="col-md-4">
                     <input type="text" id="date" name="date" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd">  
                      </div> 

                        <label class="col-md-2 control-label" for="status">Status</label>
                        <div class="col-md-4">
                            <select id="status" name="status" class="select-chosen"> 
                                   <option value="1">Active</option>
                                   <option value="0">Inactive</option>
                               </select><!--End select-->
                        </div><!--End col-md-4-->
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



    /*********** Table Control End ***********/

    /*********** Form Validation and Submission ***********/
    $('#form-main').on('submit', function (e){
        e.preventDefault();
        
        var id = $('#id').val();
        var op = (id == 0) ? "insert" : "update";
        
        var formdata = $('#form-main').serializeArray();
        formdata.push({'name':'operation','value':op});

        var cat = $('#category').val();

        if(cat == ""){

             document.getElementById('category').style.borderColor = "red";
             document.getElementById('category').value = "CATEGORY TYPE IS REQUIRED";
             document.getElementById('category').style.color = "red";

               $('#category').mousedown(function(){

                   $('#category').val('');
                   document.getElementById("category").style.color = "black";
               });
        }


        else if(cat!="CATEGORY TYPE IS REQUIRED"){

                 document.getElementById('category').style.borderColor = "";
                 $('#btn_submit').prop('disabled', true);
                 $("i", '#btn_submit').toggleClass("fa fa-angle-right fa fa-spinner fa-spin");
            
        $.ajax({
            url: 'excess_entry_crud.php',
            data: formdata,
            success: function(r){
                var msg_typ = "info";
                var msg_txt = "";

                if (r.result){
                    msg_typ = 'success';
                    msg_txt = '<h4>Success!</h4> <p>Income Category saved</p>';

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
                   //  $('#btn_submit').prop('disabled', false);
                   // $("i", '#btn_submit').toggleClass("fa fa-spinner fa-spin fa fa-angle-right");
                    
                }
        });
      }
    });

    $('#form-main').on('reset', function (e){
        $('#id').val("0");

        $('#status').val("");
        $('#status').trigger("chosen:updated");
        $('#category').val("");
    });
    /*********** Form Control End ***********/
        
    </script>
    
    <?php mysqli_close($con_main); ?>