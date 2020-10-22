
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
        <i class="gi gi-podium"></i>Customer Return Note<br><small></small>
      </h1>
    </div>
   </div>
   <ul class="breadcrumb breadcrumb-top">
     <li><a href="../home.php">Home</a></li>
     <li>CRN</li>
   </ul>
   
   <div class="row">
    <div class="col-md-12">
      <div class="block">
        <div class="block-title">
          <h2>Customer Return Note</h2>
        </div>
        <form id="form-main" name="form-main"  method="post"  class="form-horizontal form-bordered">
         
          <div class="form-group">

            <div class="col-md-3">                         
      <select id="cus" name="cus" class="select-chosen" data-placeholder="Customers" required>
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
   </div>
     
  <label class="col-md-2 control-label"  for="ca">CRA No</label>
    <div class="col-md-3">
        <select class="select-chosen" id="cus_auth" name="cus_auth">
     </select>
    </div>   


   
 <label class="col-md-2 control-label"  for="crn">CRN No</label>
<div class="col-md-2">


<?php 
  $qu = "SELECT COUNT('cid') as count FROM `customer_return_note`";
  $sql = mysqli_query($con_main, $qu);
  $row = mysqli_fetch_assoc($sql);
  $num  = $row['count']+1;

?>        
<input id="crn" name="crn" type="text" class="form-control" value="CRN-00<?php echo $num; ?>" readOnly>
  

</select>
</div></div>


<div class="form-group">

<div class="col-md-3"></div>
     
<label class="col-md-2 control-label"  for="ca">Customer Quotation No & Date</label>
  <div class="col-md-3">
      <input id="cqn" name="cqn" type="text" class="form-control" value="" readOnly>
     </select>
  </div>   

<div class="col-md-1"></div>

</div>
   
 <div class="form-group">
   
 <label class="col-md-2 control-label" for="doc">Customer Agreed Return Qty</label>
  <div class="col-md-1">                         
  <input type="text" name="erq" id="erq" readonly class="form-control OnlyNumber" placeholder="" required >
  </div> 

   <label class="col-md-2 control-label" for="date">Actual Return Date</label>  
 <div class="col-md-2">                         
 <!--  <input type="date" onload="getDate()" class="form-control" id="date" name="date" id="date"> -->
 <input type="text" name="date" id="date" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" required >

      
  Actual Return Time   <input type="time"  name="usr_time" id="usr_time" placeholder="hh:mm">
  
         <span class="help-block">hh:mm:(Am/Pm)</span>   
  </div> 



<label class="col-md-2 control-label" for="doc">Actual Return Qty</label>
<div class="col-md-1">                         
<input type="text" name="arq" id="arq"  class="form-control OnlyNumber" placeholder="" required >
</div></div>          

 <div class="form-group form-actions">
           <input type="hidden" name="id" id="id" value="0"/>
          <div class="col-md-12">
            <button type="submit" class="btn btn-success primary-btn pull-right" id="detail_submit" =""><i class="fa-file-excel-o"></i>Submit</button>
            <button type="reset" class="btn btn-warning"><i class="fa fa-repeat"></i> Reset</button>
            <button type="button" class="btn btn-info" id="print"><i class="fa fa-newspaper-o" ></i>Print</button>
            <!-- <marquee><b><font color="blue"> Quotation Report.<b> </marquee> -->
<div class="col-md-2"> 
 <select id="crn_id" name="crn_id"  class="select-chosen" data-placeholder="Select CRN"> 

