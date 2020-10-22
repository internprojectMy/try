<?php
	session_start();
	
	if (empty($_SESSION['ACCESS_CODE']) || $_SESSION['ACCESS_CODE'] == NULL){
		header ('Location: login.php');
		exit;
	}

	$user_code = $_SESSION['USER_CODE'];
	
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
                <i class="gi gi-podium"></i>Cash Collecting<br>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li><li>Cash Collecting</li></li>
    </ul>

<!--     <div class="row">
        <div class="col-md-12">
             <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                       <label class="col-md-2 control-label" for="search">Search</label>
                            <div class="col-md-9">
                                 <select name="search" id="search" style="width:100%;">
                                     <option value="" selected disabled>Enter Invoice No or Collector Name</option>
                                </select>
                                 <input type="hidden" name="loanid" id="loanid" value="0" />
                            </div>   
                    </div>
                </div>
            </div>
        </div>
    </div> -->
 
    <div class="row">
        <div class="col-md-12">
            <!-- Basic Form Elements Block -->
            <div class="block">
                <!-- Basic Form Elements Title -->
                <div class="block-title">
					<h1>Cash Collecting</h1>
				</div>
                <!-- END Form Elements Title -->

                <!-- Basic Form Elements Content -->
                <form id="form-main" name="form-main" action="provider_crud.php" method="post"  class="form-horizontal form-bordered">
               <fieldset>
               	 <legend><i class="fa fa-angle-right"></i>Cash Collecting</legend> 
               <div class="form-group">                           
                        <label class="col-md-2 control-label" for="branch_name">Branch</label>
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
                                </select><!--End selete branch-->
                            </div><!--End col-md-4-->

                    <label class="col-md-2 control-label" for="center_name">Center</label>
                      <div class="col-md-4">
                          <select id="center_name" name="center_name" class="select-chosen" data-placeholder=" Center Name"> 
                              <option></option>
                          </select><!--End center selete-->
                      </div><!--End col-md-4-->
                    </div><!--End from-group-->

                    <div class="form-group" id="update_form">
                    <div class="col-md-12">  
                        <h4>Payment Details</h4>                                        
                        <table class="table" id="loans_table">
                            <tr>
                                <th><input type="checkbox" name="check_all" id="check_all"></th>
                                <th>Loan No</th>
                                <th>Customer Name</th>
                                <th>Customer NIC</th>
                                <th>Loan Amount</th>
                                <th>Premium</th>
                                <th>Date</th>
                            </tr>
                            <tbody id="rows">
                            </tbody>                                      
                        </table>            
                    </div> 
                </div>
                
                </fieldset>


             <div class="form-group form-actions">
                  <input type="hidden" name="id" id="id" value="0" />
                    <div class="col-md-12">
                        <button type="submit" id="btn_submit" class="btn btn-success primary-btn pull-right"><i class="fa fa-angle-right"></i> Submit</button>
                        <a href="cash_collecting_edit.php" class="btn btn-warning">New</a>
                    </div>
            </div>
        </form>    <!-- END Basic Form Elements Block -->
		    </div>
            <!-- END Example Content -->
        </div>
        <!-- END Example Block -->

    </div>

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

