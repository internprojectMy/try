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
                <i class="gi gi-podium"></i>Cash Lending<br><small>Create, Update or Delete Cash Lending</small>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li><li>Cash Lending</li></li>
    </ul>
    <!-- END Blank Header -->

    <div class="row">
        <div class="col-md-12">
            <!-- Basic Form Elements Block -->
            <div class="block">
                <!-- Basic Form Elements Title -->
                <div class="block-title">
					           <h2>Cash Lending</h2>
				      </div><!-- END Form Elements Title -->
   

                <!-- Basic Form Elements Content -->
                <form id="form-main" name="form-main" action="" method="post"  class="form-horizontal form-bordered">
                   <div class="form-group">
                    <label class="col-md-2 control-label" for="loanno">Loan No</label>
                    <div class="col-md-4">
                      <input type="text" id="loanno" name="loanno" class="form-control" value="" readonly>  
                      </div><!--End col-md-4-->

                    <label class="col-md-2 control-label" for="loandate">Loan Date</label>
                    <div class="col-md-4">
                      <input type="text" id="loandate" name="loandate" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd">  
                      </div><!--End col-md-4-->
                </div><!--End form group-->

                <div class="form-group">
                    <label class="col-md-2 control-label" for="nic">NIC No</label>
                        <div class="col-md-4">
                            <select id="nic" name="nic" class="select-chosen" data-placeholder="Choose NIC No"> 
                                <option></option>
                                   <?php
                                    $query="SELECT
                                            loan_customer.id,
                                            loan_customer.center_name,
                                            loan_customer.branch_name,
                                            loan_customer.name_full,
                                            loan_customer.nic,
                                            loan_customer.status
                                            FROM
                                            loan_customer";

                                    $sql = mysqli_query($con_main, $query);
                                                                            
                                    while ($type = mysqli_fetch_array($sql)){
                                        echo ("<option value=\"".$type['nic']."\">".$type['nic']. " - ".$type['name_full']."</option>");
                                    }
                                   ?>
                            </select><!--End custmore-->
                        </div><!--End col-md-4-->

                    <label class="col-md-2 control-label" for="loanamount">Loan Amount</label>
                    <div class="col-md-4">
                      <input type="text" id="loanamount" name="loanamount" class="form-control" placeholder="Enter Loan Amount">  
                      </div><!--End col-md-4-->
                </div><!--End form-group-->

                    <div class="form-group">
                     <label class="col-md-2 control-label" for="interest">Interest Rate</label>
                      <div class="col-md-4">
                          <input type="text" id="interest" name="interest" class="form-control" placeholder="Enter Interest Amount">
                      </div><!--End group-->

                     
                       <label class="col-md-2 control-label" for="loantype">Loan Collecting Type</label>
                        <div class="col-md-4">
                             <select id="loantype" name="loantype" class="select-chosen" data-placeholder="Choose Loan Type"> 
                                <option></option>
                                   <?php
                                    $query="SELECT
                                             loan_type.id,
                                             loan_type.type                                            
                                            FROM
                                             `loan_type`
                                            WHERE
                                              loan_type.`status` = '1'";

                                    $sql = mysqli_query($con_main, $query);
                                                                            
                                    while ($type = mysqli_fetch_array($sql)){
                                        echo ("<option value=\"".$type['id']."\">".$type['type']."</option>");
                                    }
                                   ?>
                            </select><!--End loan-type-->
                        </div><!--End col-md-4-->
                </div><!--End form-->

                <div class="form-group">
                  <label class="col-md-2 control-label" for="loantypes">Loan Type</label>
                  <div class="col-md-4">
                             <select id="loantypes" name="loantypes" class="select-chosen" data-placeholder="Choose Loan Type"> 
                                <option value=""></option>
                                <option value="Personal">Personal</option>
                                <option value="Housing">Housing</option>
                                <option value="Educational">Educational</option>
                                <option value="Vehicle">Vehicle</option>
                                <option value="Special">Special</option>
                                <option>Personal</option>
                                   
                                   ?>
                            </select><!--End loan-type-->
                        </div><!--End col-md-4-->
                     <label class="col-md-2 control-label" for="duration">Duration (week)</label>
                       <div class="col-md-4">
                           <input type="text" id="duration" name="duration" class="form-control">
                       </div><!--End col-md-4-->
                        
                </div><!--End from-group-->

                <div class="form-group">
                   <label class="col-md-2 control-label" for="net">Net Payment</label>
                       <div class="col-md-4">
                           <input type="text" name="net" id="net" class="form-control">
                       </div><!--End col-md-4-->  

                        <label class="col-md-2 control-label" for="dueamount">Due Amount</label>
                       <div class="col-md-4">
                           <input type="text" id="dueamount" name="dueamount" class="form-control">
                       </div><!--End col-md-4-->

                        
                </div><!--End from-group-->

                <div class="form-group">
                  <label class="col-md-2 control-label" for="day">collector By</label>
                        <div class="col-md-4">
                             <input type="text" id="collector" name="collector" class="form-control">
                        </div><!--End col-md-4-->
                        <label class="col-md-2 control-label" for="startdate">Loan Start Date</label>
                    <div class="col-md-4">
                      <input type="text" id="startdate" name="startdate" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd">  
                      </div> 

                     
                </div><!--End form-->

                <div class="form-group">
                   <label class="col-md-2 control-label" for="enddate">Loan End Date</label>
                       <div class="col-md-4">
                           <input type="text" name="enddate" id="enddate" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd">
                       </div><!--End col-md-4-->
                      <input type="hidden" name="realend" id="realend" value="0"/>
                    <label class="col-md-2 control-label" for="collector">Collected Date</label>
                        <div class="col-md-4">
                 <input type="text" id="collector_day" name="collector_day" class="form-control">
                        </div>
                    </div><!--End from-group-->
                    <div class="form-group">
                              <label class="col-md-2 control-label" for="status">Status</label>
                        <div class="col-md-4">
                            <select id="status" name="status" class="select-chosen"> 
                                   <option value="1">Active</option>
                                   <option value="0">Inactive</option>
                               </select>
                          </div><!--End col-md-4-->
                    </div><!--End from-group-->
                
                <div class="form-group">
                    <div class="form-group form-actions">
                        <input type="hidden" name="id" id="id" value="0" />

                            <div class="col-md-12">
                            <button type="submit" id="btn_submit" class="btn btn-success primary-btn pull-right"><i class="fa fa-angle-right"></i> Submit</button>
                            <button type="reset" id="btn-reset" class="btn btn-warning"><i class="fa fa-repeat"></i>New</button>
                        </div><!--End col-md-12-->
                    </div><!--End from-action-->
                </div><!--End from-group-->
              </form><!--End from-->
		    </div><!--End block-->
      </div><!--End col-md-12-->
    </div><!-- END Example Block --> 

     <div class="block full">
        <!-- Table Title -->
        <div class="block-title">
            <h2>Adds</h2><small>Leaves currently exist in the system</small>
        </div><!-- END Table Title -->

        <div class="table-responsive"><table id="table-data" class="table table-condensed table-striped table-hover"></table></div><!-- END Table Content -->
 </div>
