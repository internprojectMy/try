<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
include '../dbConnect.php';
if (isset($_GET['Scod'])) {
	$Scod=$_GET['Scod'];
	$stmt=$dbcon->prepare("SELECT Scode,Sup_name,Sup_address,Sup_city,Sup_account,Sup_phone,Sup_email,It_type FROM supplier WHERE Scode=$Scod");
	$stmt->execute();
	$row=$stmt->fetch(POD::FETCH_ASSOC);
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
	</tr>
	<?php
 }
?>
</body>
</html