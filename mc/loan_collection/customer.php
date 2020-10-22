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
                <i class="gi gi-user_add"></i>Customer Profile<br><small>Create, Update or Remove Customers</small>
            </h1>
        </div><!--End header section-->
    </div>

    <ul class="breadcrumb breadcrumb-top">
        <li><a href="../home.php">Home</a></li>
        <li>Customer Profiles</li>
    </ul>
    <div class="row">
        <div class="col-md-12">
            <!-- Form Elements Block -->
            <div class="block">
                <!-- Form Elements Title -->
                <div class="block-title">
				    <h2>Customers</h2>
				</div>
                <!-- END Form Elements Title -->

                <!-- Form Elements Content -->
                <form id="form-main" name="form-main" action="" method="post" class="form-horizontal form-bordered">

            <fieldset>
              <legend><i class="fa fa-angle-right"></i>Branch Details</legend>                          
                        <div class="form-group">                           
                               <label class="col-md-1 control-label" for="branch_name">Branch</label>
                                     <div class="col-md-3">
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
                                     </div><!--End col-md-4-->

                               <label class="col-md-1 control-label" for="center_name">Center</label>
                                     <div class="col-md-3">
                                        <select id="center_name" name="center_name" class="select-chosen" data-placeholder=" Center Name"> 
                                <option></option>
                            </select>
                                </div><!--End col-md-4-->

                                <label class="col-md-1 control-label" for="group_name">Group</label>
                                     <div class="col-md-3">
                                        <select id="group_name" name="group_name" class="select-chosen" data-placeholder=" Group Name"> 
                                <option></option>
                            </select>
                                </div><!--End col-md-3--> 
                        </div><!--End group-->
              </fieldset><!--End branch Fieldset-->

          <fieldset>
					    <legend><i class="fa fa-angle-right"></i>Customer Details</legend>                          
                        <div class="form-group">                           
                                <label class="col-md-2 control-label" for="registered">Registered Date</label>
                                     <div class="col-md-4">
                                        <input type="text" id="registered" name="registered" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd">
                                     </div><!--End col-md-4-->
                      
                                
                                <div class="form-group">
                                  <label class="col-md-2 control-label" for="member_number">Member Number</label>
                                            <div class="input-group">
                                              <span name="member_num_code" id="member_num_code" class="input-group-addon"></span>
                                        <span id="member_num1_code" class="input-group-addon"></span> 

                                                <input type="text" id="member_number" name="member_number" class="form-control" placeholder="Member Number">
                                            </div><!--End input-group-->
                                        </div><!--End form-group-->


                        <div class="form-group">
                                <label class="col-md-2 control-label" for="fullname">Full Name</label>
                                <div class="col-md-4">
                                    <input type="text" id="fullname" name="fullname" class="form-control"  placeholder="Enter Full Name" size="1">
                                </div><!--End col-md-4-->

                                <label class="col-md-2 control-label" for="initialname">Name With Initials</label>
                                <div class="col-md-4">
                                    <input type="text" id="initialname" name="initialname" class="form-control"  placeholder="Name with initials" size="1">
                               </div><!--End col-md-4-->                                                                  
                        </div><!--End from-group-->

                        <div class="form-group">                           
                                 <label class="col-md-2 control-label" for="dob">Date of Birth</label>
                                     <div class="col-md-4">
                                        <input type="text" id="dob" name="dob" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" required="">
                                     </div><!--End date of birth-->

                                 <label class="col-md-2 control-label" for="nic">NIC</label>
                                <div class="col-md-4">
                                    <input type="text" id="nic" name="nic" class="form-control"  placeholder="Enter NIC No" size="1">
                                    <span></span>
                                </div><!--End col-md-4-->                             
                        </div><!--End from-group-->
  				    </fieldset><!--End fieldet-->
                   
					<fieldset>
					    <legend><i class="fa fa-angle-right"></i>Spouse Details</legend>
					
                        <div class="form-group">
                           <label class="col-md-2 control-label" for="spousename">Spouse Name</label>
                             <div class="col-md-4">
                                <input type="text" id="spousename" name="spousename" class="form-control"  placeholder="Enter Spouse Name" size="1">
                             </div><!--End from-group-->
						
						    <label class="col-md-2 control-label" for="spousecontact">Spouse Contact</label>
                            <div class="col-md-4">
                                <input type="text" id="spousecontact" name="spousecontact" class="form-control"  placeholder="Enter Spouse Contact No" size="1">
                            </div><!--End col-md-4-->
					             </div><!--End from-group-->
					
					               <div class="form-group">
                            <label class="col-md-2 control-label" for="spousedob">Spouse DOB</label>
                                     <div class="col-md-4">
                                        <input type="text" id="spousedob" name="spousedob" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd">
                                     </div><!--End from-group-->
						
						                <label class="col-md-2 control-label" for="spouseid">Spouse NIC</label>
                                     <div class="col-md-4">
                                       <input type="text" id="spouseid" name="spouseid" class="form-control"  placeholder="Enter Spouse NIC" size="1">  
                                     </div><!--End col-md-4-->
					                   </div><!--End from-group-->
					
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="spouseincome">Spouse Income</label>
                                <div class="col-md-4">
                                  <input type="text" id="spouseincome" name="spouseincome" class="form-control"  placeholder="Enter Spouse Income" size="1">
                                </div><!--End col-md-4-->
                        </div><!--End from-group-->
					         </fieldset><!--End fieldset-->


                    <fieldset>
                        <legend><i class="fa fa-angle-right"></i>Customer Address And Contact Details</legend>
                    
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="homeadd">Home Address</label>
                              <div class="col-md-4">
                                 <textarea name="homeaddress" id="homeaddress" rows="4" cols="25"></textarea> 
                              </div><!--End col-md-4--> 
                        
                           <label class="col-md-2 control-label" for="businessadd">Business Address</label>
                              <div class="col-md-4">
                                 <textarea name="businessadd" id="businessadd" rows="4" cols="25"></textarea> 
                              </div><!--End col-md-4-->
                        </div><!--End from-group-->
                    
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="mobile1">Mobile No1</label>
                                     <div class="col-md-4">
                                       <input type="text" id="mobile1" name="mobile1" class="form-control"  placeholder="Enter Mobile No1" size="1">
                                     </div><!--End col-md-4-->
                        
                            <label class="col-md-2 control-label" for="mobile2">Mobile No2</label>
                            <div class="col-md-4">
                                <input type="text" id="mobile2" name="mobile2" class="form-control"  placeholder="Enter Mobile No2" size="1">  
                            </div><!--End col-md-4-->
                        </div><!--End form-group-->
                    
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="fixed1">Landline No1</label>
                                <div class="col-md-4">
                                    <input type="text" id="fixed1" name="fixed1" class="form-control"  placeholder="Enter Landline No1" size="1">
                                </div><!--End col-md-4-->

                            <label class="col-md-2 control-label" for="fixed2">Landline No2</label>
                                <div class="col-md-4">
                                    <input type="text" id="fixed2" name="fixed2" class="form-control"  placeholder="Enter Landline No2" size="1">
                                </div><!--End col-md-4-->
                        </div><!--End from-group-->

                        <div class="form-group">  
                                 <label class="col-md-2 control-label" for="status">Status</label>
                                      <div class="col-md-4">
                                        <select id="status" name="status" class="select-chosen"> 
                                               <option value="1">Active</option>
                                               <option value="0">Inactive</option>
                                           </select><!--End status-->
                                      </div><!--End col-md-4-->
                        </div><!--End group-->
                          <div class="form-group form-actions">
                        <input type="hidden" name="id" id="id" value="0" />
                        <input type="hidden" name="test_code" id="test_code" value="">
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
                    </div><!--End from-group-- >
                    </fieldset><!--End fieldset-->

					     
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
</div><!--End row-->
</div><!--End container-->
 

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


  $('#nic').mousedown(function(){
 var nic = false;
 var nic = false;
 $('#nic').on('blur', function(){
  var nic = $('#nic').val();
  if (nic == '') {
    nic = false;
    return;
  }
  $.ajax({
    url: 'data/nic_check.php',
    type: 'post',
    data: {
      'nic' : 1,
      'nic' : nic,
    },
    success: function(response){
      if (response == 'taken' ) {
        nic = false;
        // $('#nic').parent().removeClass();
        // $('#nic').parent().addClass("form_error");
        // $('#nic').siblings("span").text('Sorry... Username already taken');
         swal("ERROR","NIC DUPLICATE","error");
      }else if (response == 'not_taken') {
        nic = true;
        // $('#nic').parent().removeClass();
        // $('#nic').parent().addClass("form_success");
        // $('#nic').siblings("span").text('Username available');

        swal("SUCCES","NIC Available","success");
      }
    }
  });
 });
});


 
  App.datatables();

    var dt = $('#table-data').DataTable({
        "processing": true,
        "serverSide": true,
        "select": true,
        "columns": [
            // {"data": "branch_id", "name": "branch_name", "title":"Branch Name"},
            // {"data": "center_id", "name": "center_name", "title":"Center Name"},
            // {"data": "group_id", "name": "group_name", "title":"Group Name"},
            {"data": "registered_date", "name": "registered_date", "title":"Registered Date"},
            {"data": "member_number", "name": "member_number", "title": "Member Number" },
            {"data": "name_full", "name": "name_full", "title": "Full Name" },
            {"data": "name_initial", "name": "name_initial", "title": "Full Name" },
            {"data": "dob", "name": "dob", "title": "Date of Birth" },
            {"data": "nic", "name": "nic", "title": "NIC" },
            {"data": "spouse_name", "name": "spousename", "title": "Spouse Name" },
            {"data": "spouse_contact", "name": "spousecontact", "title": "Spouse Contact"},
            {"data": "spouse_dob", "name": "spouse_dob", "title": "Spouse Date of Birth"},
            {"data": "spouse_nic", "name": "spouse_nic", "title": "Spouse NIC"},
            {"data": "spouse_income", "name": "spouse_income", "title": "Spouse Income"},
            {"data": "customer_home_address", "name": "homeaddress", "title": "Customer Address"},
             {"data": "customer_mobile1", "name": "mobile1", "title": "Customer Mobile Number"},
             {"data": "customer_fixed1", "name": "customer_fixed1", "title": "Customer Landline Number"},
             {"data": "status", "name": "status", "title": "Status"},

            // {"data": "actions", "name": "actions","title":"Actions", "searchable": false, "orderable": false, 
            //     mRender: function (data, type, row) {
            //         return '<div class="btn-group btn-group-xs"><button id="btn-row-edit" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></button></div>'
            //     }
            // }
        ],
        "columnDefs":[
            {"className": "dt-center", "targets": [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14]}
        ],
        "language": {
            "emptyTable": "No expenses to show..."
        },
        "ajax": "data/grid_data_customer.php"
    });
  
    $('.dataTables_filter input').attr('placeholder', 'Search');

    $("#table-data tbody").on('click', '#btn-row-edit', function() {
        var str_id = $(this).closest('tr').attr('id');
        var arr_id = str_id.split("_");

        var row_id = arr_id[1];
       // alert (row_id);

        $.ajax({
            url: 'data/data_customer.php',
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
                       $('#member_number').val(r.data[0].member_number);
                      $('#fulname').val(r.data[0].name_full);
                       $('#ininame').val(r.data[0].name_initial);
                       $('#spouse').val(r.data[0].spouse_name);                                                                             
                       $('#scontact').val(r.data[0].spouse_contact);
                       $('#sincome').val(r.data[0].spouse_income);
                       $('#homeadd').val(r.data[0].customer_home_address);
                       $('#mobile1').val(r.data[0].customer_mobile1);
                        $('#mobile2').val(r.data[0].customer_mobile2);
                       $('#fixed1').val(r.data[0].customer_fixed1);
                       $('#fixed2').val(r.data[0].customer_fixed2);
                       $('#status').val(r.data[0].status);
                }

                $('#table-data tbody #'+str_id+' #btn-row-edit').button('reset');
                NProgress.done();
            }
        });
    });
    /*********** Table Control End ***********/


