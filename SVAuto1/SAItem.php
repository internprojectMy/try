<?php



include('connection.php');

include('function.php');


if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'load_brand')
	{
		echo add_brand_record($con, $_POST['CID']);
	}

	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO SupplyItem (CID, BID, SIName, SIDes, SIQ, SIU, SIBP, SIDisD, SIStatus, SIdate) 
		VALUES (:CID, :BID, :SIName, :SIDes, :SIQ, :SIU, :SIBP, :SIDis, :SIStatus, :SIdate)
		";
		$statement = $connect->prepare($query);
		$statement->execute(
			array(
				':CID'			=>	$_POST['CID'],
				':BID'				=>	$_POST['BID'],
				':SIName'			=>	$_POST['SIName'],
				':SIDes'	=>	$_POST['SIDes'],
				':SIQ'		=>	$_POST['SIQ'],
				':SIU'			=>	$_POST['SIU'],
				':SIBP'	=>	$_POST['SIBP'],
				':SIDis'			=>	$_POST['SIDis'],
				':SIStatus'		=>	'active',
				':SIdate'			=>	date("Y-m-d")
			)
		);
		$result = $statement->fetchAll();
		if(isset($result))
		{
			echo ' New Item  Add to the system !!!';
		}
	}
	if($_POST['btn_action'] == 'product_details')
	{
		$query = "
		SELECT * FROM SupplyItem 
		INNER JOIN SupplyCate ON SupplyCate.CID = SupplyItem.CID 
		INNER JOIN Supplybrand ON Supplybrand.BID = SupplyItem.BID 
		WHERE SupplyItem.IID = '".$_POST["IID"]."'
		";
		$state = $con->prepare($query);
		$state->execute();
		$result = $state->fetchAll();
		$output = '
		<div class="table-responsive">
			<table class="table table-boredered">
		';
		foreach($result as $row)
		{
			$status = '';
			if($row['SIStatus'] == 'active')
			{
				$status = '<span class="label label-success">Active</span>';
			}
			else
			{
				$status = '<span class="label label-danger">Inactive</span>';
			}
			$output .= '
			<tr>
				<td>Product Name</td>
				<td>'.$row["SIName"].'</td>
			</tr>
			<tr>
				<td>Product Description</td>
				<td>'.$row["SIDis"].'</td>
			</tr>
			<tr>
				<td>Category</td>
				<td>'.$row["SCName"].'</td>
			</tr>
			<tr>
				<td>Brand</td>
				<td>'.$row["SBName"].'</td>
			</tr>
			<tr>
				<td>Available Quantity</td>
				<td>'.$row["SIQ"].' '.$row["SIU"].'</td>
			</tr>
			<tr>
				<td>Base Price</td>
				<td>'.$row["SIBP"].'</td>
			</tr>
			<tr>
				<td>Discount (%)</td>
				<td>'.$row["SIDis"].'</td>
			</tr>
			<tr>
				<td>Status</td>
				<td>'.$status.'</td>
			</tr>
			';
		}
		$output .= '
			</table>
		</div>
		';
		echo $output;
	}
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * FROM SupplyItem WHERE IID = :IID
		";
		$state = $con->prepare($query);
		$state->execute(
			array(
				':IID'	=>	$_POST["IID"]
			)
		);
		$result = $state->fetchAll();
		foreach($result as $row)
		{
			$output['CID'] = $row['CID'];
			$output['BID'] = $row['BID'];
			$output["SB_select_box"] = add_brand_record($con, $row["CID"]);
			$output['SIName'] = $row['SIName'];
			$output['SIDes'] = $row['SIDes'];
			$output['SIQ'] = $row['SIQ'];
			$output['SIU'] = $row['SIU'];

			$output['SIBP'] = $row['SIBP'];
			$output['SIDis'] = $row['SIDis'];
		}
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE SupplyItem 
		set CID = :CID, 
		BID = :BID,
		SIName = :SIName,
		SIDes = :SIDes, 
		SIQ = :SIQ, 
		SIU = :SIU, 
		SIBP = :SIBP, 
		SIDis = :SIDis 
		WHERE IID = :IID
		";
		$state = $con->prepare($query);
		$state->execute(
			array(
				':CID'			=>	$_POST['CID'],
				':BID'				=>	$_POST['BID'],
				':SIName'			=>	$_POST['SIName'],
				':SIDes'	=>	$_POST['SIDes'],
				':SIQ'		=>	$_POST['SIQ'],
				':SIU'			=>	$_POST['SIU'],
				':SIBP'	=>	$_POST['SIBP'],
				':SIDis'			=>	$_POST['SIDis'],
				':IID'			=>	$_POST['IID']
			)
		);
		$result = $state->fetchAll();
		if(isset($result))
		{
			echo 'Item Details Susseccfully  Edited';
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
		UPDATE  SupplyItem 
		SET SIStatus = :SIStatus 
		WHERE IID = :IID
		";
		$state = $con->prepare($query);
		$state->execute(
			array(
				':SIStatus'	=>	$status,
				':IID'		=>	$_POST["IID"]
			)
		);
		$result = $state->fetchAll();
		if(isset($result))
		{
			echo 'Inactivated  ' . $status;
		}
	}
}


?>