<?php 
include_once'../include/dbh.php';

$Scod=$_POST['Scod'];
$Snam=$_POST['Snam'];
$Saddres=$_POST['Saddres'];
$Scit=$_POST['Scit'];
$Semai=$_POST['Semai'];
$Saccoun=$_POST['Saccoun'];
$Sban=$_POST['Sban'];
$Sphon=$_POST['Sphon'];
$Sdate=$_POST['Sdate'];
$Ittype=$_POST['Ittype'];



$sql="INSERT INTO supply(SCode,Sname,SAddress,SCity,Semail,Saccount,Sbank,Sphone,Sdate,ITtype) VALUES('$Scod','$Snam','$Saddres','$Scit','$Semai','$Saccoun','$Sban','$Sphon','$Sdate','$Ittype'); ";
mysqli_query($con,$sql);
header("Location:../Supply/AddNewSupplier.php?signup=success");

?>