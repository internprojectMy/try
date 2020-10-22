<!DOCTYPE html>
<html>
<head>
	<title>Web site Name</title>
</head>
<body>
<h2>Update System</h2>
<a href="addS.php"></a>
<table>
<tr>
	<td>ID</td>
	<td>Name</td>
	<td>Description</td>
	<td>View</td>
	<td>Edit</td>
	<td>Delect</td>
	<?php
	include 'dbconnection.php';
	$stmt=$dbcon->prepare("SELECT * From supplier");
	$stmt->execute();
	while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		?>
	<tr>
	<td><?php echo $pid;?></td>
	<td><?php echo $pname;?></td>
	<td><?php echo $pdescs;?></td>
	<td><a href="Sview.php?id=<?php echo $pid;?>">View</a></td>
	<td><a href="Sedit.php">Edit</a></td>
	<td><a href="Sdelect.php"></a></td>

	</tr>
	<?php
	}
	?>

</tr>	 
</table>
</body>
</html>
