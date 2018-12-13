<?php
	include_once('../includes/session.php');
	include_once('../database/db_user.php');

	if ($_SESSION['csrf'] !== $_POST['csrf'])
		die(header('Location: https://bit.ly/2Lf0oIo'));

	$username = $_POST['username'];
	$password = $_POST['password'];

	if (checkUserPassword($user_id, $username, $password)) {
		$_SESSION['user_id'] = $user_id;

		if(isset($_GET['redirect']))
			header('Location: ../pages/'.urldecode($_GET['redirect']));
		
		else header('Location: ../index.php');
	} else {
		header('Location: ../pages/login.php?error=true');
	}
?>