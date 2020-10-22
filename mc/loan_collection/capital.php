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
                <i class="gi gi-podium"></i>Capital Master<br><small>Create, Update or Delete Expenses</small>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li><li>capital Category</li></li>
    </ul>
    <!-- END Blank Header -->
        
    
    <div class="row">
        <div class="col-md-12">
            <!-- Basic Form Elements Block -->
            <div class="block">
                <!-- Basic Form Elements Title -->
                <div class="block-title">
                    <h2>capital</h2>
                </div>
                <!-- END Form Elements Title -->

                <!-- Basic Form Elements Content -->
                <form id="form-main" name="form-main" action="provider_crud.php" method="post"  class="form-horizontal form-bordered">

                <div class="form-group">
                    <label class="col-md-2 control-label" for="category">Income Category</label>
                    <div class="col-md-4">
                        <select id="category" name="category" class="select-chosen" data-placeholder="Select Income Category"> 
                                <option value="capital">capital</option>

                            </select>
                      </div> 

                        <label class="col-md-2 control-label" for="status">Amount</label>
                        <div class="col-md-4">
                             <input type="text" id="amount" name="amount" class="form-control" placeholder="Amount" data-type="number" onkeypress="return isNumberKey(event)">  
                        </div>
                </div>

                  <div class="form-group">
                    <label class="col-md-2 control-label" for="category">Comment</label>
                    <div class="col-md-4">
                      <textarea class="form-control" rows="3" id="comment" name="comment"></textarea> 
                      </div> 

                          <label class="col-md-2 control-label" for="date">Date</label>
                                    <div class="col-md-4">
                                        <input type="text" id="date" name="date" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd">
                        </div><!--End col-md-4-->
                </div>

                <div class="form-group">
                        <label class="col-md-2 control-label" for="status">Status</label>
                        <div class="col-md-4">
                            <select id="status" name="status" class="select-chosen"> 
                                   <option value="1">Active</option>
                                   <option value="0">Inactive</option>
                               </select>
                        </div>
                </div>
     
                    <div class="form-group form-actions">
                        <input type="hidden" name="id" id="id" value="0" />

                        <div class="col-md-12">
                            <button type="submit" id="btn_submit" class="btn btn-success primary-btn pull-right"><i class="fa fa-angle-right"></i> Submit</button>
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
    <!--<div class="block full">-->
        <!-- Table Title -->
    <!--    <div class="block-title">-->
    <!--        <h2>Adds</h2><small>Leaves currently exist in the system</small>-->
    <!--    </div>-->
        <!-- END Table Title -->

        <!-- Table Content -->
    <!--    <div class="table-responsive"><table id="table-data" class="table table-condensed table-striped table-hover"></table></div>-->
        <!-- END Table Content -->
    <!--</div>-->
    <!-- END Table Block -->
<!-- END Page Content -->
</div>

<?php include $prefix.'page_footer.php'; ?>
<?php include $prefix.'template_scripts.php'; ?>
<?php include $prefix.'template_end.php'; ?>

<script type="text/javascript">

    // Add thoussand seperators

    $(document).ready(function(){
        $("input[data-type='number']").keyup(function(event){
          // skip for arrow keys
          if(event.which >= 37 && event.which <= 40){
              event.preventDefault();
          }
          var $this = $(this);
          var num = $this.val().replace(/,/gi, "");
          var num2 = num.split(/(?=(?:\d{3})+$)/).join(",");
          console.log(num2);
          // the following line has been simplified. Revision history contains original.
          $this.val(num2);
        });
    });

    // Let input numbers only
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
        return true;
    } 

    //prevent enter key submission
    $(document).ready(function() {
        $(window).keydown(function(event){
          if(event.keyCode == 13) 
          {
            event.preventDefault();
            return false;
          }
        });
    });


    App.datatables();

    var dt = $('#table-data').DataTable({
        "processing": true,
        "serverSide": true,
        "select": true,
        "columns": [
            { "data": "category", "name": "category", "title":"Category" },
            { "data": "amount", "name": "amount", "title":"Amount" },
            { "data": "comment", "name": "comment", "title":"Comment" },
            { "data": "date", "name": "date", "title":"Date" },
            // {"data": "actions", "name": "actions","title":"Actions", "searchable": false, "orderable": false, 
            //     mRender: function (data, type, row) {
            //         return '<div class="btn-group btn-group-xs"><button id="btn-row-edit" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></button></div>'
            //     }
            // }
        ],
        "columnDefs":[
            {"className": "dt-center", "targets": [1,2,3]}
        ],
        "language": {
            "emptyTable": "No expenses to show..."
        },
        "ajax": "data/grid_data_income.php"
    });
    
    $('.dataTables_filter input').attr('placeholder', 'Search');

    $("#table-data tbody").on('click', '#btn-row-edit', function() {
        var str_id = $(this).closest('tr').attr('id');
        var arr_id = str_id.split("_");

        var row_id = arr_id[1];
       // alert (row_id);

        $.ajax({
            url: 'data/data_expenses.php',
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
                $.bootstrapGrowl('<h4>Error!</h4> <p>Error retrieving Income data</p>', {
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
                      $('#category').val(r.data[0].category);                                                                              
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
         var validation = false;

         var formdata = $('#form-main').serializeArray();
         formdata.push({'name':'operation','value':op});

        var category = $('#category').val();
        var amount = $('#amount').val();
        var comment = $('#comment').val();
        var date = $('#date').val();
        var status = $('#status').val();

        if (comment == '' || comment == null || amount == '' || amount == null || date == '' || date == null) 
        {
          if (comment == '' || comment == null) 
          {
            document.getElementById('comment').style.borderColor = "red";
            // document.getElementById("comment").value = "COMMENT IS REQUIRED";
            document.getElementById("comment").style.color = "red";

            $("#comment").mousedown(function()
            {
              $('#comment').val('');
              document.getElementById('comment').style.borderColor = "";
              document.getElementById("comment").style.color = "black";
            });  
          }
          if (amount == '' || amount == null) 
          {
            document.getElementById('amount').style.borderColor = "red";
            // document.getElementById("amount").value = "AMOUNT IS REQUIRED";
            document.getElementById("amount").style.color = "red";

            $("#amount").mousedown(function()
            {
              $('#amount').val('');
              document.getElementById('amount').style.borderColor = "";
              document.getElementById("amount").style.color = "black";
            });  
          }
          if (date == '' || date == null) 
          {
            document.getElementById('date').style.borderColor = "red";
            // document.getElementById("date").value = "AMOUNT IS REQUIRED";
            document.getElementById("date").style.color = "red";

            $("#date").mousedown(function()
            {
              $('#date').val('');
              document.getElementById('date').style.borderColor = "";
              document.getElementById("date").style.color = "black";
            });  
          }
        }
        else
        {
          $.ajax({
            url: 'capital_crud.php',
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
            complete: function(e) 
            {
                        msg_typ = 'success';
                        msg_txt = '<h4>Success!</h4> <p>Branch saved</p>';
                        dt.ajax.reload();
                    dt.draw();
                        
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