//NIC DUPLICATE VALICATION

// $(document).ready(function(){

//   $('#nic').blur(function() {
//     /* Act on the event */
//     var nic = $(this).val();

//     $.ajax({
//       url: "data/check.php",
//       type: "POST",
//       dataType: {nic:nic},
//       data: "text",
//       success: function(){

//         $('#availability').html();
//       }
//     });
//   });
// });


  //MEMBER NUBER GEN
var globe_member_number = "";
var globe_branch_code = "";
var globe_center_code = "";
var globe_group_code = "";

function gen_member_number(){
  let seperator = "/";
   
   //EG: A1/P1/G1_(your member number)
  globe_member_number = globe_branch_code+seperator+globe_center_code+seperator+globe_group_code;
  //globe_member_number = globe_center_code+seperator+globe_group_code;

  $('#member_num_code').html(globe_member_number);
  $('#member_num_code').html(globe_branch_code);
  $('#member_num1_code').html(globe_center_code);
}

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
      globe_branch_code = "";

      if (r.result){
        let branch_code = r.data[0].CODE;

        $('#branch_code').val(branch_code);

        globe_branch_code = branch_code;

        gen_member_number();
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
                  
         // $('#center_code').val(center_code);

         // globe_center_code = branch_code;

         // gen_member_number();
        });
      }else{
        console.error(r.debug);
      }

      $('#center_name').trigger("chosen:updated");
    }
  });
});

