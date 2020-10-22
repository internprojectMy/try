<?php  re?>
<!DOCTYPE html>
<html>
<head>
	<title>Home </title>
</head>
<body>
<h2> View Suppliers List</h2>
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
	include '../dbConnect.php';
	$stmt=$con->prepare("SELECT * FROM supplier");
	$stmt->execute();
	while ($row=$stmt->mysqli_stmt_fetch(PDO::FETCH_ASSOC)){
		extract($row);
		?>
		<tr>
			<td><?php echo $Sup_name; ?></td>
			<td><?php echo $Sup_address; ?></td>
			<td><?php echo $Sup_city; ?></td>
			<td><?php echo $Sup_account; ?></td>
			<td><?php echo $Sup_phone; ?></td>
			<td><?php echo $Sup_email; ?></td>
			<td><?php echo $Sup_data; ?></td>
			<td><?php echo $It_type; ?></td>
			<td><?php echo $Scode; ?></td>
		</tr>
		<?php
	} 
	?>
</table>
</body>
</html>