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



                    <div class="form-group">
                        <div class="col-md-4">
                            <input type="hidden" class="form-control" id="uniqe_id" name="uniqe_id" value="0">
                        </div>
                        <div class="col-md-6">
                            <button type="submit" id="header_datails" class="btn btn-primary primary-btn pull-right"><i class="fa fa-plus-circle"></i> Submit</button>
                        </div>

                        
                    </div>


                       <div class="form-group form-actions">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-6">
                            <li><a href="summary_header.php">Final Result</a></li> 
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