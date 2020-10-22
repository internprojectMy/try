<?php
	session_start();
	
	if (!empty($_SESSION['ACCESS_CODE']) || $_SESSION['ACCESS_CODE'] != NULL){
		header ('Location: home.php');
	}else{
		header ('Location: login.php');
	}
?>