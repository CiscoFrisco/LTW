<?php
	include_once('../includes/session.php');

	if(isset($_SESSION['user_id']))
		session_destroy();

	if(isset($_GET['redirect']))
	{
		$_GET['redirect'] = urldecode($_GET['redirect']);

		$redirect_options = explode("?",$_GET['redirect']);

		if(preg_match('@../@', $_GET['redirect']) 
		|| !preg_match('@.php@', $_GET['redirect'])
		|| !is_readable('../pages/' . $redirect_options[0]))
			header('Location: ../index.php');

		header('Location: ../pages/'.urldecode($_GET['redirect']));
	}
	
	else header('Location: ../index.php');
?>