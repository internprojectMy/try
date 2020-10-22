
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
  $title_suffix = "Reports Master";
?>
<?php include $prefix.'config.php'; ?>
<?php include $prefix.'menu.php'; ?>
<?php include $prefix.'template_start.php'; ?>
<?php include $prefix.'page_head.php'; ?>

<div id="page-content">
<div class="content-header">
<div class="header-section">
  <h1>
  <i class="gi gi-podium"></i>Customer Return Authorization<br><small></small>
  </h1>
  </div>
  </div>
  <ul class="breadcrumb breadcrumb-top">
   <li><a href="../home.php">Home</a></li>
   <li>CRA</li>
   </ul>
   
   <div class="row">
    <div class="col-md-12">
      <div class="block">
        <div class="block-title">
  <h2>Customer Return Authorization</h2>
</div>
<form id="form-main" name="form-main" action="header.php" method="post"  class="form-horizontal form-bordered">
 
   <div class="form-group">
    <div class="col-md-3">                  
<select id="cus" name="cus"  class="select-chosen" data-placeholder="Select Customer" required="" > 

<option></option>
<?php
    $query="SELECT
            mas_customer.id,
            mas_customer.CustomerName
            FROM mas_customer ORDER BY CustomerName Asc";
            $sql = mysqli_query($con_main, $query);                                       
            while ($type = mysqli_fetch_array($sql)){
            echo ("<option value=\"".$type['id']."\">".$type['CustomerName']."</option>");
}
?>

</select>
<span id="cn"></span>
</div>
    
 <label class="col-md-2 control-label"  for="cus_auth">Customer Return Auth.No</label>
  <div class="col-md-2">


  <?php 
      $qu = "SELECT COUNT('cid') as count FROM `customer_return_auth`";
      $sql = mysqli_query($con_main, $qu);
      $row = mysqli_fetch_assoc($sql);
      $num  = $row['count']+1;

   ?>        

 <input id="cra_num" name="cra_num" type="text" class="form-control" value="CRA-00<?php echo $num; ?>" readOnly>
</select>
</div>       
      
<div class="col-md-2">
<select id="qn" name="qn"  class="select-chosen" data-placeholder="Select Quotation No" required=""> 
<option></option>
</select> 
</div> 
   
   <div class="col-md-2">                         
<input type="text" name="tcdq" id="tcdq" readonly class="form-control OnlyNumber" placeholder="" required >
<span id="cd"></span>
  <span class="help-block">Total Cumulative dispatch qty</span>        
</div></div>         

<div class="form-group">

 <label class="col-md-2 control-label" for="doc">Customer Complain Date</label>
<div class="col-md-2">                         
 <input type="text" name="doc" id="doc" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" required><br>
   <span id="docx"></span>

     Time <input type="time"  name="usr_time" id="usr_time" placeholder="hh:mm">

   <span class="help-block">hh:mm:(Am/Pm)</span>   
</div>     
     
 <label class="col-md-2 control-label" for="go">Return to factory On</label>  
 <div class="col-md-2">                         
   <input type="text" name="go" id="go" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" required >
   <span id="geo"></span>
 </div> 


<div class="col-md-3">
<textarea class="form-control" id="cc"   name="cc" rows="2" cols="6" placeholder="Customer Comment" required ></textarea>
<span id="com_vali"></span>
<span class="help-block">Comment</span>   
</div></div>


<div class="form-group">
<label class="col-md-2 control-label" for="moc">Mode of communication</label>
<div class="col-md-2">                         
<select id="moc" name="moc" class="select-chosen" data-placeholder="Mode of coommunication" required>
   
<option></option>

<option value="By Phone">By Phone</option>
<option value="By Email">By Email</option>
<option value="By Fax">By Fax</option>
<option value="In Person(Verbally)">In Person(Verbally)</option>
    </select>
    </div>   

 <div class="col-md-2">                         
 <input type="text" id="cb" name="cb" class="form-control" placeholder="Name & Desig" required >
     <span id="cby"></span>
         <span class="help-block">Communicated By</span>   
</div>
 
<label class="col-md-2 control-label" for="name">Qty to be returned</label>        
<div class="col-md-1">                         
 <input type="text" name="qr" id="qr" class="form-control OnlyNumber" placeholder="Qty" required="">
 <input type="hidden" name="won_id" id="won_id">
 
</div> </div>              

