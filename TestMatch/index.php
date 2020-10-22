<?php include 'config.php'; ?>
<?php include 'template_start.php'; ?>

<!-- Page content -->
<div id="page-content">
    <!-- Blank Header -->
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i class="gi gi-podium"></i>Add Authors<br>
            </h1>
        </div>
    </div>
    <!--End Blank Header -->
    <div class="row">
        <div class="col-md-12">
            <div class="block full">
                <div class="block-title">
                    <ul class="nav nav-tabs">
                        <div class="col-md-4">
                            <li>Create Author </a></li>
                        </div>
                    </ul>
                </div>

                <form id="form-header" name="form-header" method="post" class="form-horizontal form-bordered">

                    <div class="form-group">
                        <label class="col-md-2 control-label" for="authorname">Author Name</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control OnlyText" id="authorname" name="authorname" placeholder="Author Name" required>
                        </div>
                        <label class="col-md-1 control-label" for="displayname">Display Name</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="displayname" name="displayname" placeholder="Display Name" required>
                        </div>
                    </div><br>

                    <div class="form-group">  
                        <label class="col-md-2 control-label" for="nic">Author NIC</label>
                        <div class="col-md-2">
                           <input type="text" id="nic" name="nic" class="form-control" placeholder="Enter NIC">
                           
                        </div> 

                         <label class="col-md-2 control-label" for="status">Status</label>
                        <div class="col-md-4">
                            <select id="status" name="status" class="select-chosen" data-placeholder="Choose Status">
                                <option></option><!-- Required for data-placeholder attribute to work with Chosen plugin -->
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            
                        </div>
                </div>

                
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="dob">DOB</label>
                        <div class="col-md-2">
                            <input type="text" id="dob" name="dob" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="yyyy-mm-dd" required>
                        </div>
                        <label class="col-md-2 control-label" for="empstatus">Employee status</label>
                         <div class="col-md-4">                           
                            <select id="empstatus" name="empstatus" class="select-chosen" data-placeholder="Enter Emp status">
                                <option value="single">Single</option>
                                <option value="married">Married</option>
                            </select>
                           
                        </div>
                    </div>

                    

                    <div class="form-group form-actions">
                        <div class="col-md-4">
                            <input type="hidden" class="form-control" id="uniqe_id" name="uniqe_id" value="0">
                        </div>
                        <div class="col-md-6">
                            <button type="submit" id="header_datails" class="btn btn-primary primary-btn pull-right"><i class="fa fa-plus-circle"></i> Submit</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    
    <div class="block full">
              <div class="block-title">
                <h2>Author Details</h2>
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
        "title": "ground_id"
      },
      {
        "data": "team_id",
        "name": "team_id",
        "title": "team_id"
      },
      {
        "data": "match_note",
        "name": "match_note",
        "title": "match_note"
      },
      {
        "data": "match_overs",
        "name": "match_overs",
        "title": "match_overs"
      },
      {
        "data": "Inning",
        "name": "Inning",
        "title": "Inning"
      }
    //   {
    //     "data": "actions",
    //     "name": "actions",
    //     "title": "Actions",
    //     "searchable": false,
    //     "orderable": false,
    //     mRender: function(data, type, row) {
    //       return '</button><button id="btn-row-delete" class="btn btn-danger" title="Delete"><i class="fa fa-times"></i></button></div>'
    //     }
    //  }
    ],
    "columnDefs": [{
      "className": "dt-center",
      "targets": [0, 1, 2, 3, 4, 5, 6]
    }],

    "language": {
      "emptyTable": "No po line item to show..."
    },
    "ajax": "grid_data_author.php"
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
                url: 'backend.php',
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
                        alert('Insert Success, User ID : '+ r.data);
                        $('#form-header').trigger('reset');
                    } else {
                        alert('Error');

                    }
                }
            });
        }
    });
    //------------------------ END INSERT FUNCTION --------------------

    //-------------------- start Insert function -------------------------------------------
    // $('#header_datails').on('click', function(e) {
    //     console.log('testing');

    //     var formdata = $('#form-header').serializeArray();

    //     console.log(formdata);
    //     $.ajax({
    //         url: 'backend/backend.php',
    //         data: formdata,
    //         method: 'post',
    //         beforeSend: function() {
    //             $('#header_datails').button('loading');
    //             NProgress.start();
    //         },
    //         complete: function() {
    //             $('#header_datails').button('reset');
    //             NProgress.done();
    //         },
    //         error: function(r) {},
    //         success: function(r) {
    //             if (r.result) {
    //                 alert('Success');

    //             } else {
    //                 alert('Error');

    //             }
    //         }
    //     });
    // });

    //-------------------- end Insert function -------------------------------------------
</script>
