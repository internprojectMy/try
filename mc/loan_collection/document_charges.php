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
                <i class="gi gi-podium"></i>Document Charges<br><small>Create, Update or Delete Document Charges</small>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li><li>Document Charges</li></li>
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
                      <select id="loanno" name="loanno" class="select-chosen" data-placeholder="Choose Collector"> 
                                <option></option>
                                   <?php
                                    $query="SELECT
                                          loan_lending.id,
                                          loan_lending.loanid,
                                          loan_lending.due_amount,
                                          document_charges.document_amount
                                          FROM
                                          loan_lending
                                          LEFT JOIN document_charges ON loan_lending.loanid = document_charges.loanno
                                            WHERE document_charges.loanno IS NULL ";                                               

                                    $sql = mysqli_query($con_main, $query);
                                                                            
                                    while ($type = mysqli_fetch_array($sql)){
                        echo ("<option value=\"".$type['loanid']."\"> ".$type['loanid']."</option>");
                                    }
                                   ?>
                            </select> 
                      </div><!--End col-md-4-->

                    <label class="col-md-2 control-label" for="loan_amount">Loan Amount</label>
                    <div class="col-md-4">
                      <input type="text" id="loan_amount" name="loan_amount" class="form-control" readonly>  
                      </div><!--End col-md-4-->
                </div><!--End form group-->

                <div class="form-group">
                    <label class="col-md-2 control-label" for="document_rate">Document Rate</label>
                    <div class="col-md-4">
                      <input type="text" id="document_rate" name="document_rate" class="form-control" placeholder="document Rate">  
                      </div><!--End col-md-4-->


                    <label class="col-md-2 control-label" for="document_amount">Document Amount</label>
                        <div class="col-md-4">
                           <input type="text" id="document_amount" name="document_amount" class="form-control" placeholder="Document Amount">
                        </div><!--End col-md-4-->

                  </div><!--End form-group-->

                  <div class="form-group">
                    <label class="col-md-2 control-label" for="status">Status</label>
                        <div class="col-md-4">
                            <select id="status" name="status" class="select-chosen"> 
                                   <option value="paid">Paid</option>
                                   <option value="unpaid">Unpaid</option>
                               </select>
                          </div><!--End col-md-4-->
                    <label class="col-md-2 control-label" for="loan_amount">Customer</label>
                    <div class="col-md-4">
                      <input type="text" id="customer" name="customer" class="form-control" readonly>  
                      </div>
                   </div><!--End form-group-->
                
                 
     
                    <div class="form-group form-actions">
                        <input type="hidden" name="id" id="id" value="0" />

                            <div class="col-md-12">
                            <button type="submit" id="btn_submit" class="btn btn-success primary-btn pull-right"><i class="fa fa-angle-right"></i> Submit</button>
                            <button type="reset" id="btn-reset" onclick="myFunction()" class="btn btn-warning"><i class="fa fa-repeat"></i>New</button>
                        </div>
                    </div>
                </form>
                <!-- END Basic Form Elements Block -->
		    </div>
            <!-- END Example Content -->

        </div>
        <!-- END Example Block -->
    </div>
    <!-- END Example Block -->
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

<script type="text/javascript">

  //BRANCH CODDE DISPLAY
$('#loanno').on('change', function (e){
  let id = $(this).val();
    //alert(id);
  $.ajax({
    url: 'data/data-document.php',
    data: {
      loanid: id
    },  
    method: 'POST',
    dataType: 'json',
    error: function (e){
      console.error(e);
    },
    success: function (r){
      if (r.result){
        
         let loan_amount = r.amount;

        $('#loan_amount').val(loan_amount);
        $('#customer').val(r.name);
      }else{
        console.error(r.debug);
      }
    }
  });
});



$( "#document_rate" ).on('keyup',function(e) {
    var amount = $('#loan_amount').val();
    var interest = $('#document_rate').val();
    
    var div = interest/100
    var mult= amount*div
    //var tot = parseFloat(mult)+parseFloat(amount);
    $('#document_amount').val(mult);
});


// Due Amount = amount / duration
// $( "#duration" ).on('keyup',function(e) {
//     var amount = $('#net').val();
//     var duration = $('#duration').val();
    
