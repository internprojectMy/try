<?php 
include_once'../include/dbh.php';

$rid=$_POST['rid'];
$icode=$_POST['icode'];
$ittype=$_POST['ittype'];
$sname=$_POST['sname'];
$semail=$_POST['semail'];
$scode=$_POST['scode'];
$iquantity=$_POST['iquantity'];



$sql="INSERT INTO rdetails(RId,ICode,ITtype,Sname,Semail,SCode,IQuantity) VALUES('$rid','$icode','$ittype','$sname','$semail','$scode','$iquantity'); ";
mysqli_query($con,$sql);
header("Location:../Supply/ReOrder.php?signup=success");

?>