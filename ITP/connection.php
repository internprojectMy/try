<?php
$connection= mysqli_connect('localhost','root','','itproject');

if (mysqli_connect_errno()) {
	die('Database connection fails'.mysqli_connect_error());
	# code...
}else{
	"connection success";
}


 ?>

