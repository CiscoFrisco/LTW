<?php
	include_once('session.php');
	include_once('db_user.php');

	$username = $_POST['username'];
	$password = $_POST['password'];

	if (checkUserPassword($username, $password)) {
		$_SESSION['username'] = $username;
		header('Location: profile.php');
	} else {
		header('Location: index.php');
	}
?>