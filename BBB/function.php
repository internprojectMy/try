<?php
 function fill_ground_list($con_main)
{
	$query = "
	SELECT * FROM slground
	ORDER BY groundname ASC
	";
	$statement = $con_main->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["ground_id"].'">'.$row["groundname"].'</option>';
	}
	return $output;
}

function fill_team_list($con_main)
{
	$query = "
	SELECT * FROM slteam
	ORDER BY teamname ASC
	";
	$statement = $con_main->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$output = '';
	foreach($result as $row)
	{
		$output .= '<option value="'.$row["team_id"].'">'.$row["teamname"].'</option>';
	}
	return $output;
}


?>