//CENTER CODE DISPALY IN MEMBER NUMBER
$('#center_name').on('change', function (e){
  let center_id = $(this).val();     
  $.ajax({
    url: 'data/data-center-codes.php',
    data: {
      center_id: center_id
    },
    method: 'POST',
    dataType: 'json',
    error: function (e){
      console.error(e);
    },
    success: function (r){
      globe_center_code = "";

      if (r.result){
        let center_code = r.data[0].CODE;
           $('#center_code').val(center_code);
         
         // CENTER CODE DISPALY IN MEMBER NUMBER
         globe_center_code = center_code;

          gen_member_number();
        $('#center_code').val(center_code);
        
      }else{
        console.error(r.debug);
      }
    }
  });
});


//GROUP NAME DISPALY
$('#center_name').on('change', function (e){
  let center_id = $(this).val();
  $.ajax({
    url: 'data/data-groups.php',
    data: {
      center_id: center_id,
    },
    method: 'POST',
    dataType: 'json',
    error: function (e){
      console.error(e);
    },
    success: function (r){
      $('#group_name').html('<option></option>');

      if (r.result){
        $.each(r.data, function (k, v){
          let group_name = v.group_name;
          let group_id = v.group_id;
          // let center_code = center_code;
          let html = "";

          html = "<option value='"+group_id+"'>"+group_name+"</option>";

          $('#group_name').append(html);
        });
      }else{
        console.error(r.debug);
      }

      $('#group_name').trigger("chosen:updated");
    }
  });
});



