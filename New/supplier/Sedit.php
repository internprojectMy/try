<!DOCTYPE html>
<html>
<head>
	<title>edit View</title>
</head>
<body>
<?
include'../dbConnect.php';
if(isset($_GET['Scod']))
{
	$Scod=$_GET['Scod'];
	$stmt->execute();
	$row=$stmt->fetch(PDO::FETCH_ASSOC);
	extract($row);
	?>
	<form action="update.php" method="post">
	<input type="hidden" name="Scode" value="<?php echo $pid; ?>"><br/>
	<input type="text" name="Sup_name" value="<?php echo $Sup_name; ?>"><br/>
	<input type="text" name="Sup_address" value="<?php echo $Sup_address; ?>">
	<input type="submit" name="submit" value="update now">	
	</form>
	<?php

}
?>
</body>
</html>