<div class="form-group">
<label class="col-md-2 control-label" for="mdo">Marketing Staff Comment</label>        
<div class="col-md-3">                         
<textarea class="form-control" id="mdo"  name="mdo" rows="2" cols="6" placeholder="Marketing Staff Comment" required ></textarea>

</div>

<label class="col-md-2 control-label" for="ifp">Instruction for production</label>        
<div class="col-md-2">                         
<textarea class="form-control" id="ifp"  name="ifp" rows="2" cols="6" placeholder="" required ></textarea>
<span id="com_vali"></span>  
</div></div>

<!-- Goods will be inspected by gurind staff before return into factory -->
<div class="form-group">
              
<label class="col-md-5 control-label" for="ifp">Goods will be inspected by gurind staff before return into factory</label> 


<div class="col-md-1">
<input type="radio" name="rad" checked="" id="yes" value="yes"> <label for="yes">Yes</label>
</div>
<div class="col-md-1">
<input type="radio" name="rad" id="no" value="no"> <label for="no">No</label>
</div> 
<div class="col-md-4">                         
<input type="text" name="gi" id="gi" class="form-control" placeholder="If yes staff name/if no reason" required>
<span id="qtbn"></span>   
</div></div>

<div id="modal-preloading" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-body">
<table style="width: 100%;" border="0">
<tr>
    <td class="text-center"><i class="fa fa-spinner fa-4x fa-spin"></i></td> 
</tr>
<tr>
    <td class="text-center"><label class="control-label">Please Wait...</label></td> 
</tr>  
</table>
</div>
</div>
</div>
</div>


<div class="form-group form-actions">
<input type="hidden" name="id" id="id" value="0"/>
<div class="col-md-12">
<button type="submit" class="btn btn-success primary-btn pull-right" id="detail_submit2" =""><i class="fa-file-excel-o"></i>Submit</button>
<button type="button" class="btn btn-info" id="print"><i class="fa fa-newspaper-o" ></i>Print</button>
<button type="reset" class="btn btn-warning"><i class="fa fa-repeat" ></i> Reset</button>
<div class="col-md-2">
      
    
<select id="auth_id" name="auth_id"  class="select-chosen" data-placeholder="Select Authorization"> 
<option></option>
<?php
      $query="SELECT
      customer_return_auth.cr_auth,
      customer_return_auth.id
      FROM
      customer_return_auth ORDER BY cr_auth DESC";
      $sql = mysqli_query($con_main, $query);                                       
      while ($type = mysqli_fetch_array($sql)){
      echo ("<option value=\"".$type['id']."\">".$type['cr_auth']."</option>");
      }
?>   
</select>
</div>  
 <div class="form-group" id="update_form">
<div class="col-md-12">  
<h4>Grid Items</h4>                                        
<table class="table">
<tr>
<th>Item Description</th>
<th>Job Type</th>
<th>Glass mark</th>
<th>Length(mm)</th>
<th>Width(mm)</th>
<th>W/O Qty</th>
<th>Cum.Disp.Qty</th>

</tr>
<tbody id="rows">
</tbody>                                      
</table>            
</div> 
</div>
</div>
</div>
</form>
</div>      
</div>
</div></div>
           


<!--  <div class="block full">
<div class="block-title">
<h2>CRA</h2><small></small>
</div>
<div class="table-responsive"><table id="table-data" class="table table-condensed table-striped table-hover"></table></div>    
</div>
</div> -->
<?php include $prefix.'page_footer.php'; ?>
<?php include $prefix.'template_scripts.php'; ?>
<?php include $prefix.'template_end.php'; ?>
<script src="../js/sweetalert.js"></script>
<script src="../js/jquery.alphanum-master/jquery.alphanum-master/jquery.alphanum.js" type="text/javascript"></script>

<script type="text/javascript">
window.setInterval(()=>{
var disp_qty = Number($('#tcdq').val());
var return_qty = Number($('#qr').val());

if(return_qty>disp_qty){
  swal("Error","Dispatch Quantity Exceeded","error");
  $('#qr').val("");
}
  },500);

$('#doc').datepicker({
    endDate: new Date()
  });


