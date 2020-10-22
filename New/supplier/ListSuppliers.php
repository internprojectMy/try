<?php 
include '../dbConnect.php';
print_r($_POST);
if(isset($_POST['submit']) ) {

$Sup_nam    =$_POST['Sup_name'];
$Sup_addres =$_POST['Sup_address'];
$Sup_cit    =$_POST['Sup_city'];
$Sup_accoun =$_POST['Sup_account'];
$Sup_phon   =$_POST['Sup_phone'];
$Sup_emai   =$_POST['Sup_email'];
$Sup_dat    =$_POST['Sup_date'];
$It_typ     =$_POST['It_type'];
$Scod       =$_POST['Scode'];

$query= "INSERT INTO `supplier` (`Sup_name`, `Sup_address`, `Sup_city`, `Sup_account`, `Sup_phone`, `Sup_email`, `Sup_date`, `It_type`, `Scode`) VALUES ('$Sup_nam', '$Sup_addres', '$Sup_cit', '$Sup_accoun', $Sup_phon, '$Sup_emai', '$Sup_dat', '$It_typ', '$Scod')";


if(mysqli_query($con,$query)){
	print("arg");
}else{
	print("error");
}


}
else{
	header('Location:supplyAdd.php?ms:=try again');

}

?>
