<?php
	include_once('../includes/session.php');

	session_destroy();

	if(isset($_GET['redirect']))
		header('Location: ../pages/'.urldecode($_GET['redirect']));
	
	else header('Location: ../index.php');
?>