<option></option>
<?php
      $query="SELECT
              customer_return_note.id,
              customer_return_note.crn
              FROM
              customer_return_note ORDER BY crn DESC";
              $sql = mysqli_query($con_main, $query);                                       
              while ($type = mysqli_fetch_array($sql)){
              echo ("<option value=\"".$type['id']."\">".$type['crn']."</option>");
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
                    <th>Actual Return Qty.</th>
                   
              
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
</div>
</div>
<?php include $prefix.'page_footer.php'; ?>
<?php include $prefix.'template_scripts.php'; ?>
<?php include $prefix.'template_end.php'; ?>

<script src="../js/sweetalert.js"></script>
<script src="../js/jquery.alphanum-master/jquery.alphanum-master/jquery.alphanum.js" type="text/javascript"></script>

<script type="text/javascript">

$('#cus').on('change',function(){
    var cusid = $('#cus').val();
    $.ajax({
        url: 'details_crn.php',
        data: {
            customerid : cusid
        },
        method: 'post',
        error: function(e){
            alert ('Error requesting data');
        },
        success: function(r){
          $('#cus_auth').html('<option value=""></option>');
            if (r.data3.length > 0){
              $.each(r.data3, function (k, v){
                  let option_markup = "";
                  option_markup += "<option value='"+v.cr_auth+"'>";
                  option_markup += v.cr_auth;
                  option_markup += "</option>";
                  $('#cus_auth').append(option_markup)
              });
            }
          $('#cus_auth').trigger("chosen:updated");
        }
    });
 });


$('#cus_auth').on('change',function(){
    var ctmauthid = $('#cus_auth').val();
    $.ajax({
        url: 'details_crn.php',
        data: {
            customerauthid : ctmauthid
        },
        method: 'post',
        error: function(e){
            alert ('Error requesting data');
        },
        success: function(r){ 
          $('#cqn').val(r.quotation_no +"               "+ r.quotation_date);
          $('#erq').val(r.qtbr);
        }
    });
 });



  $('#date').datepicker({
    endDate: new Date()
  });


window.setInterval(()=>{
    var cusag_return_qty = Number($('#erq').val());
    var actual_return_qty = Number($('#arq').val());

    if(actual_return_qty>cusag_return_qty){
      swal("Error","Customer Agreed Quantity Exceeded","error");
      $('#arq').val("");
    }
  },500);

 $('#cus').on('change',function(){
    var cusid = $('#cus').val();
    $.ajax({
        url: 'details_crn.php',
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


      $(".OnlyNumber").numeric({
    allowMinus   : false,
    allowThouSep : false,
    allowDecSep : true
 });




  $("#arq").keyup(function(){
    var value = $(this).val();
    value = value.replace(/^(0*)/,"");
    $(this).val(value);
  });




       
    // });
$('#cus').on('change',(e)=>{
        
        $('#rows').html('');

        var id_ = $('#cus').val();
        var type_ = 5;

$.ajax({
  url:'details_crn.php',
  data:{
      id:id_,
      type:type_
  },
  method:'post',
  error:function(r){
  },


  success:function(r){
    console.log(r);

      var html = "<option></option>"
      $.each(r.data,(i,k)=>{
          
  html +='<option value='+k.cr_auth+'>'+k.cr_auth+' - '+k.won_id+' - '+k.project_reference+'</option>'

      });
      $('#ca').html(html);
      $('#ca').trigger("chosen:updated");

  }
});

$.ajax({
url:'details_crn.php',
data:{
    id:$('#cus').val(),
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






$('#ca').on('change',(e)=>{

var id = $('#ca').val();
console.log(id);
var type_ = 1;

$('#rows').html('');

        $.ajax({
            url:'details_crn.php',
            data:{
                id:id,
                type:type_
            },
            method:'post',
            error:function(r){
              console.log(r);  
            },
            success:function(r){
                // $('#erq').val();
                var rw = '';
                console.log(r);
                // $('#dispI').val(r['dispI']);
                // $('#accI').val(r['accI']);

                console.log(r);
                $.each(r[2],(i,k)=>{

                    if(k.la==null){
                        k.la = 0;    
                    }
                    if(k.total == null){
                        k.total = 0;
                    }

                    if(k.avail ==null){
                        k.avail = 0;
                    }

                    var avail_ = Number(k.cr_auth) - k.total;

                    var a = Number(k.qty) - Number(k.total);
                    
                    rw += '<tr><td>'+k.item_description+'</td><td>'+k.glass_mark+'</td><td>'+k.length+'</td><td>'+k.width+'</td><td>'+k.qty+'</td><td>'+k.TOTAL_DISPATCHED+'</td><td>'+a+'</td><td>'+k.la+'</td><td>'+avail_+'</td><td>'+k.cr_auth+'</td><td><input type="hidden" class="form-control" name="it" id="it" value="'+k.it+'"><input type="number" class="form-control" name="disp" id="disp" value="'+k.auth_disp+'" max="'+k.auth_disp+'"></td><td><input type="text" class="form-control" name="com_cus" id="com_cus" value="'+k.comment_for_disp+'" disabled></td><td><input type="text" class="form-control" name="com_cus" id="com_cus" value="'+k.comment_for_cus+'" disabled></td></tr>';
                }); 
                    $('#rows').html(rw);
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
  url: 'quotation_inquiry_crud.php',
  data: formdata,
  success: function(r){
  
  if (r.result){
   
  swal("Success","Authorization Successfully Saved. Authorization No Is "+r.crn,"success");
       setTimeout(function(){ window.location.reload(); },4000)
        

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

$('#ca').val("");
$('#ca').trigger("chosen:updated");

$('#cus').val("");
$('#cus').trigger("chosen:updated");

$('#auth_id').val("");
$('#auth_id').trigger("chosen:updated");

$('#details').val("");
$('#name').val("");
$('#email').val("");
$('#phone').val("");
});

$('#print').on('click',function(){
var id = $('#crn_id').val();
window.open("tcpdf/examples/crnpdf.php?id="+id);
});

</script>
<?php mysqli_close($con_main); ?>     
    





      
  

               
            
          

         
         
   






     

            
     



     