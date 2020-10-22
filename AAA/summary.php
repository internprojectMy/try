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
                <i class="gi gi-podium"></i>Add Match Summary details<br>
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
                            <li>Match Details </a></li>
                        </div>
                    </ul>
                </div>

                <form id="form-header" name="form-header" method="post" class="form-horizontal form-bordered">

                    <div class="form-group">

                    <label class="col-md-2 control-label" for="ground_id">Ground Name:</label>
                    <div class="col-md-3">
                    <select id="ground_id" name="ground_id"  class="select-chosen" data-placeholder="Enter Emp status" >
                    <option >Select Ground Name</option>
                    <?php
                      $query = "
                      SELECT * FROM slground
                      ORDER BY groundname ASC
                      ";
                      $sql = mysqli_query($con_main, $query);

                      while ($type = mysqli_fetch_array($sql)) {
                        echo ("<option value=\"" . $type['ground_id'] . "\">" . $type['groundname'] . "</option>");
                      }
                      ?>
                    
                    </select>
                    </div>

                    <label class="col-md-1 control-label" for="match_note">Match Note : </label>
                    <div class="col-md-3">
                    <input type="text" id="match_note" name="match_note" class="form-control" placeholder="Enter Note">
                    </div> 

                    <label class="col-md-1 control-label" for="team_id">Team Name:</label>
                    <div class="col-md-2">
                    <select name="team_id" id="team_id" class="select-chosen" data-placeholder="Enter Emp status" >
                    <option >Select Team Name</option>
                    <?php
                      $query = "
                      SELECT * FROM slteam
                      ORDER BY teamname ASC
                      ";
                      $sql = mysqli_query($con_main, $query);

                      while ($type = mysqli_fetch_array($sql)) {
                        echo ("<option value=\"" . $type['team_id'] . "\">" . $type['teamname'] . "</option>");
                      }
                      ?>
                    
                    </select>
                    </div><br>
                    </div>

                    <div class="form-group">

                    <label class="col-md-2 control-label" for="match_score">Match Score:</label>
                    <div class="col-md-3">
                    <input type="text" id="match_score" name="match_score" class="form-control" placeholder="Enter Score" >
                    </input>
                    </div>

                    <label class="col-md-1 control-label" for="match_overs">Match Overs: </label>
                     <div class="col-md-3">
                     <input type="text" id="match_overs" name="match_overs" class="form-control"  placeholder="Enter overs">
                     </div> 

                    <label  class="col-md-1 control-label" for="Inning">Inning</label>
                    <div class="col-md-2">
                    <select name="Inning" id="Inning"  class="form-control"  >
                    <option >1st Inning</option>
                    <option > 2nd Inning</option>
                    <option > T20 over</option>
                    </select>
                    </div>

                    </div>

                    <div class="form-group">

                    <label class="col-md-2 control-label" for="match_result">Match Results:</label>
                    <div class="col-md-3">
                    <input type="text" id="match_result" name="match_result"  class="form-control" placeholder="Enter Results"  >
                    </input>
                    </div>

                    <label class="col-md-1 control-label" for="official_note">Official Note : </label>
                    <div class="col-md-3">
                    <input type="text" id="official_note" name="official_note" class="form-control" placeholder="Enter Official Note" >
                    </div> 

                    </div>
                   <li>Batsman Details </a></li>

                    <div class="form-group">  
                        <label class="col-md-2 control-label" for="playerName1">1st Batsman Name: </label>
                        <div class="col-md-3">
                        <input type="text" id="playerName1" name="playerName1" class="form-control" placeholder="Enter Name">
                        </div> 

                         <label class="col-md-2 control-label" for="player1_score">Marks</label>
                         <div class="col-md-2">
                         <input type="text" id="player1_score" name="player1_score" class="form-control" placeholder="Enter marks" >
                         </div> 
                     </div>


                     
                     <div class="form-group">  
                      
                        <label class="col-md-2 control-label" for="playerName2">2nd Batsman Name: </label>
                        <div class="col-md-3">
                        <input type="text" id="playerName2" name="playerName2" class="form-control" placeholder="Enter Name">
                        </div> 

                         <label class="col-md-2 control-label" for="player2_score">Marks</label>
                         <div class="col-md-2">
                         <input type="text" id="player2_score" name="player2_score" class="form-control" placeholder="Enter marks" >
                         </div> 
                     </div>


                     <div class="form-group">

                        <label class="col-md-2 control-label" for="playerName3">3rd Batsman Name: </label>
                        <div class="col-md-3">
                        <input type="text" id="playerName3" name="playerName3" class="form-control" placeholder="Enter Name" >
                        </div> 

                         <label class="col-md-2 control-label" for="player3_score">Marks</label>
                         <div class="col-md-2">
                         <input type="text" id="player3_score" name="player3_score" class="form-control" placeholder="Enter marks" >
                         </div> 
                     </div>
                     <li>Bowlers Details </a></li>

                      <div class="form-group">  

                        <label class="col-md-2 control-label" for="bowler1">1st Bowler Name: </label>
                        <div class="col-md-3">
                        <input type="text" id="bowler1" name="bowler1" class="form-control" placeholder="Enter Name">
                        </div> 

                         <label class="col-md-2 control-label" for="bowler1_wickets">Marks</label>
                         <div class="col-md-2">
                         <input type="text" id="bowler1_wickets" name="bowler1_wickets" class="form-control" placeholder="Enter marks">
                         </div> 
                     </div>

                      <div class="form-group"> 

                        <label class="col-md-2 control-label" for="bowler2">2nd Bowler Name: </label>
                        <div class="col-md-3">
                        <input type="text" id="bowler2" name="bowler2" class="form-control" placeholder="Enter Name" >
                        </div> 

                         <label class="col-md-2 control-label" for="bowler2_wickets">Marks</label>
                         <div class="col-md-2">
                         <input type="text" id="bowler2_wickets" name="bowler2_wickets" class="form-control" placeholder="Enter marks">
                         </div> 
                     </div>

                      <div class="form-group">  
                        <label class="col-md-2 control-label" for="bowler3">3rd Bowler Name: </label>
                        <div class="col-md-3">
                        <input type="text" id="bowler3" name="bowler3" class="form-control" placeholder="Enter Name">
                        </div> 

                         <label class="col-md-2 control-label" for="bowler3_wickets">Marks</label>
                         <div class="col-md-2">
                         <input type="text" id="bowler3_wickets" name="bowler3_wickets" class="form-control" placeholder="Enter marks" >
                         </div> 
                     </div>



                    <div class="form-group form-actions">
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="uniqe_id" name="uniqe_id" value="0">
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
        "data": "DT_RowId",
        "name": "DT_RowId",
        "title": "id"
      //  "visible": false
      },
      {
        "data": "ground_id",
        "name": "ground_id",
        "title": "Ground Name"
      },
      {
        "data": "team_id",
        "name": "team_id",
        "title": "Team Name"
      },
      {
        "data": "match_note",
        "name": "match_note",
        "title": "Match Note"
      },
      {
        "data": "match_score",
        "name": "match_score",
        "title": "Match Score"
      },
      {
        "data": "match_overs",
        "name": "match_overs",
        "title": "Match Overs"
      },
      {
        "data": "Inning",
        "name": "Inning",
        "title": "Inning"
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
      },
      {
        "data": "playerName1",
        "name": "playerName1",
        "title": "1st player"
      },
      {
        "data": "player1_score",
        "name": "player1_score",
        "title": "1st player score"
      },
      {
        "data": "playerName2",
        "name": "playerName2",
        "title": "2nd player"
      },
      {
        "data": "player2_score",
        "name": "player2_score",
        "title": "2nd player score"
      },
      {
        "data": "playerName3",
        "name": "playerName3",
        "title": "3rd player"
      },
      {
        "data": "player3_score",
        "name": "player3_score",
        "title": "3rd player score"
      },
      {
        "data": "bowler1",
        "name": "bowler1",
        "title": "1st Bowler"
      },
      {
        "data": "bowler2",
        "name": "bowler2",
        "title": "2nd Bowler"
      },
      {
        "data": "bowler3",
        "name": "bowler3",
        "title": "3rd Bowler"
      },
      {
        "data": "bowler1_wickets",
        "name": "bowler1_wickets",
        "title": "1st bowler wickets"
      },
      {
        "data": "bowler2_wickets",
        "name": "bowler2_wickets",
        "title": "2nd bowler wickets"
      },
      {
        "data": "bowler3_wickets",
        "name": "bowler3_wickets",
        "title": "3rd bowler wickets"
      },
      {
        "data": "actions",
        "name": "actions",
        "title": "Actions",
        "searchable": false,
        "orderable": false,
        mRender: function(data, type, row) {
          return '</button><button id="btn-row-edit" class="btn btn-primary" title="Edit"><i class="fa fa-pencil"></i></button></div>'
        }
     }
    ],
    "columnDefs": [{
      "className": "dt-center",
      "targets": [0, 1, 2, 3, 4, 5, 6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22]
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
                        location.reload();
                    } else {
                        alert('Error');

                    }
                }
        });
    } 


});

    $("#table-data tbody").on('click', '#btn-row-edit', function() {
      //  var rowid= dt.row($(this).parents('tr'));
        var str_id = $(this).closest('tr').attr('id');
        var arr_id = str_id.split("_");

        //var row = dt.row(str_id);
        //var arr_id = str_id.split("_");
        var row_id = arr_id[1];
     //  alert(row_id);
        $.ajax({
            url: 'data_summary.php',
            data: {
                summary_id: row_id
            },
            method: 'POST',
            dataType: 'json',
            beforeSend: function () {
                $('#table-data tbody #'+str_id+' #btn-row-edit').button('loading');
                NProgress.start();
            },
            error: function (e) {
                $.bootstrapGrowl('<h4>Error!</h4> <p>Error retrieving module data</p>', {
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
 
                    $('#uniqe_id').val(r.data[0].summary_id);
                    $('#ground_id').val(r.data[0].ground_id);
                    $('#team_id').val(r.data[0].team_id);
                    $('#match_note').val(r.data[0].match_note);
                    $('#match_score').val(r.data[0].match_score);
                    $('#match_overs').val(r.data[0].match_overs);
                    $('#Inning').val(r.data[0].Inning);
                    $('#match_result').val(r.data[0].match_result);
                    $('#official_note').val(r.data[0].official_note);
                    $('#playerName1').val(r.data[0].playerName1);
                    $('#playerName2').val(r.data[0].playerName2);
                    $('#playerName3').val(r.data[0].playerName3);
                    $('#bowler1').val(r.data[0].bowler1);
                    $('#bowler2').val(r.data[0].bowler2);
                    $('#bowler3').val(r.data[0].bowler3);
                    $('#bowler1_wickets').val(r.data[0].bowler1_wickets);
                    $('#bowler2_wickets').val(r.data[0].bowler2_wickets);
                    $('#bowler3_wickets').val(r.data[0].bowler3_wickets);
                    
                    
                }

                
            },
               complete: function () {
                $('#table-data tbody #'+str_id+' #btn-row-edit').button('Editing');
                NProgress.done();
            }
        });
   });





</script>