<!-- <script src="../js/sweetalert.js"></script> -->

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript">

  $('#check_all').click(function() {
    if ($(this).is(':checked')) {
      $('[name*=checked_loans').prop('checked',true);
    }else{
      $('[name*=checked_loans').prop('checked',false); 
    }
  });

  // App.datatables();

  //   var dt = $('#table-data').DataTable({
  //       "processing": true,
  //       "serverSide": true,
  //       "select": true,
  //       "columns": [
  //           { "data": "loanid", "name": "loanid", "title":"Loan No"}, //0
  //           { "data": "nic", "name": "nic", "title":"NIC"},//2
  //           { "data": "name_full", "name": "name_full", "title":"Customer Name"},//2
  //            { "data": "net_payment", "net_payment": "total", "title":"Loan Amount"},
  //            { "data": "paid", "name": "paid", "title":"Payment Received"},//4
  //              { "data": "today", "name": "today", "title":"Date"},//6
  //               { "data": "status", "name": "status", "title":"Status"},//6
  //           {"data": "actions", "name": "actions","title":"Actions", "searchable": false, "orderable": false, 
  //               mRender: function (data, type, row) {
  //                   return '<div class="btn-group btn-group-xs"><button id="btn-row-edit" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></button></div>'
  //               }//4
  //           }
  //       ],
  //       "columnDefs":[
  //           {"className": "dt-center", "targets": [0,1,2,3,4,5,6]}
  //       ],
  //       "language": {
  //           "emptyTable": "No expenses to show..."
  //       },
  //       "ajax": "data/grid_data_cash_collecting.php"
  //   });
  
  //   $('.dataTables_filter input').attr('placeholder', 'Search');

  //   $("#table-data tbody").on('click', '#btn-row-edit', function() {
  //       var str_id = $(this).closest('tr').attr('id');
  //       var arr_id = str_id.split("_");

  //       var row_id = arr_id[1];
  //    // alert (row_id);

  //       $.ajax({
  //           url: 'data/cash_collecting_edit.php',
  //           data: {
  //               id: row_id
  //           },
  //           method: 'POST',
  //           dataType: 'json',
  //           beforeSend: function () {
  //               $('#table-data tbody #'+str_id+' #btn-row-edit').button('loading');
  //               NProgress.start();
  //           },
  //           error: function (e) {
  //               $.bootstrapGrowl('<h4>Error!</h4> <p>Error retrieving expenses data</p>', {
  //                   type: 'danger',
  //                   delay: 2500,
  //                   allow_dismiss: true
  //               });

  //               $('#table-data tbody #'+str_id+' #btn-row-edit').button('reset');
  //               NProgress.done();
  //           },
  //           success: function (r) {
  //               if (!r.result) {
  //                   $.bootstrapGrowl('<h4>Error!</h4> <p>'+r.message+'</p>', {
  //                       type: 'danger',
  //                       delay: 2500,
  //                       allow_dismiss: true
  //                   });
  //               }else{ 
  //                     $('#id').val(r.data[0].ID);                 
  //                     $('#status').val(r.data[0].status); 
  //                     $('#status').trigger("chosen:updated");
  //                     $('#loandate').val(r.data[0].loan_date);
  //                     $('#nic').val(r.data[0].customer_id);
  //                     $('#paid').val(r.data[0].paid);
  //                     //  $('#cash_name').val(r.data[0].CASHNAME);
  //                     //  $('#cash_day').val(r.data[0].CASHDAY);                                                                              
  //               }

  //               $('#table-data tbody #'+str_id+' #btn-row-edit').button('reset');
  //               NProgress.done();
  //           }
  //       });
  //   });
  //   /*********** Table Control End ***********/ 
 
//  window.setInterval(()=>{
//     $('#rows tr').each(function(){
//         var lamount = $(this).find('td:eq(3)').html();
//         var paid_amount = $(this).find('td input:eq(0)').val();
//         var bal_amount = lamount - paid_amount;
//         $(this).find('td input:eq(1)').val(bal_amount);
//     });
// },1000);

//Branch name for center display
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



// Loan id display
  $('#center_name').on('change',function(){
      $('#rows').html('');
      var center_id = $('#center_name').val();

      $.ajax({
        url: 'data/data-branch-.php',
        data: {
          center_id : center_id
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
                let html = "";

                let net_payment = v.net_payment;
                let loan_interst = v.interest_amount;
                let due_amount = v.due_amount;
                // let loan_full_amount = loan_am * loan_interst / 100;
                // alert (loan_full_amount);
                
                html += "<tr id=\"tr-"+v.id+"\">";
                html += "<td><input type='checkbox' value='"+v.loanid+"' name='checked_loans[]'></td>";
                html += "<td>"+v.loanno+"</td>";
                html += "<td>"+v.name_full+"</td>";
                html += "<td>"+v.nic+"</td>";
                html += "<td>"+v.net_payment+"</td>";
                html += "<td><input style=\"width: 80px; height: 26px;\" type=\"text\" name=\"loan_paying_amount\" value=\""+v.due_amount+"\"></td>";
                html += "<td><input style=\"width: 100px; height: 26px;\" type=\"date\" name=\"today\" id=\"today\"></td>";
                html += "</tr>";

                $('#rows').append(html);
             });   
            }
          }
          // $('#loanid').trigger("chosen:updated")
        }
      });
  });


  
  //Nic ,membe_number , net_amount display
  $('#loanid').on('change',function(){

      var full_name = $('#loanid').val();

      $.ajax({
        url: 'data/data-branch-.php',
        data: {
          full_name : full_name
          //alert(nameid)
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
                //let om = "";
                // om += "<option value='"+v.full_name+"'>";
                // om += v.full_name;
                // om += "</option>";
                 $('#member_number').val(r.data[0].member_number);
                $('#full_name').val(r.data[0].full_name);
                $('#nic').val(r.data[0].nic);
                $('#net_payment').val(r.data[0].net_payment);
                //  $('#Paid').val(r.data[0].Paid);

                //$('#full_name').append(om);
             });     
            }
          }
          //$('#full_name').trigger("chosen:updated")
        }
      });
  });


