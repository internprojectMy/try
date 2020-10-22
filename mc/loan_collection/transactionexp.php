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
        <li><li>Expenses</li></li>
    </ul>
    <!-- END Blank Header -->
		
	
    <div class="row">
        <div class="col-md-12">
            <!-- Basic Form Elements Block -->
            <div class="block">
                <!-- Basic Form Elements Title -->
                <div class="block-title">
					<h2>Expenses</h2>
				</div>
                <!-- END Form Elements Title -->

                <!-- Basic Form Elements Content -->
                <form id="form-main" name="form-main" action="provider_crud.php" method="post"  class="form-horizontal form-bordered">

                <div class="form-group">
                    <label class="col-md-2 control-label" for="exptype">Branch</label>
                        <div class="col-md-4">
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
                            </select>
                        </div>

                   <!--  <label class="col-md-2 control-label" for="expcat">Expense Categroy</label>
                        <div class="col-md-4">
                            <select id="expcat" name="expcat" class="select-chosen" data-placeholder="Choose Expense">
                            <option></option>
                            <?php
                                    $query="SELECT
                                                    pl_expense.id,
                                                    pl_expense.category,
                                                    pl_expense.status
                                                    FROM
                                                    pl_expense";

                                    $sql = mysqli_query($con_main, $query);
                                                                            
                                    while ($type = mysqli_fetch_array($sql)){
                                        echo ("<option value=\"".$type['category']."\">".$type['category']." </option>");
                                    }
                                   ?>
                            </select>
                        </div> --> 

                </div>  

                 <div class="form-group">

                      <label class="col-md-2 control-label" for="exptype">Expense</label>
                        <div class="col-md-4">
                            <select id="exptype" name="exptype" class="select-chosen" data-placeholder="Choose Expense">
                            <option></option>
                            <?php
                                    $query="SELECT
                                             loan_expenses.id,
                                             loan_expenses.category
                                             
                                            FROM
                                             `loan_expenses`
                                            WHERE
                                              loan_expenses.`status` = '1'";

                                    $sql = mysqli_query($con_main, $query);
                                                                            
                                    while ($type = mysqli_fetch_array($sql)){
                                        echo ("<option value=\"".$type['id']."\">".$type['category']." </option>");
                                    }
                                   ?>
                            </select>
                        </div> 

                  <label class="col-md-2 control-label" for="amount">Amount</label>
                    <div class="col-md-4">
                      <input type="text" id="amount" name="amount" class="form-control" placeholder="Enter Expense Amount" data-type="number" onkeypress="return isNumberKey(event)">  
                      </div>

                      
                </div><!--End from-group-->

                    <div class="form-group">

                          <label class="col-md-2 control-label" for="expencestype">Payment Method</label>
                        <div class="col-md-4">
                              <select id="expencestype" name="expencestype" class="select-chosen" data-placeholder="Payment Method"> 
                                <option></option>
                                   <?php
                                    $query="SELECT
                                            expenses_type.id,
                                            expenses_type.expenses_type,
                                            expenses_type.status
                                            FROM
                                            expenses_type";
                                                                                               

                                    $sql = mysqli_query($con_main, $query);
                                                                            
                                    while ($type = mysqli_fetch_array($sql)){
                                        echo ("<option value=\"".$type['expenses_type']."\">".$type['expenses_type']. "</option>");
                                    }
                                   ?>
                            </select><!--End custmore-->
                        </div><!--End col-md-4-->

                         <label class="col-md-2 control-label" for="expencestype">Comment</label>
                       <div class="col-md-4">
                           <textarea class="form-control comment" id="comment" name="comment"></textarea>
                       </div><!--End col-md-4-->

                       <!-- <label class="col-md-2 control-label" for="expencestype">Other</label>
                       <div class="col-md-4">
                           <textarea class="form-control other" id="other" name="other"></textarea>
                       </div> --><!--End col-md-4-->
                </div><!--End from-group--> 
     
                    <div class="form-group form-actions">
                        <input type="hidden" name="id" id="id" value="0" />

                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success primary-btn pull-right"><i class="fa fa-angle-right"></i> Submit</button>
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
                        </div><!--End col-md-12-->
                    </div><!--End form-group-->
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
            <h2>Expenses</h2><small>Expenses currently exist in the system</small>
        </div>
        <!-- END Table Title -->

        <!-- Table Content -->
        <div class="table-responsive"><table id="table-data" class="table table-condensed table-striped table-hover"></table></div>
        <!-- END Table Content -->
    </div>
    <!-- END Table Block -->
