<?php
	include_once('../includes/session.php');
	include_once('../database/db_user.php');

	$username = $_POST['username'];
	$password = $_POST['password'];

	if (checkUserPassword($user_id, $username, $password)) {
		$_SESSION['user_id'] = $user_id;
		header('Location: ../pages/profile.php');
	} else {
		header('Location: ../pages/login.php');
	}
?>