$('#spousename').on('keyup', function(e){
    if(e.which==9){
    var national = $('#nic').val();

         var vali = /[0-9]{9}[x|X|v|V]$/gm;
         var letters = /^[A-Za-z]+$/;

        if(national.length>12){
           swal("Invalid NIC!", "Please Check NIC No You Entered.");
           $('#nic').val('');
        } else {
                var patt = /\d+/gm;
                var res = patt.exec(national);
               

                 if(res[0].length==12){
                       validation = true;

                } else if (res[0].length==9){
                
                 if(vali.exec(national)){
                        validation = true;
                    }else{
                    swal("Invalid NIC!", "Please Check NIC No You Entered.");
                     $('#nic').val('');
                    }
                } else if (res[0].length<12){
                    validation = false;
                   swal("Invalid NIC!", "Please Check NIC No You Entered.");
                    $('#nic').val('');
                }      
            }
    }
});

$('#spousename').mousedown(function(){
 var national = $('#nic').val();

         var vali = /[0-9]{9}[x|X|v|V]$/gm;
         var letters = /^[A-Za-z]+$/;

        if(national.length>12){
           swal("Invalid NIC!", "Please Check NIC No You Entered.");
           $('#nic').val('');
        } else {
                var patt = /\d+/gm;
                var res = patt.exec(national);
               

                 if(res[0].length==12){
                       validation = true;

                } else if (res[0].length==9){
                
                 if(vali.exec(national)){
                        validation = true;
                    }else{
                    swal("Invalid NIC!", "Please Check NIC No You Entered.");
                     $('#nic').val('');
                    }
                } else if (res[0].length<12){
                    validation = false;
                   swal("Invalid NIC!", "Please Check NIC No You Entered.");
                    $('#nic').val('');
                }      
            }
      });


