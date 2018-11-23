<?php
	include_once('session.php');
    include_once('db_user.php');

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
		insertUser($username, $email, $password);
		$_SESSION['username'] = $username;
        header('Location: profile.php');
    } catch (PDOException $e) {
        header('Location: signup.php');
    }
?>