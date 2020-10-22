<?php 
include '../dbConnect.php';
print_r($_POST);
if(isset($_POST['submit']) ) {

$Scod    =$_POST['Scode'];
$I_nam =$_POST['I_name'];
$It_typ   =$_POST['It_type'];
$I_cos =$_POST['I_cost'];
$I_de   =$_POST['I_des'];
$Icod   =$_POST['Icode'];

$query= "INSERT INTO `product` (`Scode`, `I_name`, `It_type`, `I_cost`, `I_des`, `Icode`) VALUES ('$Scod', '$I_nam','$It_typ' ,'$I_cos', '$I_de','$Icod')";


if(mysqli_query($con,$query)){
	print("arg");
}else{
	print("error");
}


}
else{
	header('Location:itemAdd.php?ms:=try again');

}

?>
