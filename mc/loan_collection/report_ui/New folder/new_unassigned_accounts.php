<?php
require_once ('../../config.php');
?>
		
<div class="form-group">
	<label class="col-md-2 control-label" for="year">Year</label>
	<div class="col-md-4">
		<select id="year" name="year" class="form-control" size="1">
			<option value="0" disabled>Select Year</option>
			<?php
			
				$currently_selected = date('Y'); 
				$earliest_year = 2000; 
				$latest_year = date('Y');
				
				foreach ( range( $latest_year, $earliest_year ) as $i ) {
					print '<option value="'.$i.'"'.($i === $currently_selected ? ' selected="selected"' : '').'>'.$i.'</option>';
				}
			
			?>
		</select>
	</div>

	<label class="col-md-2 control-label" for="month">Month</label>
	<div class="col-md-4">
		<select id="month" name="month" class="form-control" size="3" multiple>
			<option value="1">January</option>
			<option value="2">February</option>
			<option value="3">March</option>
			<option value="4">April</option>
			<option value="5">May</option>
			<option value="6">June</option>
			<option value="7">July</option>
			<option value="8">August</option>
			<option value="9">September</option>
			<option value="10">October</option>
			<option value="11">November</option>
			<option value="12">December</option>
		</select>
	</div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label" for="sp">Service Provider</label>
	<div class="col-md-4">
		<select id="sp" name="sp" class="form-control" size="1">
			<option value="0" selected disabled>Select Service Provider</option>
			
			<?php
				$query="SELECT
						mobi_service_provider.SP_ID,
						mobi_service_provider.SHORT_NAME
						FROM
						mobi_service_provider";
				
				$main_sub_sql = mysqli_query($con_main, $query);
									
				while ($main_sub = mysqli_fetch_array($main_sub_sql)){
					echo ("<option value=\"".$main_sub['SP_ID']."\">".$main_sub['SHORT_NAME']."</option>");
				}
			?>
		</select>
	</div>

	<label class="col-md-2 control-label" for="mobileNo">Mobile No</label>
	<div class="col-md-4">
		<input type="text" id="mobileNo" name="mobileNo" class="form-control" placeholder="Enter Mobile No">
	</div>
</div>

<div class="form-group form-actions">
	<input type="hidden" name="report_url" id="report_url" value="reports/new_unassigned_accounts.php" />

	<div class="col-md-12">
		<button type="submit" class="btn btn-success primary-btn pull-right"><i class="fa fa-angle-right"></i> Submit</button>
		<button type="reset" class="btn btn-warning"><i class="fa fa-repeat"></i> Reset</button>
	</div>
</div>

<?php
mysqli_close($con_main);
?>