<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php
	include 'dbconnection.php';
	if (isset($_GET['id'])) 
   {
	$id=$_GET['id'];
	$stmt=$dbcon->prepare("SELECT * From supplier WHERE pid=$id ");
	$stmt->execute();
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
		extract($row);
		?>
	<tr>
	<td><?php echo $pid;?></td>
	<td><?php echo $pname;?></td>
	<td><?php echo $pdescs;?></td>
	</tr>
	<?php
   }
	}
	?>
</body>
</html>