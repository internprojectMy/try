<?php 
include_once'../include/dbh.php';

$icode=$_POST['icode'];
$iname=$_POST['iname'];
$ittype=$_POST['ittype'];
$scode=$_POST['scode'];
$ides=$_POST['ides'];
$icost=$_POST['icost'];

$sql="INSERT INTO product(ICode,Iname,ITtype,SCode,Ides,ICost) VALUES('$icode','$iname','$ittype','$scode','$ides','$icost'); ";
mysqli_query($con,$sql);
header("Location:../items/finalitemAdd.php?signup=success");
//header("Location:../items/EditItem.php?signup=success");

?>