<?php
	include_once('../includes/session.php');
	include_once('../database/db_user.php');

	$user_id = $_SESSION['user_id'];
	$username = $_POST['username'];
	$realname = $_POST['realname'];
	$email = $_POST['email'];
	$birthday = $_POST['birthday'];
	$bio = $_POST['bio'];
	
	$img_file = $_FILES['img']['tmp_name'];
	$ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);

	if(file_exists("../pictures/".$username.".jpeg"))
		unlink("../pictures/".$username.".jpeg");
	else if(file_exists("../pictures/".$username.".jpg"))
		unlink("../pictures/".$username.".jpg");
	else
		unlink("../pictures/".$username.".png");

	try {
		move_uploaded_file($img_file, "../pictures/".$username.".".$ext);
		editUserInfo($user_id, $username, $realname, $email, $birthday, $bio);
        header('Location: ../pages/profile.php?username='.urlencode($username));
    } catch (PDOException $e) {
        header('Location: ../pages/profile.php?username='.urlencode($username));
    }
?>