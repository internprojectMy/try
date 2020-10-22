<?php
session_start();

if(session_destroy()) // Destroying All Sessions
{
	// Redirecting To Login Page
	header("Location: index.php");
}
?>