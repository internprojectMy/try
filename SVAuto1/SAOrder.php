<?php


include('connection.php');

include('function.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO SupplySorder ( SOT, SOdate, SOName, SOA, SOpay,SOStatus) 
		VALUES (:SOT, :SOdate, :SOName, :SOA, :SOpay, :SOStatus)
		";
		$state = $con->prepare($query);
		$state->execute(
			array(
				':SOT'		=>	0,
				':SOdate'			=>	$_POST['SOdate'],
				':SOName'			=>	$_POST['SOName'],
				':SOA'		=>	$_POST['SOA'],
				':SOpay'				=>	$_POST['SOpay'],
				':SOStatus'		=>	'active'
			)
		);
		$result = $state->fetchAll();
		$state = $con->query("SELECT LAST_INSERT_ID()");
		$OID = $state->fetchColumn();

		if(isset($OID))
		{
			$total_amount = 0;
			for($count = 0; $count<count($_POST["IID"]); $count++)
			{
				$SD = indexItem_details($_POST["IID"][$count], $con);
				$sub_query = "
				INSERT INTO SupplyOI (OIID, IID, SQ, SP, dis) VALUES (:OIID, :IID, :SQ, :SP, :tax)
				";
				$state = $con->prepare($sub_query);
				$state->execute(
					array(
						':OIID'	=>	$OIID,
						':IID'			=>	$_POST["IID"][$count],
						':SQ'				=>	$_POST["SQ"]
						[$count],
						':SP'				=>	$SD['SP'],
						':dis'					=>	$SD['dis']
					)
				);
				$BP = $SD['SP'] * $_POST["SQ"][$count];
				$dis = ($BP/100)*$SD['dis'];
				$TM = $TM + ($BP + $dis);
			}
			$update_query = "
			UPDATE SupplySorder
			SET SOT = '".$TM."' 
			WHERE OID = '".$OID."'
			";
			$state = $con->prepare($update_query);
			$state->execute();
			$result = $state->fetchAll();
			if(isset($result))
			{
				echo 'Order Created...';
				echo '<br />';
				echo $TM;
				echo '<br />';
				echo $OID;
			}
		}
	}

	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * FROM SupplySorder WHERE OIID = :OIID
		";
		$state = $con->prepare($query);
		$state->execute(
			array(
				':OIID'	=>	$_POST["OIID"]
			)
		);
		$result = $state->fetchAll();
		$output = array();
		foreach($result as $row)
		{
			$output['SOName'] = $row['SOName'];
			$output['SOdate'] = $row['SOdate'];
			$output['SOA'] = $row['SOA'];
			$output['SOpay'] = $row['SOpay'];
		}
		$sub_query = "
		SELECT * FROM SupplyOI 
		WHERE OIID = '".$_POST["OIID"]."'
		";
		$state = $con->prepare($sub_query);
		$state->execute();
		$sub_result = $state->fetchAll();
		$SD = '';
		$count = '';
		foreach($sub_result as $sub_row)
		{
			$SD .= '
			<script>
			$(document).ready(function(){
				$("#IID'.$count.'").selectpicker("val", '.$sub_row["IID"].');
				$(".selectpicker").selectpicker();
			});
			</script>
			<span id="row'.$count.'">
				<div class="row">
					<div class="col-md-8">
						<select name="IID[]" id="IID'.$count.'" class="form-control selectpicker" data-live-search="true" required>
							'.add_item_record($con).'
						</select>
						<input type="hidden" name="hIID[]" id="hIID'.$count.'" value="'.$sub_row["IID"].'" />
					</div>
					<div class="col-md-3">
						<input type="text" name="SQ[]" class="form-control" value="'.$sub_row["SQ"].'" required />
					</div>
					<div class="col-md-1">
			';

			if($count == '')
			{
				$SD .= '<button type="button" name="add_more" id="add_more" class="btn btn-success btn-xs">+</button>';
			}
			else
			{
				$SD .= '<button type="button" name="remove" id="'.$count.'" class="btn btn-danger btn-xs remove">-</button>';
			}
			$SD .= '
						</div>
					</div>
				</div><br />
			</span>
			';
			$count = $count + 1;
		}
		$output['SD'] = $SD;
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		$delete_query = "
		DELETE FROM SupplyOI 
		WHERE OIID = '".$_POST["OIID"]."'
		";
		$state = $con->prepare($delete_query);
		$state->execute();
		$delete_result = $state->fetchAll();
		if(isset($delete_result))
		{
			$TM = 0;
			for($count = 0; $count < count($_POST["IID"]); $count++)
			{
				$SD = indexItem_details($_POST["IID"][$count], $con);
				$sub_query = "
				INSERT INTO SupplyOI (OIID, IID,SQ, SP, dis) VALUES (:OIID, :IID, :SQ, :SP, :tax)
				";
				$state = $con->prepare($sub_query);
				$state->execute(
					array(
						':OIID'	=>	$_POST["OIID"],
						':IID'			=>	$_POST["IID"][$count],
						':SQ'				=>	$_POST["SQ"][$count],
						':SP'				=>	$SD['SP'],
						':dis'					=>	$SD['dis']
					)
				);
				$BP = $SD['SP'] * $_POST["SQ"][$count];
				$dis = ($BP/100)*$SQ['dis'];
				$TM = $TM + ($BP + $dis);
			}
			$update_query = "
			UPDATE SupplySorder
			SET SOName = :SOName, 
			SOdate = :SOdate, 
			SOA = :SOA, 
			SOT = :SOT, 
			SOpay = :SOpay
			WHERE OIID = :OIID
			";
			$state = $con->prepare($update_query);
			$state->execute(
				array(
					':SOName'			=>	$_POST["SOName"],
					':SOdate'			=>	$_POST["SOdate"],
					':SOA'		=>	$_POST["SOA"],
					':SOT'		=>	$TM,
					':SOpay'	=>	$_POST["SOpay"],
					':OIID'			=>	$_POST["OIID"]
				)
			);
			$result = $state->fetchAll();
			if(isset($result))
			{
				echo 'Order susseccfully Upgated !!!!';
			}
		}
	}

	if($_POST['btn_action'] == 'delete')
	{
		$status = 'active';
		if($_POST['status'] == 'active')
		{
			$status = 'inactive';
		}
		$query = "
		UPDATE SupplySorder 
		SET SOStatus = :SOStatus 
		WHERE OIID = :OIID
		";
		$state = $con->prepare($query);
		$state->execute(
			array(
				':SOStatus'	=>	$status,
				':OIID'		=>	$_POST["OIID"]
			)
		);
		$result = $state->fetchAll();
		if(isset($result))
		{
			echo 'inactivated !!!! ' . $status;
		}
	}
}

?>