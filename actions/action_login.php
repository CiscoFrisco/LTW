<?php
	include_once('../includes/session.php');
	include_once('../database/db_user.php');

	if ($_SESSION['csrf'] !== $_POST['csrf'])
		die(header('Location: https://bit.ly/2Lf0oIo'));

	$username = $_POST['username'];
	$password = $_POST['password'];

	echo(time());
	echo(' ');
	echo($_SESSION['timeout']);

	if(time() < $_SESSION['timeout'])
		die(header('Location: ../pages/login.php?error=wait'));

	if (checkUserPassword($user_id, $username, $password)) {
		$_SESSION['user_id'] = $user_id;

		if(isset($_GET['redirect']))
			header('Location: ../pages/'.urldecode($_GET['redirect']));
		
		else header('Location: ../index.php');
	} else {
		$_SESSION['tries']++;
		
		if($_SESSION['tries'] % 3 == 0)
			$_SESSION['timeout'] = time() + (pow(2,floor($_SESSION['tries']/3)-1) * 60);
		
		header('Location: ../pages/login.php?error=bad_login');
	}
?>