</div>

<?php include $prefix.'page_footer.php'; ?>
<?php include $prefix.'template_scripts.php'; ?>
<?php include $prefix.'template_end.php'; ?>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

  App.datatables();

    var dt = $('#table-data').DataTable({
        "processing": true,
        "serverSide": true,
        "select": true,
        "columns": [
            { "data": "loanid", "name": "loanno", "title":"Loan No"}, //0
            { "data": "loan_date", "name": "loandate", "title":"Loan Date"}, //1
            { "data": "nic", "name": "nic", "title":"NIC"},//2
            // { "data": "center_name", "name": "center_name", "title":"Center Name"},
             { "data": "loan_amount", "name": "loanamount", "title":"Loan Amount"},//3
              { "data": "interest_amount", "name": "interest", "title":"Interest Amount"},//4
              { "data": "loan_type", "name": "loantype", "title":"Loan Collecting Type"},//5
              { "data": "loantypes", "name": "loantype", "title":"Loan Type"},//5
              { "data": "duration", "name": "duration", "title":"Duration"},//6
              { "data": "net_payment", "name": "net", "title":"Net Payment"},//7
              { "data": "due_amount", "name": "dueamount", "title":"Due Amount"},//8
              { "data": "collector_day", "name": "collector_day", "title":"Cash Collector Day"},//9
               { "data": "startdate", "name": "startdate", "title":"Loan Start Date"},//10
                { "data": "enddate", "name": "enddate", "title":"Loan End Date"},//11
                 { "data": "collector_name", "collector": "cash_day", "title":"Cash Collector Name"},//12
               { "data": "status", "name": "status", "title":"Status"},//13
            {"data": "actions", "name": "actions","title":"Actions", "searchable": false, "orderable": false, 
                mRender: function (data, type, row) {
                    return '<div class="btn-group btn-group-xs"><button id="btn-row-edit" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></button></div>'
                }//4
            }
        ],
        "columnDefs":[
            {"className": "dt-center", "targets": [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14]}
        ],
        "language": {
            "emptyTable": "No expenses to show..."
        },
        "ajax": "data/grid_data_cash_lending.php"
    });
  
    $('.dataTables_filter input').attr('placeholder', 'Search');

    $("#table-data tbody").on('click', '#btn-row-edit', function() {
        var str_id = $(this).closest('tr').attr('id');
        var arr_id = str_id.split("_");

        var row_id = arr_id[1];
     // alert (row_id);

        $.ajax({
            url: 'data/cash_lending_edit.php',
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
                       $('#loanno').val(r.data[0].loanid);
                      $('#loandate').val(r.data[0].loan_date);
                      $('#nic').val(r.data[0].nic);
                      $('#loanamount').val(r.data[0].loan_amount);
                       $('#interest').val(r.data[0].interest_amount);
                       $('#loantype').val(r.data[0].loan_type);
                       $('#loantypes').val(r.data[0].loantypes);
                       $('#duration').val(r.data[0].duration);
                       $('#net').val(r.data[0].net_payment);
                       $('#dueamount').val(r.data[0].due_amount);
                       $('#collector').val(r.data[0].collector_name);
                       $('#collector_day').val(r.data[0].collector_day);
                       $('#startdate').val(r.data[0].startdate);
                       $('#enddate').val(r.data[0].enddate);
                       $('#center_name').val(r.data[0].center_name);

                }

                $('#table-data tbody #'+str_id+' #btn-row-edit').button('reset');
                NProgress.done();
            }
        });
    });
    /*********** Table Control End ***********/ 



    



