<?php


include('connection.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO Supplybrand (CID, SBName) 
		VALUES (:CID, :SBName)
		";
		$state = $con->prepare($query);
		$state->execute(
			array(
				':CID'	=>	$_POST["CID"],
				':SBName'	=>	$_POST["SBName"]
			)
		);
		$result = $state->fetchAll();
		if(isset($result))
		{
			echo ' New Brand Details  Added to System !!!';
		}
	}

	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "
		SELECT * FROM Supplybrand WHERE BID = :BID
		";
		$state = $con->prepare($query);
		$state->execute(
			array(
				':BID'	=>	$_POST["BID"]
			)
		);
		$result = $state->fetchAll();
		foreach($result as $row)
		{
			$output['CID'] = $row['CID'];
			$output['SBName'] = $row['SBName'];
		}
		echo json_encode($output);
	}
	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE Supplybrand set 
		CID = :CID, 
		SBName = :SBName 
		WHERE BID = :BID
		";
		$state = $con->prepare($query);
		$state->execute(
			array(
				':CID'	=>	$_POST["CID"],
				':SBName'	=>	$_POST["SBName"],
				':BID'		=>	$_POST["BID"]
			)
		);
		$result = $state->fetchAll();
		if(isset($result))
		{
			echo 'Brand Name Successfully updated !!!';
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
		UPDATE Supplybrand 
		SET SBStatus = :SBStatus 
		WHERE BID = :BID
		";
		$state = $con->prepare($query);
		$state->execute(
			array(
				':SBStatus'	=>	$status,
				':BID'		=>	$_POST["BID"]
			)
		);
		$result = $state->fetchAll();
		if(isset($result))
		{
			echo 'Inactivated !!! ' . $status;
		}
	}
}

?>