$( "#total" ).mousedown(function() {
  var amount = $('#total').val();
    var bill = $('#net_payment').val();
    var late = $('#paid').val();
    $('#total').val(bill - late);
});

	
  	
	$('#form-main').on('submit', function (e){
        e.preventDefault();
        // result_status = false;
        var branch_name = $('#branch_name').val();
        var center_name = $('#center_name').val();
        var array = [];

        
            $('#mytable').find('tr').each(function () {
                var row = $(this);
                if (row.find('input[type="checkbox"]').is(':checked') &&
                    row.find('textarea').val().length <= 0) {
                    alert('You must fill the text area!');
                }
            });
        
        
        $('#loans_table').find('tr').each(function () {
            var row = $(this);
             if (row.find('input[type="checkbox"]').is(':checked')) {
                    
             var obj = {};
             var loan_id = obj['loan_id']=$(this).find('td:eq(1)').html();
             var name_full =  obj['name_full']=$(this).find('td:eq(2)').html();
             var nic = obj['nic']=$(this).find('td:eq(3)').html();
             var net_payment = obj['net_payment']=$(this).find('td:eq(4)').html();
             var paid = obj['paid']=$(this).find('td input:eq(1)').val();
             var today = obj['today']=$(this).find('td input:eq(2)').val();
             // var bal_amount = obj['bal_amt']=$(this).find('td input:eq(1)').val();
             array.push(obj);
            $.ajax({
               url:'cash_collecting_crud.php',
               data:{
                  branch_name:branch_name,
                   center_name:center_name,
                   loanid:loan_id,
                   name_full:name_full,
                   nic:nic,
                   net_payment:net_payment,
                   paid:paid,
                   today:today,
                   
               },
               method:'post',
               success:function(r){
                 if(r.result){
                  swal("Succes","Payment Received Saved","success");

                  dt.ajax.reload();
                        dt.draw();
                   result_status = true;
                 }else{
                   result_status = false;
                 }          
               }
            }); 
         }
      });
      $('#rows').append('');
  });

    $('#form-main').on('reset', function (e){
        $('#id').val("0");

        $('#branch_name').val("");
        $('#branch_name').trigger("chosen:updated");
         $('#center_name').val("");
        $('#center_name').trigger("chosen:updated");

        $('#loanid').val("");
        $('#loanid').trigger("chosen:updated");      
        $('#nic').val("");
        $('#member_number').val("");
        $('#net_payment').val("");
        $('#paid').val("");
        $('#total').val("");
    });
    /*********** Form Control End ***********/

    $('#form-main').on('ok', function (e){
        e.preventDefault();
        // result_status = false;
        var branch_name = $('#branch_name').val();
        var center_name = $('#center_name').val();
        var array = [];

      $('#rows tr').each(function(){
         var obj = {};
         var loan_id = obj['loan_id']=$(this).find('td:eq(0)').html();
         var name_full =  obj['name_full']=$(this).find('td:eq(1)').html();
         var nic = obj['nic']=$(this).find('td:eq(2)').html();
         var net_payment = obj['net_payment']=$(this).find('td:eq(3)').html();
         var paid = obj['paid']=$(this).find('td input:eq(0)').val();
         var bal_amount = obj['bal_amt']=$(this).find('td input:eq(1)').val();
         array.push(obj);

        $.ajax({
           url:'cash_collecting_crud.php',
           data:{
               branch_name:branch_name,
               center_name:center_name,
               loanid:loan_id,
               name_full:name_full,
               nic:nic,
               net_payment:net_payment,
               paid:paid,
               bal_amt:bal_amount 
           },
           method:'post',
           success:function(r){
             if(r.result){
              swal("Succes","Payment Received Saved","success");

              dt.ajax.reload();
                    dt.draw();
               result_status = true;
             }else{
               result_status = false;
             }          
           }
        }); 
     });
      $('#rows').append('');
  });

    $('#form-main').on('reset', function (e){
        $('#id').val("0");

        $('#branch_name').val("");
        $('#branch_name').trigger("chosen:updated");
         $('#center_name').val("");
        $('#center_name').trigger("chosen:updated");

        $('#loanid').val("");
        $('#loanid').trigger("chosen:updated");      
        $('#nic').val("");
        $('#member_number').val("");
        $('#net_payment').val("");
        $('#paid').val("");
        $('#total').val("");
    });
		
	</script>
	
	<?php mysqli_close($con_main); ?>