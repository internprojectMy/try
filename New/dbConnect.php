<?php 
$dbhost='localhost';
$dbname='mary';
$dbuser='root';
$dbpass='';

	//$dbcon=new POO("mysql:host={ $dbhost};dbname={$dbname}",$dbuser,$dbpass);
$con=mysqli_connect($dbhost,$dbuser,$dbpass ,$dbname);
if (mysqli_connect_errno()) {
	die('Database connection fails'.mysqli_connect_error());

	# code...
}else{
	print("connection success");
}




?>

