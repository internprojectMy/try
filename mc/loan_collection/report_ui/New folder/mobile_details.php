<?php
require_once ('../../config.php');
?>
		
		<div class="form-group">
		
			<label class="col-md-2 control-label" for="epfNo">EPF No</label>
						<div class="col-md-4">
							<input type="text" id="epfNo" name="epfNo" class="form-control" placeholder="Enter EPF No">
						</div>
			
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

		</div>

		<div class="form-group">
		
			<label class="col-md-2 control-label" for="conType">Connection Type</label>
						<div class="col-md-4">
							<select id="conType" name="conType" class="form-control" size="1">
								<option value="0" selected>Any</option>
								<?php
									$query="SELECT
									MCT.CON_TYPE_ID,
									MCT.CON_TYPE
									FROM
									mobi_con_type AS MCT
									WHERE
									MCT.`STATUS` = 1
									ORDER BY
									MCT.CON_TYPE ASC";
									
									$sql = mysqli_query($con_main, $query);
														
									while ($res = mysqli_fetch_array($sql)){
										$selected = ($res['CON_TYPE_ID'] == $ct) ? " selected " : "";
										echo ("<option value=\"".$res['CON_TYPE_ID']."\"".$selected.">".$res['CON_TYPE']."</option>");
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
			<input type="hidden" name="report_url" id="report_url" value="reports/mobile_details.php" />

			<div class="col-md-12">
				<button type="submit" class="btn btn-success primary-btn pull-right"><i class="fa fa-angle-right"></i> Submit</button>
				<button type="reset" class="btn btn-warning"><i class="fa fa-repeat"></i> Reset</button>
			</div>
		</div>
	<?php
	mysqli_close($con_main);
	?>