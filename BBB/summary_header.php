<?php 
include'config.php'; 
include'template_start.php'; 
//include'function.php'; 
?>

<!-- Page content -->
<div id="page-content">
    <!-- Blank Header -->
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i class="gi gi-podium"></i>View Match Summary details<br>
            </h1>
        </div>
    </div>
    <!--End Blank Header -->
    <div class="row">
        <div class="col-md-12">
            <div class="block full">
                <form id="form-header" name="form-header" method="post" class="form-horizontal form-bordered">


                   <div class="block full">
              <div class="block-title">
                <h2>Match Summary Details</h2>
              </div>
              <div class="table-responsive">
                <table id="table-data" class="table table-condensed table-striped table-hover"></table>
              </div>
            </div> 
          </form>
            </div>
        </div>
    </div>



    
    <div class="block full">
              <div class="block-title">
                <h2>Match Summary Details</h2>
              </div>
              <div class="table-responsive">
                <table id="table-data" class="table table-condensed table-striped table-hover"></table>
              </div>
            </div>
      
    
</div>
<!-- end Page content -->
<!------ Footer -------->
<footer class="clearfix">
    <div class="pull-left">
        Online Support Lectures - PHP
    </div>
    <div class="pull-right">
        DTInnovations - 17/04/2020
    </div>
</footer>
<!---- END Footer ---->

<?php include 'template_scripts.php'; ?>
<?php include  'template_end.php'; ?>
<script src="js/jquery.alphanum-master/jquery.alphanum-master/jquery.alphanum.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>

<script type="text/javascript">
    //----------- start date validation ----------
    $('#date').datepicker({
     //  endDate: new Date()
        startDate: new Date()
    });
    //-----------end date validation ----------

    //-------- start numbers only function  -------
    $(".OnlyNumber").numeric({
        allowMinus: false,
        allowSpace: false,
        maxDigits: 10
    });
    //-------- end numbers only function -------

    //------------ start text only function -------
    $(".OnlyText").alphanum({
        allowNumeric: false,
        allowOtherCharSets: false
    });
    //------------ end text only function -------
   //********LINE ITEMS DATA TABLE****************
   App.datatables();
  var dt = $('#table-data').DataTable({
    "processing": true,
    "serverSide": true,
    "select": true,
    "columns": [{
        "className": 'details-control',
        "orderable": false,
        "data": null,
        "defaultContent": '',
        "searchable": true
      },
      {
        "data": "id",
        "name": "id",
        "title": "id",
        "visible": false
      },
      {
        "data": "ground_id",
        "name": "ground_id",
        "title": "Ground Name"
      },
      {
        "data": "match_note",
        "name": "match_note",
        "title": "Match Note"
      },
      {
        "data": "match_result",
        "name": "match_result",
        "title": "Match Result"
      },
      {
        "data": "official_note",
        "name": "official_note",
        "title": "Official Note"
      }
    ],
    "columnDefs": [{
      "className": "dt-center",
      "targets": [0, 1, 2, 3, 4, 5 ]
    }],

    "language": {
      "emptyTable": "No po line item to show..."
    },
    "ajax": "grid_data_summary.php"
  });


    //-------- start insert function --------------
    $('#form-header').validate({
        errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
        errorElement: 'div',
        errorPlacement: function(error, e) {
            e.parents('.form-group > div').append(error);
        },
        highlight: function(e) {
            $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
            $(e).closest('.help-block').remove();
        },
        success: function(e) {
            e.closest('.form-group').removeClass('has-success has-error');
            e.closest('.help-block').remove();
        },
        submitHandler: function() {

            var formdata = $('#form-header').serializeArray();
            console.log(formdata);
            $.ajax({
                url: 'backendS.php',
                data: formdata,
                method: 'post',
                beforeSend: function() {
                    $('#header_datails').button('loading');
                    NProgress.start();
                },
                complete: function() {
                    $('#header_datails').button('reset');
                    NProgress.done();
                },
                error: function(r) {},
                success: function(r) {
                    if (r.result) {
                        alert('Insert Success, Entered match number : '+ r.data);
                        $('#form-header').trigger('reset');
                    } else {
                        alert('Error');

                    }
                }
            });
        }
    });
    
    //-------------------- end Insert function -------------------------------------------
</script>