//     var div = amount/duration
//     $('#dueamount').val(div);
// });



 //CASH LEANDING DATA VIEW 
  App.datatables();

    var dt = $('#table-data').DataTable({
        "processing": true,
        "serverSide": true,
        "select": true,
        "columns": [
            { "data": "loanno", "name": "loanno", "title":"Loan No"}, //0
            { "data": "loan_amount", "name": "loanamount", "title":"Loan Amount"},//1
            { "data": "document_rate", "name": "document_rate", "title":"document Rate"},//2
            { "data": "document_amount", "name": "document_amount", "title":"Document Amount"},//3
            { "data": "status", "name": "status", "title":"status"},//4

            // {"data": "actions", "name": "actions","title":"Actions", "searchable": false, "orderable": false, 
            //     mRender: function (data, type, row) {
            //         return '<div class="btn-group btn-group-xs"><button id="btn-row-edit" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></button></div>'
            //     }//13
            // }
        ],
        "columnDefs":[
            {"className": "dt-center", "targets": [0,1,2,3,4]}
        ],
        "language": {
            "emptyTable": "No expenses to show..."
        },
        "ajax": "data/gird_document_charges.php"
    });
  
    $('.dataTables_filter input').attr('placeholder', 'Search');

    $("#table-data tbody").on('click', '#btn-row-edit', function() {
        var str_id = $(this).closest('tr').attr('id');
        var arr_id = str_id.split("_");

        var row_id = arr_id[1];
     // alert (row_id);

        $.ajax({
            url: 'data/data_documents.php',
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
                         $('#loanno').val(r.data[0].loanno);
                         $('#loan_amount').val(r.data[0].loan_amount);
                      $('#document_rate').val(r.data[0].document_rate);
                         $('#document_amount').val(r.data[0].document_amount);                     
                }

                $('#table-data tbody #'+str_id+' #btn-row-edit').button('reset');
                NProgress.done();
            }
        });
    });
  //   /*********** Table Control End ***********/



// $('#search').select2({
//             minimumInputLength:2,
//             ajax: {
//                 url: 'data/cash_lending_select.php',
//                 dataType: 'json',
//                 delay: 100,
//                 data: function (term) {
//                     return term;
//                 },
//                 processResults: function (data) {
//                     return {
//                         results: $.map(data, function (item) {
//                             return {
//                                 text: item.name,
//                                 id: item.id
//                             }
//                         })
//                     };
//                 }
//             }
//         });


	$('#form-main').on('submit', function (e){

        e.preventDefault();
         var id = $('#id').val();
         var op = (id == 0) ? "insert" : "update";
         var validation = false;

         var formdata = $('#form-main').serializeArray();
         formdata.push({'name':'operation','value':op});

        var loanno = $('#loanno').val();
        var document_rate = $('#document_rate').val();
        var document_amount = $('#document_amount').val();

        if (loanno == '' || loanno == null  || document_amount == '' || document_amount == null) 
        {
          if (loanno == '' || loanno == null) 
          {
            document.getElementById('loanno').style.borderColor = "red";
            // document.getElementById("comment").value = "COMMENT IS REQUIRED";
            document.getElementById("loanno").style.color = "red";

            $("#loanno").mousedown(function()
            {
              $('#loanno').val('');
              document.getElementById('loanno').style.borderColor = "";
              document.getElementById("loanno").style.color = "black";
            });  
          }
          if (document_amount == '' || document_amount == null)
          {
            alert('Please Enter rate  / Amount')
          }
        }
        else
        {
          $.ajax({
              url: 'document_charges_crud.php',
              data: formdata,
              success: function(r){
                  var msg_typ = "info";
                  var msg_txt = "";

                 
                  if (r.result){
                      msg_typ = 'success';
                      msg_txt = '<h4>Success!</h4> <p>Document Charges saved</p>';

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
                  setTimeout(function(){ window.location.reload(); },2000) ;
              },
          });
        }
  });


function myFunction() 
{
  var form = $('form-main'); 
  form.reset();
}
	
</script>
	
	<?php mysqli_close($con_main); ?>