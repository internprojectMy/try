<!DOCTYPE html>
<html>
<head>
	<title> HOME </title>
</head>
<body>
<h2> View Suppliers list</h2>
<table>
	<tr>
		<td>Name</td>
		<td>Address</td>
		<td>City</td>
		<td>Account</td>
		<td>Phone</td>
		<td>E-mail</td>
		<td>Date</td>
		<td>Type</td>
		<td>Code</td>	
	</tr>
	<?php
	include '../datacon.php';
	$stmt=$con->prepare("SELECT * FROM tsupp");
	$stmt->execute();
	while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){
		print extract($row);
		?>
		<tr>
			<td><?php echo $name; ?></td>
			<td><?php echo $address; ?></td>
			<td><?php echo $city; ?></td>
			<td><?php echo $account; ?></td>
			<td><?php echo $phone; ?></td>
			<td><?php echo $email; ?></td>
			<td><?php echo $data; ?></td>
			<td><?php echo $type; ?></td>
			<td><?php echo $code; ?></td>
		</tr>
		<?php
	} 
	?>
</table>
</body>
</html>