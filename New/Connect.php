<?php
include_once 'dbConnect.php';

$Sup_nam    =$_POST['Sup_nam'];
$Sup_addres =$_POST['Sup_addres'];
$Sup_cit    =$_POST['Sup_cit'];
$Sup_accoun =$_POST['Sup_accoun'];
$Sup_phon   =$_POST['Sup_phon'];
$Sup_emai   =$_POST['Sup_emai'];
$Sup_dat    =$_POST['Sup_dat'];
$It_typ     =$_POST['It_typ'];
$Scod       =$_POST['Scod'];





$sql="INSERT INTO supplier(Sup_name,Sup_address,Sup_city,Sup_account,Sup_phone,Sup_email,It_type,Scode,$It_typ)VALUES ('$Sup_nam','$Sup_addres','$Sup_cit','$Sup_accoun','$Sup_phon','$Sup_emai','$Sup_dat','$Scod');";
mysqli_query($con,$sql);

header("Location:Supply/AddNewsupplier.php?submit=success")
?>