$('#go').datepicker({
    startDate: new Date()
  });

 $('#cus').on('change',function(){
    var cusid = $('#cus').val();
    $.ajax({
        url: 'details.php',
        data: {
            customerid : cusid
        },

method: 'post',
error: function(e){
alert ('Error requesting data');
},
success: function(r){


$('#qn').html('<option value=""></option>');
if (r.data3.length > 0){
$.each(r.data3, function (k, v){
let option_markup = "";
option_markup += "<option value='"+v.id+"'>";
option_markup += v.quotation_no;
option_markup += "</option>";
$('#qn').append(option_markup)



});
}
$('#qn').trigger("chosen:updated");

}
});
});

$('#internal_details').hide();
$('#external_details').hide();

$('#sales_type').on('change',function(){

var sp = $('#sales_type').val();

if(sp==1){
   $('#internal_details').show();
   $('#external_details').hide();
}else{
  $('#internal_details').hide();
  $('#external_details').show();
}
});


    /*********** Table Control End ***********/

    /*********** Form Validation and Submission ***********/


$('#print').prop('disabled',false);
$('#print').prop('disabled',false);

$(".OnlyNumber").numeric({
allowMinus   : false,
allowThouSep : false,
allowDecSep : true
});

$("#qr").keyup(function(){
var value = $(this).val();
value = value.replace(/^(0*)/,"");
$(this).val(value);
}); // });     
  
$('#qn').on('change',function(){



var id_ = $('#qn').val(); 
console.log(id_);


$('#rows').html("");

$.ajax({
url:'details.php',
data:{
    id:id_,
            },
method:'post',
 beforeSend: function () {
          $('#modal-preloading').modal('show');
         },
success:function(r){
$('#won_id').val(r.data[0].work_order_no);

console.log($('#won_id').val());

   $('#modal-preloading').modal('hide',);
var total_disp_qty = 0;
$.each(r.data,(i,k)=>{
  var wo_no = (k.work_order_no == null) ? "-" : k.work_order_no;
  var wo_qty = (k.WO_QTY == null) ? "-" : k.WO_QTY;         
  $('#rows').append('<tr><td>'+k.item_description+'</td><td>'+k.job_type+'</td><td>'+k.glass_mark+'</td><td>'+k.length+'</td><td>'+k.width+'</td><td> '
    +wo_qty+'</td><td>'+k.dispatch_qty+'</td></tr>')
total_disp_qty = total_disp_qty - (-k.dispatch_qty); 
})
$('#tcdq').val(total_disp_qty);
  }
});    
});
    
$('#form-main').on('submit', function (e){
e.preventDefault();

var id = $('#id').val();
var op = (id == 0) ? "insert" : "update";

var formdata = $('#form-main').serializeArray();
formdata.push({'name':'operation','value':op});

$.ajax({
url: 'quotation_inquiry_crud1.php',
data: formdata,
success: function(r){
  
      
if (r.result){
$('#print').prop('disabled',false);   
swal("Success","Authorization Successfully Saved. Authorization No Is "+r.cra_num,"success");
   setTimeout(function(){ window.location.reload(); },2500)
   

$('#form-main').trigger('reset');
}    

else{
msg_typ = 'danger';
swal("Warning","Something Went Wrong.","error"); 
}

    }
    });
  });

    

                // $.bootstrapGrowl(msg_txt, {
                //     type: msg_typ,
                //     delay: 2500,
                //     allow_dismiss: true
                // });

                // dt.ajax.reload();
                // dt.draw();
  
$('#form-main').on('reset', function (e){
$('#id').val("0");
$('#internal_details').hide();
$('#external_details').hide();

$('#status').val("1");
$('#status').trigger("chosen:updated");

$('#sales_type').val("");
$('#sales_type').trigger("chosen:updated");

$('#sales_person').val("");
$('#sales_person').trigger("chosen:updated");

$('#qn').val("");
$('#qn').trigger("chosen:updated");

$('#cus').val("");
$('#cus').trigger("chosen:updated");

$('#moc').val("");
$('#moc').trigger("chosen:updated");

$('#details').val("");
$('#name').val("");
$('#email').val("");
$('#phone').val("");
$('#qn').val("");
$('#cus').val("");
$('#cra_num').val("");
});


$('#print').on('click',function(){
var id = $('#auth_id').val();
window.open("tcpdf/examples/header.php?id="+id);
});

</script>
<?php mysqli_close($con_main); ?>  









  





       
                       
           
    
    



    

      

       


  
   
            






  








                                                          


   



     



        
         
             

         

             
 
 
         

  
              


              

   








            
          

 







  