$('#spousedob').on('keyup',function(e){
     if(e.which==9){
    var contact = $('#spousecontact').val();
    var patt = /\d+/gm;

     if(contact != ""){
    if(contact.length!=10 || isNaN(contact)){
           swal("Invalid Phone Number");
            $('#spousecontact').val('');
        }
      } 
 }
});


$('#spouseincome').on('keyup',function(e){
     if(e.which==9){
     var national = $('#spouseid').val();

         var vali = /[0-9]{9}[x|X|v|V]$/gm;
         var letters = /^[A-Za-z]+$/;

        if(national.length>12){
           swal("Invalid NIC!", "Please Check NIC No You Entered.");
           $('#spouseid').val('');
        } else {
                var patt = /\d+/gm;
                var res = patt.exec(national);
               

                 if(res[0].length==12){
                       validation = true;

                } else if (res[0].length==9){
                
                 if(vali.exec(national)){
                        validation = true;
                    }else{
                    swal("Invalid NIC!", "Please Check NIC No You Entered.");
                     $('#spouseid').val('');
                    }
                } else if (res[0].length<12){
                    validation = false;
                   swal("Invalid NIC!", "Please Check NIC No You Entered.");
                    $('#spouseid').val('');
                }      
            } 
 }
});

$('#spouseincome').mousedown(function(){

   var national = $('#spouseid').val();

         var vali = /[0-9]{9}[x|X|v|V]$/gm;
         var letters = /^[A-Za-z]+$/;

        if(national.length>12){
           swal("Invalid NIC!", "Please Check NIC No You Entered.");
           $('#spouseid').val('');
        } else {
                var patt = /\d+/gm;
                var res = patt.exec(national);
               

                 if(res[0].length==12){
                       validation = true;

                } else if (res[0].length==9){
                
                 if(vali.exec(national)){
                        validation = true;
                    }else{
                    swal("Invalid NIC!", "Please Check NIC No You Entered.");
                     $('#spouseid').val('');
                    }
                } else if (res[0].length<12){
                    validation = false;
                   swal("Invalid NIC!", "Please Check NIC No You Entered.");
                    $('#spouseid').val('');
                }      
            } 

});

$('#income').on('keyup', function(e){
    if(e.which==9){
    var national = $('#nic').val();

         var vali = /[0-9]{9}[x|X|v|V]$/gm;
         var letters = /^[A-Za-z]+$/;

        if(national.length>12){
           swal("Invalid NIC!", "Please Check NIC No You Entered.");
           $('#nic').val('');
        } else {
                var patt = /\d+/gm;
                var res = patt.exec(national);
               

                 if(res[0].length==12){
                       validation = true;

                } else if (res[0].length==9){
                
                 if(vali.exec(national)){
                        validation = true;
                    }else{
                    swal("Invalid NIC!", "Please Check NIC No You Entered.");
                     $('#nic').val('');
                    }
                } else if (res[0].length<12){
                    validation = false;
                   swal("Invalid NIC!", "Please Check NIC No You Entered.");
                    $('#nic').val('');
                }      
            }
    }
});

