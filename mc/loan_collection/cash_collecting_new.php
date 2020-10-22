<?php
  session_start();

  $USER_CODE =$_SESSION['USER_CODE'];
  $job_role = $_REQUEST['job_role'];
  
  if (empty($_SESSION['ACCESS_CODE']) || $_SESSION['ACCESS_CODE'] == NULL){
    header ('Location: login.php');
    exit;
  }
  
  $folder_depth = "";
  $prefix = "";
  
  $folder_depth = substr_count($_SERVER["PHP_SELF"] , "/");
  $folder_depth = ($folder_depth == false) ? 2 : (int)$folder_depth;
  
    $prefix = str_repeat("../", $folder_depth - 2);
    
    $title_suffix = "cash collecting";
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
                <i class="gi gi-podium"></i>Cash Collecting<br><small></small>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li>Cash Collecting</li>
    </ul>
    <!-- END Blank Header -->
    
  
    <div class="row">
        <div class="col-md-12">
            <!-- Basic Form Elements Block -->
            <div class="block">
                <!-- Basic Form Elements Title -->
                <div class="block-title">
          <h2>Cash Collecting</h2>
        </div>
                <!-- END Form Elements Title -->

                <!-- Basic Form Elements Content -->
                <form id="form-main" name="form-main" action="provider_crud.php" method="post"  class="form-horizontal form-bordered">  

                    <div class="form-group">                      
                        
                            <div class="col-md-4">
                              <span>Branch Name</span>
                          <select id="branch_name" name="branch_name" class="select-chosen" data-placeholder=" Branch Name"> 
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
                                </select><!--End selete branch-->   
                            </div> 

                       
                            <div class="col-md-4">
                              <span>Center</span>
                          <select id="center_name" name="center_name" class="select-chosen" data-placeholder=" Center Name"> 
                              <option></option>
                          </select><!--End center selete-->
                      </div><!--End col-md-4-->
                      <div class="col-md-4">
                        <span>Date</span>
                                        <input type="text" id="col_date" name="col_date" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd">
                        </div>          
                    </div>


                    <input type="hidden" name="loanid" id="loanid" value="0">

                    
                    <div class="table-responsive" id="dt_table">
                        <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                <th><input type="checkbox" name="select-all" id="select-all" /></th>
                                <th>Loan No</th>
                                <th>Customer Name</th>
                                <th>Customer NIC</th>
                                <th>Loan Amount</th>
                                <th>Premium</th>
                                <th>Date</th>
                                </tr>
                            </thead>
                            <tbody id="doc_details">
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group form-actions">
                        <!-- <input type="hidden" name="loanid" id="loanid" value="0"/> -->
                        <input type="hidden" name="id" id="id" value="0" />

                        <!-- <input type="hidden" name="header_id" id="header_id" value="0"/> -->

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success primary-btn pull-right" id="btn_submit"><i class="fa fa-angle-right"></i> Submit</button>
                            <button type="reset" class="btn btn-warning" id="btn_reset"><i class="fa fa-repeat"></i> Reset</button>

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
                            <!-- <button type="button" class="btn btn-info" id="btn_print"><i class="fa fa-file-pdf-o"></i> Print</button> -->
                        </div>
                    </div>
                </form>
                <!-- END Basic Form Elements Block -->
        </div>
            <!-- END Example Content -->
        </div>
        <!-- END Example Block -->
    </div>
<!-- END Page Content -->

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
</div>

<?php include $prefix.'page_footer.php'; ?>
<?php include $prefix.'template_scripts.php'; ?>
<?php include $prefix.'template_end.php'; ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="../js/jquery.alphanum-master/jquery.alphanum-master/jquery.alphanum.js" type="text/javascript"></script>

