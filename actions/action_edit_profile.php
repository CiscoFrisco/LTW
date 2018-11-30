<?php
	include_once('../includes/session.php');
	include_once('../database/db_user.php');

	$user_id = $_SESSION['user_id'];
	$username = $_POST['username'];
	$realname = $_POST['realname'];
	$email = $_POST['email'];
	$birthday = $_POST['birthday'];
	$bio = $_POST['bio'];

	try {
		editUserInfo($user_id, $username, $realname, $email, $birthday, $bio);
        header('Location: ../pages/profile.php');
    } catch (PDOException $e) {
        header('Location: ../pages/profile.php');
    }
?>