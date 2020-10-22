<?php 

$comment=$_POST['cc'];
$mof=$_POST['moc'];
$mdo=$_POST['mdo'];
$ip=$_POST['ifp'];
$doc=$_POST['doc'];
$commu_by=$_POST['cb'];



$host="localhost";
$username="root";
$pass="";
$dbname="gurind";


$con=new mysqli($host,$username,$pass,$dbname);//Create the connection

if(mysqli_connect_errno())
{



die("Database connecton is failed You have to check the connection").mysqli_connect_errno();




}



else
{


$sql="INSERT INTO customer_return_auth(comment,mode_of_communication,marketing_dep_obs,ins_production,communicated_by,goods_exp_date) 
	  VALUES('$comment','$mof','$mdo','$ip','$doc','$comm_by')";
		$query=mysqli_query($con,$sql);
	
echo"Success";


mysqli_close($con);

}










 ?>