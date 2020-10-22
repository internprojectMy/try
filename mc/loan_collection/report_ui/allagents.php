<?php
require_once ('../../config.php');
?>

         <div class="form-group">
         	<label class="col-md-2 control-label" for="team">Select Team</label>
         	<div class="col-md-4">
	            <select id="team" name="team" class="form-control" size="1" data-placeholder="Choose team"> 
	                <option value="" selected disabled>Select Team</option>
	                    <?php
	                        $query="SELECT
	                            collection_team.id,
	                            collection_team.team_name,
	                            collection_team.`status`
	                                FROM
	                            `collection_team`
	                                WHERE
	                            collection_team.`status` = '1' AND collection_team.id != '10'";

	                              $sql = mysqli_query($con_main, $query);
	                                                                            
	                            while ($type = mysqli_fetch_array($sql)){
	                                 echo ("<option value=\"".$type['id']."\">".$type['team_name']."</option>");
	                                  }
	                     ?>


	             </select>
            </div>

            <label class="col-md-2 control-label" for="agent">Select Agent</label>
               <div class="col-md-4">
               	 <select id="agent" name="agent" class="form-control" size="1">
               	 	<option value="" selected disabled>Select Agent</option>
               	 </select>
               </div>
         </div>


		
		<div class="form-group">
			<label class="col-md-2 control-label" for="from">From</label>
				<div class="col-md-4">
                       <input type="text" id="from" name="from" class="form-control" placeholder="yyyy-mm-dd">
				</div>

			<label class="col-md-2 control-label" for="to">To</label>
				<div class="col-md-4">
					<input type="text" id="to" name="to" class="form-control" placeholder="yyyy-mm-dd">
				</div>				
		</div>

		<div class="form-group">
			<label class="col-md-2 control-label" for="method">Select Payment Method</label>
			  <div class="col-md-4">
	            <select id="method" name="method" class="form-control" size="1" data-placeholder="Choose Payment Method"> 
	                <option value="" selected disabled>Select Method</option>
	                    <?php
	                        $query="SELECT
											collection_team_comission.id,
											collection_team_comission.comid,
											collection_team_comission.agent_comission
									FROM
											`collection_team_comission`";

	                              $sql = mysqli_query($con_main, $query);
	                                                                            
	                            while ($type = mysqli_fetch_array($sql)){
	                                 echo ("<option value=\"".$type['agent_comission']."\">".$type['comid']."</option>");
	                                  }
	                     ?>


	             </select>
            </div>

		</div>

		<div class="form-group form-actions">
			<input type="hidden" name="report_url" id="report_url" value="reports/allagentsreport.php" />

			<div class="col-md-12">
				<button type="submit" class="btn btn-success primary-btn pull-right"><i class="fa fa-angle-right"></i> Submit</button>
				<button type="reset" class="btn btn-warning"><i class="fa fa-repeat"></i>Reset</button>
			</div>
		</div>
		<script type="text/javascript">
                
            $('#team').on('change', function(){
        var cato = $('#team').val();

        $.ajax({
            url: 'data_provider.php',
            data: {
                team: cato
            },
            method: 'post',
            error: function(e){
                alert ('Error requesting agents data');
            },
            success: function(r){
                $('#agent').html('<option value="" selected>All</option>');

                if (r.result){
                    if (r.data.length > 0){
                        $.each(r.data, function (k, v){
                            let option_markup = "";

                            option_markup += "<option value='"+v.id+"'>";
                            option_markup += v.agent_code;
                            option_markup += "</option>";

                            $('#agent').append(option_markup)
                            
                        });
                    }
                }

                $('#team').trigger("chosen:updated");
            }
        });
    });

			$('#from').datepicker({
		    format: 'yyyy-mm-dd',
		    //startDate: '-3d'
		});
					$('#to').datepicker({
		    format: 'yyyy-mm-dd',
		    //startDate: '-3d'
		});
				</script>
			<?php
	mysqli_close($con_main);
	?>

	
	