$('#income').mousedown(function(){
 var national = $('#nic').val();

         var vali = /[0-9]{9}[x|X|v|V]$/gm;
         var letters = /^[A-Za-z]+$/;

        if(national.length>12){
           swal("Invalid NIC!", "Please Check NIC No You Entered.");
           $('#nic').val('');
        } else {
                var patt = /\d+/gm;
                var res = patt.exec(national);
               

                 if(res[0].length==12){
                       validation = true;

                } else if (res[0].length==9){
                
                 if(vali.exec(national)){
                        validation = true;
                    }else{
                    swal("Invalid NIC!", "Please Check NIC No You Entered.");
                     $('#nic').val('');
                    }
                } else if (res[0].length<12){
                    validation = false;
                   swal("Invalid NIC!", "Please Check NIC No You Entered.");
                    $('#nic').val('');
                }      
            }
      });

$('#spousedob').mousedown(function(){
  
    var contact = $('#spousecontact').val();
    var patt = /\d+/gm;
   if(contact != ""){
    if(contact.length!=10 || isNaN(contact)){
           swal("Invalid Phone Number");
            $('#spousecontact').val('');
        }
      }
});


$('#spouseincome').mousedown(function(){

   var national = $('#spouseid').val();

         var vali = /[0-9]{9}[x|X|v|V]$/gm;
         var letters = /^[A-Za-z]+$/;

        if(national.length>12){
           swal("Invalid NIC!", "Please Check NIC No You Entered.");
           $('#spouseid').val('');
        } else {
                var patt = /\d+/gm;
                var res = patt.exec(national);
               

                 if(res[0].length==12){
                       validation = true;

                } else if (res[0].length==9){
                
                 if(vali.exec(national)){
                        validation = true;
                    }else{
                    swal("Invalid NIC!", "Please Check NIC No You Entered.");
                     $('#spouseid').val('');
                    }
                } else if (res[0].length<12){
                    validation = false;
                   swal("Invalid NIC!", "Please Check NIC No You Entered.");
                    $('#spouseid').val('');
                }      
            } 

});



$('#spouseincome').on('keyup',function(e){
     if(e.which==9){
     var national = $('#spouseid').val();

         var vali = /[0-9]{9}[x|X|v|V]$/gm;
         var letters = /^[A-Za-z]+$/;

        if(national.length>12){
           swal("Invalid NIC!", "Please Check NIC No You Entered.");
           $('#spouseid').val('');
        } else {
                var patt = /\d+/gm;
                var res = patt.exec(national);
               

                 if(res[0].length==12){
                       validation = true;

                } else if (res[0].length==9){
                
                 if(vali.exec(national)){
                        validation = true;
                    }else{
                    swal("Invalid NIC!", "Please Check NIC No You Entered.");
                     $('#spouseid').val('');
                    }
                } else if (res[0].length<12){
                    validation = false;
                   swal("Invalid NIC!", "Please Check NIC No You Entered.");
                    $('#spouseid').val('');
                }      
            } 
 }
});

$('#mobile2').on('keyup',function(e){
     if(e.which==9){
    var contact = $('#mobile1').val();
    var patt = /\d+/gm;
   
     if(contact != ""){
    if(contact.length!=10 || isNaN(contact)){
           swal("Invalid Phone Number");
            $('#mobile1').val('');
        }
      }
 }
});

$('#mobile2').mousedown(function(){

     var contact = $('#mobile1').val();
    var patt = /\d+/gm;
   
     if(contact != ""){
    if(contact.length!=10 || isNaN(contact)){
           swal("Invalid Phone Number");
            $('#mobile1').val('');
        }
      }

});

