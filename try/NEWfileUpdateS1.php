<!DOCTYPE html>
<html>
<head>
	<title>Web site Name</title>
</head>
<body>
<h2>Up date System</h2>
<a href=""></a>
<table>
	<tr>
	<td>Code</td>
	<td>Name</td>
	<td>Address</td>
	<td>City</td>
	<td>Account</td>
	<td>Phone</td>
    <td>E-mail</td> 
    <td>Type</td>
	<td>View</td>
	<td>Edit</td>
	<td>Delect</td>
	<?php
	include '../dbConnect.php';
	$stmt=$dbConnect->prepare("SELECT Scode,Sup_name,Sup_address,Sup_city,Sup_account,Sup_phone,Sup_email,It_type From supplier");
	$stmt->execute();
	while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
			extract($row);
			?>
	<tr>
	<td><?php echo $Scode;?></td>
	<td><?php echo $Sup_name;?></td>
	<td><?php echo $Sup_address;?></td>
	<td><?php echo $Sup_account;?></td>
	<td><?php echo $Sup_phone;?></td>
	<td><?php echo $Sup_email;?></td>
	<td><?php echo $It_type;?></td>
	<td><a href="Sview.php?Scod=<?php echo $Scode;?>">View</a></td>
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