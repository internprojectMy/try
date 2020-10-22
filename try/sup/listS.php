<?php 
include '../datacon.php';
print_r($_POST);
if(isset($_POST['submit']) ) {

$nam    =$_POST['name'];
$addres =$_POST['address'];
$cit    =$_POST['city'];
$accoun =$_POST['account'];
$phon   =$_POST['phone'];
$emai   =$_POST['email'];
$dat    =$_POST['date'];
$typ    =$_POST['type'];
$cod    =$_POST['code'];

$stmt = $con->prepare("INSERT INTO `supplier` (`name`, `address`, `city`, `account`, `phone`, `email`, `date`, `type`, `code`) VALUES ('$nam', '$addres', '$cit', '$accoun', $phon, '$emai', '$dat', '$typ', '$cod')");

$stmt->execute();
header('Location:addS.php?msz=Success');
//(mysqli_query($con,$query)){
//	print("arg");
//}else{
//	print("error");
//}


}
else{
	header('Location:addS.php?ms:=try again');

}

?>
