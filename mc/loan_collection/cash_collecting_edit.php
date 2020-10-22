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
    
    $title_suffix = "Cash Collecting";
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
                <i class="gi gi-user_add"></i>Cash Collecting<br><small>Create, Update or Remove Customers</small>
            </h1>
        </div>
    </div>

    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li>Cash Collecting</li>
    </ul>
    <!-- END Header -->
    <div class="row">
        <div class="col-md-12">
            <!-- Form Elements Block -->
            <div class="block">
                <!-- Form Elements Title -->
                <div class="block-title">
            <h2>Cash Collecting</h2>
        </div>
                <!-- END Form Elements Title -->

                <!-- Form Elements Content -->
                <form id="form-main" name="form-main" action="" method="post" class="form-horizontal form-bordered">


     <fieldset>
              <legend><i class="fa fa-angle-right"></i>Cash Collecting Update</legend>
                 <div class="form-group">                           
                        <label class="col-md-2 control-label" for="branch_name">Branch</label>
                            <div class="col-md-4">
                             <input type="text" id="branch_name" name="branch_name" class="form-control"  placeholder="" size="1" readonly="">
                                 
                            </div><!--End col-md-4-->

                    <label class="col-md-2 control-label" for="center_name">Center</label>

                      <div class="col-md-4">
                          <input type="text" id="center_name" name="center_name" class="form-control"  placeholder="" size="1" readonly="">
                      </div><!--End col-md-4-->
                    </div><!--End from-group-->                        
                        <div class="form-group">                           
                                <label class="col-md-2 control-label" for="loanno">Loan ID</label>
                                     <div class="col-md-4">
                                         <input type="text" id="loanid" name="loanid" class="form-control"  placeholder="" size="1" readonly="">
                                     </div><!--End col-md-4-->

                                <label class="col-md-2 control-label" for="nic">NIC</label>
                                <div class="col-md-4">
                                       <input type="text" id="nic" name="nic" class="form-control"  placeholder="" size="1" readonly="">
                                </div><!--End col-md-4-->
                        </div><!--End form-group-->

                        <div class="form-group">
                                <label class="col-md-2 control-label" for="name_full">Customer Name</label>
                                <div class="col-md-4">
                                    <input type="text" id="name_full" name="name_full" class="form-control"  placeholder="" size="1" readonly="">
                                </div><!--End col-md-4-->

                                <label class="col-md-2 control-label" for="net_payment">Loan Amount</label>
                                <div class="col-md-4">
                                    <input type="text" id="net_payment" name="net_payment" class="form-control"  placeholder="" size="1" readonly>
                                </div><!--End col-md-4-->

                                                                                               
                        </div><!--End for-group-->

                            <div class="form-group">
                                <label class="col-md-2 control-label" for="paid">Payment Received</label>
                                <div class="col-md-4">
                                    <input type="text" id="paid" name="paid" class="form-control"  placeholder="" size="1">
                                </div><!--End col-md-4-->

                                <label class="col-md-2 control-label" for="today">Date</label>
                                <div class="col-md-4">
                                        <input type="text" id="today" name="today" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="" readonly>
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

<!-- <script src="<?php //echo ($prefix); ?>js/lib/jquery.maskedinput.js"></script>
<script src="<?php //echo ($prefix); ?>js/lib/jquery.validate.js"></script>
<script src="<?php //echo ($prefix); ?>js/lib/jquery.form.js"></script>
<script src="<?php //echo ($prefix); ?>js/lib/j-forms.js"></script> -->
  
 
<!-- <script src="<?php //echo ($prefix); ?>js/lib/bootbox.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">






 
App.datatables();

    var dt = $('#table-data').DataTable({
        "processing": true,
        "serverSide": true,
        "select": true,
        "columns": [
               { "data": "branch_name", "name": "branch_name", "title":"Branch Name"},
                { "data": "center_name", "name": "center_name", "title":"Center Name"},
              { "data": "loanid", "name": "loanid", "title":"Loan ID"}, //0
             { "data": "nic", "name": "nic", "title":"NIC"}, //1
             { "data": "name_full", "name": "name_full", "title":"Customer Name"},//2
              { "data": "net_payment", "name": "net_payment", "title":"Loan Amount"},//3
                { "data": "paid", "name": "paid", "title":"Received Amount"},//4
               { "data": "today", "name": "today", "title":"Date"},//5
              

                  {"data": "actions", "name": "actions","title":"Actions", "searchable": false, "orderable": false, 
                mRender: function (data, type, row) {
                    return '<div class="btn-group btn-group-xs"><button id="btn-row-edit" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></button></div>'
                }
            }
        ],
        "columnDefs":[
            {"className": "dt-center", "targets": [0,1,2,3,4,5,6,7,8]}
        ],
        "language": {
            "emptyTable": "No expenses to show..."
        },
        "ajax": "data/gird_cash_collection_edit.php"
    });
  
    $('.dataTables_filter input').attr('placeholder', 'Search');

    $("#table-data tbody").on('click', '#btn-row-edit', function() {
        var str_id = $(this).closest('tr').attr('id');
        var arr_id = str_id.split("_");

        var row_id = arr_id[1];
     // alert (row_id);

        $.ajax({
            url: 'data/data_cash_collecting_edit.php',
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
                      $('#branch_name').val(r.data[0].branch_name); 
                      $('#center_name').val(r.data[0].center_name);                 
                      $('#loanid').val(r.data[0].loanid); 
                      $('#nic').val(r.data[0].nic);
                      $('#name_full').val(r.data[0].name_full);
                      $('#net_payment').val(r.data[0].net_payment);
                       $('#paid').val(r.data[0].paid);
                       $('#today').val(r.data[0].today);                              
                }

                $('#table-data tbody #'+str_id+' #btn-row-edit').button('reset');
                NProgress.done();
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

      // var branch_name = $('#branch_name').val();
      // var branch_code = $('#branch_code').val();
      // var center_name = $('#center_name').val();
      // var center_code = $('#center_code').val();
      // var cash_name = $('#cash_name').val();
      // var cash_day = $('#cash_day').val();
      // var status = $('#status').val();

        
            $.ajax({
            url: 'cash_collecting_crud.php',
            data: formdata,
            success: function(r){
                // var msg_typ = "info";
                // var msg_txt = "";

               
                if (r.result){
                    // msg_typ = 'success';
                    // msg_txt = '<h4>Success!</h4> <p>Center saved</p>';
                      // swal("Succes","Center Saved","success");
                      
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
                   swal("Succes","Center Saved","success");

                   dt.ajax.reload();
                dt.draw();

                 $('#form-main').trigger('reset');
                }
        });
});

    /*********** Form Control End ***********/
        
    </script>
    
    <?php mysqli_close($con_main); ?>
