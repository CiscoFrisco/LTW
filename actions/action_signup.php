<?php
	include_once('../includes/session.php');
	include_once('../database/db_user.php');

	if ($_SESSION['csrf'] !== $_POST['csrf'])
		die(header('Location: https://bit.ly/2Lf0oIo'));

    $username = $_POST['username'];
    $email = $_POST['email'];
	$password = $_POST['password'];

	if(!preg_match ("/^[a-zA-Z0-9]+$/", $username))
		die(header('Location: ../pages/signup.php?error=username'));

    try {
		insertUser($user_id, $username, $email, $password);
		$_SESSION['user_id'] = $user_id;
		
		if(isset($_GET['redirect']))
			header('Location: ../pages/'.urldecode($_GET['redirect']));
		
		else header('Location: ../index.php');
    } catch (PDOException $e) {
        header('Location: ../pages/signup.php?error=taken');
    }
?>