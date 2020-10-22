<?php



include('connection.php');

$query = '';

$output = array();

$query .= "SELECT * FROM SupplyCate ";

if(isset($_POST["search"]["value"]))
{
	$query .= 'WHERE SCName LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR SCStatus LIKE "%'.$_POST["search"]["value"].'%" ';
}

if(isset($_POST['SupplyOrder']))
{
	$query .= 'ORDER BY '.$_POST['SupplyOrder']['0']['column'].' '.$_POST['SupplyOrder']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY CID DESC ';
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
	if($row['SCStatus'] == 'active')
	{
		$status = '<span class="label label-success">Active</span>';
	}
	else
	{
		$status = '<span class="label label-danger">Inactive</span>';
	}
	$sub_array = array();
	$sub_array[] = $row['CID'];
	$sub_array[] = $row['SCName'];
	$sub_array[] = $status;
	$sub_array[] = '<button type="button" name="update" id="'.$row["CID"].'" class="badge badge-success p-3 update">Update</button>';
	$sub_array[] = '<button type="button" name="delete" id="'.$row["CID"].'" class="btn btn-danger btn-xs delete" data-status="'.$row["SCStatus"].'">Delete</button>';
	$data[] = $sub_array;
}

$output = array(
	"draw"			=>	intval($_POST["draw"]),
	"recordsTotal"  	=>  $filtered_rows,
	"recordsFiltered" 	=> 	total_data($con),
	"data"				=>	$data
);

function total_data($con)
{
	$state = $con->prepare("SELECT * FROM SupplyCate");
	$state->execute();
	return $state->rowCount();
}

echo json_encode($output);

?>