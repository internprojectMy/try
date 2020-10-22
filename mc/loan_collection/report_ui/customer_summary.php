<?php
require_once ('../config.php');
?>
		
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
			<input type="hidden" name="report_url" id="report_url" value="reports/agentsreport.php"/>

			<div class="col-md-12">
				<button type="submit" class="btn btn-success primary-btn pull-right"><i class="fa fa-angle-right"></i> Submit</button>
				<button type="reset" class="btn btn-warning"><i class="fa fa-repeat"></i>Reset</button>
			</div>
		</div>
		<script type="text/javascript">
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

	
	