<?php
	include_once('../includes/session.php');
	include_once('../database/db_user.php');

	$user_id = $_SESSION['user_id'];
	$username = $_POST['username'];
	$realname = $_POST['realname'];
	$bio = $_POST['bio'];

	try {
		editUserInfo($user_id, $username, $realname, $bio);
        header('Location: ../pages/profile.php');
    } catch (PDOException $e) {
        header('Location: ../pages/profile.php');
    }
?>