<script type="text/javascript">


  $('#select-all').click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $(':checkbox').each(function() {
            this.checked = true;                        
        });
    } else {
        $(':checkbox').each(function() {
            this.checked = false;                       
        });
    }
});


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

 App.datatables();

    var dt = $('#table-data').DataTable({
        "processing": true,
        "serverSide": true,
        "select": true,
        "columns": [
            { "data": "loanid", "name": "loanid", "title":"Loan No"}, //0
            { "data": "nic", "name": "nic", "title":"NIC"},//2
            { "data": "name_full", "name": "name_full", "title":"Customer Name"},//2
             { "data": "net_payment", "net_payment": "total", "title":"Loan Amount"},
             { "data": "paid", "name": "paid", "title":"Payment Received"},//4
               { "data": "today", "name": "today", "title":"Date"},//6
                { "data": "status", "name": "status", "title":"Status"},//6
            {"data": "actions", "name": "actions","title":"Actions", "searchable": false, "orderable": false, 
                mRender: function (data, type, row) {
                    return '<div class="btn-group btn-group-xs"><button id="btn-row-edit" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></button></div>'
                }//4
            }
        ],
        "columnDefs":[
            {"className": "dt-center", "targets": [0,1,2,3,4,5,6]}
        ],
        "language": {
            "emptyTable": "No expenses to show..."
        },
        "ajax": "data/grid_data_cash_collecting.php"
    });
  
    $('.dataTables_filter input').attr('placeholder', 'Search');

    $("#table-data tbody").on('click', '#btn-row-edit', function() {
        var str_id = $(this).closest('tr').attr('id');
        var arr_id = str_id.split("_");

        var row_id = arr_id[1];
     // alert (row_id);

        $.ajax({
            url: 'data/cash_collecting_edit.php',
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
                      $('#id').val(r.data[0].ID);                 
                      $('#status').val(r.data[0].status); 
                      $('#status').trigger("chosen:updated");
                      $('#loandate').val(r.data[0].loan_date);
                      $('#nic').val(r.data[0].customer_id);
                      $('#paid').val(r.data[0].paid);
                      //  $('#cash_name').val(r.data[0].CASHNAME);
                      //  $('#cash_day').val(r.data[0].CASHDAY);                                                                              
                }

                $('#table-data tbody #'+str_id+' #btn-row-edit').button('reset');
                NProgress.done();
            }
        });
    });

    $('#col_date').on('change',function(){
      var col = $('#col_date').val();

      $('.date_pick').val(col);
    }); 
  //   /*********** Table Control End ***********/ 


   
     $('#branch_name').on('change',function(){

      var brval = $('#branch_name').val();
      $.ajax({
        url: 'data/data-branch.php',
        data: {
          branch : brval
        },
        method: 'POST',
        dataType: 'json',
        error: function (e){
          console.error(e);
        },
        success: function (r){
          if(r.result){
            if(r.data.length>0){
             
             $.each(r.data,function(k,v){
                let om = "";
                om += "<option value='"+v.center_id+"'>";
                om += v.center_name;
                om += "</option>";

                $('#center_name').append(om);
             });     
            }
          }
          $('#center_name').trigger("chosen:updated")
        }
      });
  });



  
     App.datatables();

    $(document).ready(function () {
      $('#dtBasicExample').DataTable();
      $('.dataTables_length').addClass('bs-select');
    });

    $('#dtBasicExample').DataTable( {
    fixedHeader: true
} );
    
    window.setInterval(()=>{
        $('#doc_details tr').each(function(){
                
           var name_full = $(this).find('td:eq(4)').html();
           var nic = $(this).find('td:eq(9)').html();
          
           if(nic == name_full){
             $(this).find('td input:eq(3)').attr("readonly", "readonly");
             $(this).find('td input:eq(4)').val(1);  
           }
        });

    },500);

   
    $('#center_name').on('change',function(){
        var table = $('#dtBasicExample').DataTable();
        table.clear().draw();
        // $('#dtBasicExample tbody').empty();
        var center_id = $('#center_name').val();
       // $('#collector').val(0);
        $.ajax({
            url: 'data/data-branch-.php',
            data: {
               center_id : center_id
            },
            method: 'post',
            error: function(e){
                alert ('Error requesting data');
            },


            success: function(r){
               // $('#id').html("Advance Balance <strong>"+r.data[0].id+' '+r.data[0].id+'</strong>');
               $('#name_full').val(r.data[0].name_full);
               $('#nic').val(r.data[0].nic);


                $.each(r.data, function (k, v){
                  table.row.add(['<input type="checkbox" name="loanid" id="loanid">',v.loanno,v.name_full,v.nic,'<input type="text" name="net_payment" id="net_payment"  class="form-control OnlyNumber" placeholder="Amount" value="'+v.net_payment+'" readonly>','<input type="text" name="paid" id="paid" value="'+v.due_amount+'" class="form-control" placeholder="Premium">','<input type="date" name="today" id="today" value="" class="form-control input-datepicker date_pick" data-date-format="yyyy-mm-dd">']).draw(false);
                });

               table.draw();
            }
        });
      
    });

    /*********** Form Validation and Submission ***********/
  $('#btn_submit').on('click', function (e){
     e.preventDefault();
   //  $('#btn_submit').prop('disabled',true);

     var formdata = $('#form-main').serialize();
     $.ajax({
       url: 'cash_collecting_crud.php',
       data: formdata,
       success: function(r){
           var id = r.id;
           $('#id').val(r.id);
           var no_of_rows = 0;
           var count = 0;

           $("#dtBasicExample input[type=checkbox]:checked").each(function (){
              no_of_rows++;
           });

           $('#dtBasicExample').DataTable().destroy();
    
           $("#dtBasicExample input[type=checkbox]:checked").each(function () {
               row = $(this).closest("tr");
               
               var loanid = $(row).find('td:eq(1)').html();
               var name_full = $(row).find('td:eq(2)').html();
               var nic = $(row).find('td:eq(3)').html();
               var net_payment = $(row).find('td input:eq(1)').val();
               var paid = $(row).find('td input:eq(2)').val();
               var today = $(row).find('td input:eq(3)').val();
               var op = 'insert';
               var branch_name = $('#branch_name').val();
               var center_name = $('#center_name').val();

               $.ajax({
                    
                   url: 'cash_collecting_crud.php',
                   data: {
                       operation : op,
                       loanid : loanid,
                       name_full : name_full,
                       nic : nic,
                       net_payment : net_payment,
                       paid : paid,
                       today : today,
                       branch_name : branch_name,
                       center_name : center_name
                   },
                   
                   success: function(r){
                       count++;
                       if(count == no_of_rows){
                          swal("Success","Cash Collecting success");
                          // window.setTimeout(function(){location.reload()},3000)
                       }
                   }
               });                 
           });
         $('#dtBasicExample').DataTable();
       }
     });
       $('#btn_submit').prop('disabled',false);
  });

    $('#btn_reset').on('click', function(){
        location.reload();
    });



   $('#dtBasicExample').on('click', 'input[type="checkbox"]', function() {
       if($(this).is(':checked')){
         row = $(this).closest("tr");
         $(row).find('td input:eq(5)').removeAttr("readonly");
         $(row).find('td input:eq(1)').removeAttr("readonly");
       }else{
         $(row).find('td input:eq(5)').attr("readonly", "readonly");
         $(row).find('td input:eq(1)').attr("readonly", "readonly");
       }
   });    
    /*********** Form Control End ***********/


    //    var dt = $('#table-data').DataTable({
    //     "processing": true,
    //     "serverSide": true,
    //     "select": true,
    //     "columns": [
    //         { "data": "id", "name": "id", "title": "ID" },
    //         { "data": "set_no", "name": "set_no", "title": "Settlement No" },
    //         { "data": "cus", "name": "cus", "title": "Customer" },
    //         { "data": "set_by", "name": "set_by", "title": "Settled By" },
    //         { "data": "set_date", "name": "set_date", "title": "Settled Date" },
    //         {"data": "actions", "name": "actions","title":"Actions", "searchable": false, "orderable": false, 
    //             mRender: function (data, type, row) {
    //                 return '<div class="btn-group btn-group-xs"><button id="btn-row-edit" class="btn btn-primary" title="Edit"><i class="fa fa-file-pdf-o"></i></button></div>'
    //             }
    //         }
    //     ],
    //     "columnDefs":[
    //         {"className": "dt-center", "targets": [0,1,2,3,4,5]}
    //     ],
    //     order:[[0,"desc"]],
    //     "language": {
    //         "emptyTable": "No data to show..."
    //     },
    //     "ajax": "data/grid_data_settlements.php"
    // });
  
    $('.dataTables_filter input').attr('placeholder', 'Search');

    // $("#table-data tbody").on('click', '#btn-row-edit', function() {
    //     var str_id = $(this).closest('tr').attr('id');
    //     var arr_id = str_id.split("_");
    //     var row_id = arr_id[1];
    //     window.open("tcpdf/examples/settlement_report.php?id="+row_id);
    // });
    
  </script>
  
  <?php mysqli_close($con_main); ?>