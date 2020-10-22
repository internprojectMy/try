<?php



include('connection.php');

if(isset($_POST['btn_action']))
{
	if($_POST['btn_action'] == 'Add')
	{
		$query = "
		INSERT INTO SupplyCate (SCName) 
		VALUES (:SCName)
		";
		$state = $con->prepare($query);
		$state->execute(
			array(
				':SCName'	=>	$_POST["SCName"]
			)
		);
		$result = $state->fetchAll();
		if(isset($result))
		{
			echo 'New Category Details  Added to System !!!';
		}
	}
	
	if($_POST['btn_action'] == 'fetch_single')
	{
		$query = "SELECT * FROM SupplyCate WHERE CID = :CID";
		$state = $con->prepare($query);
		$state->execute(
			array(
				':CID'	=>	$_POST["CID"]
			)
		);
		$result = $state->fetchAll();
		foreach($result as $row)
		{
			$output['SCName'] = $row['SCName'];
		}
		echo json_encode($output);
	}

	if($_POST['btn_action'] == 'Edit')
	{
		$query = "
		UPDATE SupplyCate set SCName = :SCName  
		WHERE CID = :CID
		";
		$state = $con->prepare($query);
		$state->execute(
			array(
				':SCName'	=>	$_POST["SCName"],
				':CID'		=>	$_POST["CID"]
			)
		);
		$result = $state->fetchAll();
		if(isset($result))
		{
			echo 'Category Details Successfully updated !!!';
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
		UPDATE SupplyCate 
		SET SCStatus = :SCStatus 
		WHERE CID = :CID
		";
		$state = $con->prepare($query);
		$state->execute(
			array(
				':SCStatus'	=>	$status,
				':CID'		=>	$_POST["CID"]
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