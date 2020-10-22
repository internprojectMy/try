<?php

include('connection.php');
include('function.php');

$query = '';

$output = array();
$query .= "
	SELECT * FROM SupplyItem 
INNER JOIN Supplybrand ON Supplybrand.BID = SupplyItem.BID
INNER JOIN SupplyCate ON SupplyCate.CID = SupplyItem.CID 
";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE Supplybrand.SBName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR SupplyCate.SCName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR SupplyItem.SIName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR SupplyItem.SIQ LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR SupplyItem.IID LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST['SupplyOrder']))
{
	$query .= 'ORDER BY '.$_POST['SupplyOrder']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY IID ASe ';
}

if($_POST['length'] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$state = $con->prepare($query);
$state->execute();
$result = $state->fetchAll();
$data = array();
$filtered_rows = $state->rowCount();
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
	$sub_array = array();
	$sub_array[] = $row['IID'];
	$sub_array[] = $row['SCName'];
	$sub_array[] = $row['SBName'];
	$sub_array[] = $row['SIName'];
	$sub_array[] = item_all_total($con, $row["IID"]) . ' ' . $row["SIU"];
	$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="view" id="'.$row["IID"].'" class="btn btn-info btn-xs view">View</button>';
	$sub_array[] = '<button type="button" name="update" id="'.$row["IID"].'" class="btn btn-warning btn-xs update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["IID"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["SIStatus"].'">Delete</button>';
	$data[] = $sub_array;
}

function total_data($con)
{
	$state = $con->prepare('SELECT * FROM SupplyItem');
	$state->execute();
	return $state->rowCount();
}

$output = array(
	"draw"    			=> 	intval($_POST["draw"]),
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	total_data($con),
	"data"    			=> 	$data
);

echo json_encode($output);

?>