$( "#interest" ).on('keyup',function(e) {
    var amount = $('#loanamount').val();
    var interest = $('#interest').val();
    
    var div = interest/100
    var mult= amount*div
    var tot = parseFloat(mult)+parseFloat(amount);
    $('#net').val(tot);
});


// Due Amount = amount / duration
$( "#duration" ).on('keyup', function (e) {
    var amount = $('#net').val();
    var duration = $('#duration').val();
    
    var div = amount/duration
    $('#dueamount').val(div);

    calc_end_date();
});

$('#startdate').on('change', function (e) {
  calc_end_date();
});

function calc_end_date(){
 const duration = $('#duration').val();
 const startdt = $('#startdate').val();
 let enddt = "";

 if (startdt == "") return;
 if (duration == "") return;

 const startdt_obj = new Date (startdt);
 let week_to_days = duration * 7;
 week_to_days = parseInt(week_to_days);
  
 enddt = startdt_obj.setDate(startdt_obj.getDate() + week_to_days);
 enddt = new Date(enddt);
 enddt = enddt.toISOString();

 let enddt_arr = enddt.split('T');

 enddt = enddt_arr[0];

 $('#enddate').val(enddt);
}


  

	$('#form-main').on('submit', function (e){

        e.preventDefault();
         var id = $('#id').val();
         var op = (id == 0) ? "insert" : "update";
         var validation = false;

         var formdata = $('#form-main').serializeArray();
         formdata.push({'name':'operation','value':op});
		
	  $.ajax({
            url: 'cash_lending_crud.php',
            data: formdata,
            success: function(r){
                // var msg_typ = "info";
                // var msg_txt = "";

               
                if (r.result){
                    // msg_typ = 'success';
                    // msg_txt = '<h4>Success!</h4> <p>Center saved</p>';
                    swal("Succes","Loan saved","success");

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

                
            },


        });
  });


	

    $('#form-main').on('reset', function (e){
        $('#id').val("0");

        $('#nic').val("");
        $('#nic').trigger("chosen:updated");

        $('#loantype').val("");
        $('#loantype').trigger("chosen:updated");

        $('#collector').val("");
        $('#collector').trigger("chosen:updated");

        $('#day').val("");
        $('#day').trigger("chosen:updated");

        $('#loanno').val("");
        $('#loandate').val("");
        $('#loanamount').val("");
        $('#interest').val("");
        $('#net').val("");
        $('#totaldue').val("");
        $('#dueamount').val("");
        $('#startdate').val("");
        $('#enddate').val("");
        $('#duration').val("");

        $('#search').val("");
        $('#search').trigger("chosen:updated");

    });
    // /*********** Form Control End ***********/

    $('#nic').on('change', function(){

      let nic = $('#nic').val();
      // alert (nic);

      $.ajax({
        url : 'data/get_cash_details.php',
        method : 'POST',
        dataType : 'json',
        data : {
          nic : nic 
        },
        success : function(r){
          
          let collector_day = r.cash_day;
          let cash_name = r.cash_name;
          let center_name = r.center_name;

          $('#collector_day').val(collector_day);
          $('#collector').val(cash_name);
          $('#center_name').val(center_name);

          
          $('#collector_day').trigger("chosen:updated")
          $('#center_name').trigger("chosen:updated")
          $('#collector').trigger("chosen:updated")
          

        },
        error : function(e){
          alert ('error');
        }
      });

    });
		
	</script>
	
	<?php mysqli_close($con_main); ?>