<?php
	include_once('../includes/session.php');
	include_once('../database/db_user.php');

    $username = $_POST['username'];
    $email = $_POST['email'];
	$password = $_POST['password'];
	
	$uppercase = preg_match('@[A-Z]@', $password);
	$lowercase = preg_match('@[a-z]@', $password);
	$number = preg_match('@[0-9]@', $password);

	if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
		die(header('Location: ../pages/signup.php?error=badPassword'));
	}

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