<!-- END Page Content -->
</div>
</div>

<?php include $prefix.'page_footer.php'; ?>
<?php include $prefix.'template_scripts.php'; ?>
<?php include $prefix.'template_end.php'; ?>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
            { "data": "category", "name": "category", "title": "Category"},
            { "data": "amount", "name": "amount", "title": "Amount"},
            { "data": "expencestype", "name": "expencestype", "title": "Expences Type"},
            { "data": "comment", "name": "comment", "title": "Comment"},
            { "data": "other", "name": "other", "title": "Other"},
            { "data": "entered", "name": "entered", "title": "Entered By"},
            { "data": "date", "name": "date", "title":"Entered Date"},
            {"data": "actions", "name": "actions","title":"Actions", "searchable": false, "orderable": false, 
                mRender: function (data, type, row) {
                    return '<div class="btn-group btn-group-xs"><button id="btn-row-edit" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></button></div>'
                }
            }
        ],
        "columnDefs":[
            {"className": "dt-center", "targets": [1,2,3,4,5,6,7]}
        ],
        "language": {
            "emptyTable": "No expenses to show..."
        },
        "ajax": "data/grid_data_transactionexp.php"
    });
	
    $('.dataTables_filter input').attr('placeholder', 'Search');

    $("#table-data tbody").on('click', '#btn-row-edit', function() {
        var str_id = $(this).closest('tr').attr('id');
        var arr_id = str_id.split("_");

        var row_id = arr_id[1];
       // alert (row_id);

        $.ajax({
            url: 'data/data_transactionexp.php',
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

                      $('#exptype').val(r.data[0].category); 
                      $('#exptype').trigger("chosen:updated"); 

                      $('#amount').val(r.data[0].amount); 
                                                                                                    
                }

                $('#table-data tbody #'+str_id+' #btn-row-edit').button('reset');
                NProgress.done();
            }
        });
    });
 

 

    /*********** Form Validation and Submission ***********/
	$('#form-main').on('submit', function (e){
		e.preventDefault();
		
		var id = $('#id').val();
		var op = (id == 0) ? "insert" : "update";
		
		var formdata = $('#form-main').serializeArray();
		formdata.push({'name':'operation','value':op});

        var branch_name = $('#branch_name').val();
        var exptype = $('#exptype').val();
        var amount = $('#amount').val();
        var expencestype = $('#expencestype').val();
        var comment = $('#comment').val();

        if (comment == '' || comment == null || amount == '' || amount == null || branch_name == '' || branch_name == null | exptype == '' || exptype == null || expencestype == '' || expencestype == null) 
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
          if (branch_name == '' || branch_name == null) 
          {
            document.getElementById('branch_name').style.borderColor = "red";
            // document.getElementById("date").value = "AMOUNT IS REQUIRED";
            document.getElementById("branch_name").style.color = "red";

            $("#branch_name").mousedown(function()
            {
              $('#branch_name').val('');
              document.getElementById('branch_name').style.borderColor = "";
              document.getElementById("branch_name").style.color = "black";
            });  
          }
          if (exptype == '' || exptype == null) 
          {
            document.getElementById('exptype').style.borderColor = "red";
            // document.getElementById("date").value = "AMOUNT IS REQUIRED";
            document.getElementById("exptype").style.color = "red";

            $("#exptype").mousedown(function()
            {
              $('#exptype').val('');
              document.getElementById('exptype').style.borderColor = "";
              document.getElementById("exptype").style.color = "black";
            });  
          }
          if (expencestype == '' || expencestype == null) 
          {
            document.getElementById('expencestype').style.borderColor = "red";
            // document.getElementById("date").value = "AMOUNT IS REQUIRED";
            document.getElementById("expencestype").style.color = "red";

            $("#expencestype").mousedown(function()
            {
              $('#expencestype').val('');
              document.getElementById('expencestype').style.borderColor = "";
              document.getElementById("expencestype").style.color = "black";
            });  
          }
        }
        else
        {
		
    		$.ajax({
    			url: 'transactionexp_crud.php',
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
        }
	});

    $('#form-main').on('reset', function (e){
        $('#id').val("0");

        $('#exptype').val("");
        // $('#exptype').trigger("chosen:updated");
        $('#amount').val("");
        $('#id').val("");
    });
    /*********** Form Control End ***********/
		
	</script>
	
	<?php mysqli_close($con_main); ?>