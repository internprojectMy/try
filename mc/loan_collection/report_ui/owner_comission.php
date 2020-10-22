<?php
require_once ('../../config.php');
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

		<div class="form-group form-actions">
			<input type="hidden" name="report_url" id="report_url" value="reports/owner_comission_report.php"/>

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

	
	