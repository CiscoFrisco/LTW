<?php
	include_once('session.php');
	include_once('db_user.php');

	$username = $_SESSION['username'];
	$realname = $_POST['realname'];
	$bio = $_POST['bio'];

	try {
		editUserInfo($username, $realname, $bio);
        header('Location: profile.php');
    } catch (PDOException $e) {
        header('Location: profile.php');
    }
?>