$('#fixed1').on('keyup',function(e){
     if(e.which==9){
    var contact = $('#mobile2').val();
    var patt = /\d+/gm;
   if(contact != ""){
    if(contact.length!=10 || isNaN(contact)){
           swal("Invalid Phone Number");
            $('#mobile2').val('');
        }
    }
 }
});

$('#fixed1').mousedown(function(){

    var contact = $('#mobile2').val();
    var patt = /\d+/gm;
   if(contact != ""){
    if(contact.length!=10 || isNaN(contact)){
           swal("Invalid Phone Number");
            $('#mobile2').val('');
        }
    }
});

$('#fixed2').on('keyup',function(e){
     if(e.which==9){
    var contact = $('#fixed1').val();
    var patt = /\d+/gm;
   if(contact !=""){
    if(contact.length!=10 || isNaN(contact)){
           swal("Invalid Phone Number");
            $('#fixed1').val('');
        }
    }
 }
});

$('#fixed2').mousedown(function(){

   var contact = $('#fixed1').val();
    var patt = /\d+/gm;
   if(contact !=""){
    if(contact.length!=10 || isNaN(contact)){
           swal("Invalid Phone Number");
            $('#fixed1').val('');
        }
    }

});

    $('#form-main').on('submit', function (e){

        e.preventDefault();
         var id = $('#id').val();
         var op = (id == 0) ? "insert" : "update";
         var validation = false;

         var formdata = $('#form-main').serializeArray();
         formdata.push({'name':'operation','value':op});

      var reg_date = $('#registered').val();
      var ful_name = $('#fullname').val();
      var ini_name = $('#initialname').val();
      var dob = $('#dob').val();
      var nic = $('#nic').val();
      var income = $('#income').val();
      var status = $('#status').val();
      var member_num_code = $('#member_num_code').val();

if(reg_date == "" || ful_name == "" || ini_name == "" || dob == "" || nic == "" || income == ""){

     if(reg_date == ""){

        document.getElementById('registered').style.borderColor = "red";
        document.getElementById("registered").value = "REGISTERED DATE IS REQUIRED";
        document.getElementById("registered").style.color = "red";

          $("#registered").mousedown(function(){
              
              $('#registered').val('');
              document.getElementById("registered").style.color = "black";
          });

     }


     if(ful_name == ""){

      document.getElementById('fullname').style.borderColor = "red";
      document.getElementById("fullname").value = "FULL NAME IS REQUIRED";
      document.getElementById("fullname").style.color = "red";

      $("#fullname").mousedown(function(){

        $('#fullname').val('');
        document.getElementById("fullname").style.color = "black";
      });

      $('#calname').on('keydown',function(e){

            if(e.which==9){
               $('#fullname').val('');
               document.getElementById("fullname").style.color = "black";
            }
      });

     }

      if(ini_name == ""){

      document.getElementById('initialname').style.borderColor = "red";
      document.getElementById("initialname").value = "INITIAL NAME IS REQUIRED";
      document.getElementById("initialname").style.color = "red";

      $("#initialname").mousedown(function(){

        $('#initialname').val('');
        document.getElementById("initialname").style.color = "black";
      });

      $('#fullname').on('keydown',function(e){

            if(e.which==9){
               $('#initialname').val('');
               document.getElementById("initialname").style.color = "black";
            }
      });

     }

     if(dob == ""){

      document.getElementById('dob').style.borderColor = "red";
      document.getElementById("dob").value = "DATE OF BIRTH IS REQUIRED";
      document.getElementById("dob").style.color = "red";

      $("#dob").mousedown(function(){

        $('#dob').val('');
        document.getElementById("dob").style.color = "black";
      });

      $('#initialname').on('keydown',function(e){

            if(e.which==9){
               $('#dob').val('');
               document.getElementById("dob").style.color = "black";
            }
      });

     }

     if(nic == ""){

      document.getElementById('nic').style.borderColor = "red";
      document.getElementById("nic").value = "NIC NO IS REQUIRED";
      document.getElementById("nic").style.color = "red";

      $("#nic").mousedown(function(){

        $('#nic').val('');
        document.getElementById("nic").style.color = "black";
      });

      $('#dob').on('keydown',function(e){

            if(e.which==9){
               $('#nic').val('');
               document.getElementById("nic").style.color = "black";
            }
      });

     }

     if(income == ""){

      document.getElementById('income').style.borderColor = "red";
      document.getElementById("income").value = "INCOME IS REQUIRED";
      document.getElementById("income").style.color = "red";

      $("#income").mousedown(function(){

        $('#income').val('');
        document.getElementById("income").style.color = "black";
      });

      $('#nic').on('keydown',function(e){

            if(e.which==9){
               $('#income').val('');
               document.getElementById("income").style.color = "black";
            }
      });

     }

}
 
else if(reg_date!="REGISTERED DATE IS REQUIRED" || ful_name!="FULL NAME IS REQUIRED" || ini_name!="INITIAL NAME IS REQUIRED" || dob!="DATE OF BIRTH IS REQUIRED" || nic!="NIC NO IS REQUIRED" || income!="INCOME IS REQUIRED"){

        //document.getElementById('income').style.borderColor = "";
        // document.getElementById('nic').style.borderColor = "";
        // document.getElementById('dob').style.borderColor = "";
        // document.getElementById('initialname').style.borderColor = "";
        // document.getElementById('fullname').style.borderColor = "";
        // document.getElementById('registered').style.borderColor = "";
        
        // $('#btn_submit').prop('disabled', true);
        // $("i", '#btn_submit').toggleClass("fa fa-angle-right fa fa-spinner fa-spin");
        
            $.ajax({
            url: 'customer_crud.php',
            data: formdata,
            success: function(r){
                var msg_typ = "info";
                var msg_txt = "";

               
                if (r.result){
                    // msg_typ = 'success';
                    // msg_txt = '<h4>Success!</h4> <p>Customer saved</p>';

                    swal("Succes","customer Saved","success");

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
                  swal("Succes","customer Saved","success");

                  dt.ajax.reload();
                  dt.draw();
                }
        });
  }
});

    $('#btn-reset').on('click', function (e){
        $('#id').val("0");

        $('#status').val(1);
        $('#status').trigger("chosen:updated");
        
        $('#search').val("");
        $('#search').trigger("chosen:updated");
        
        $('#branch_name').val("");
        $('#center_name').val("");
        $('#group_name').val("");
        $('#registered').val("");
        $('#member_number').val("");
        $('#fullname').val("");
        $('#initialname').val("");
        $('#dob').val("");
        $('#nic').val("");
        $('#income').val("");
        $('#spousename').val("");
        $('#spousecontact').val("");
        $('#spousedob').val("");
        $('#spouseid').val("");
        $('#spouseincome').val("");
        $('#homeaddress').val("");
        $('#businessadd').val("");
        $('#mobile1').val("");
        $('#mobile2').val("");
        $('#fixed1').val("");
        $('#fixed2').val("");
        
        document.getElementById('income').style.borderColor = "";
        document.getElementById('nic').style.borderColor = "";
        document.getElementById('dob').style.borderColor = "";
        document.getElementById('initialname').style.borderColor = "";
        document.getElementById('fullname').style.borderColor = "";
        document.getElementById('member_number').style.borderColor = "";
        document.getElementById('registered').style.borderColor = "";
        
        document.getElementById('income').style.color = "";
        document.getElementById('nic').style.color = "";
        document.getElementById('dob').style.color = "";
        document.getElementById('initialname').style.color = "";
        document.getElementById('fullname').style.color = "";
        document.getElementById('member_number').style.color = "";
        document.getElementById('registered').style.color = "";

    });
    /*********** Form Control End ***********/
        
    </script>
        

    
    <?php mysqli_close($con_main); ?>
