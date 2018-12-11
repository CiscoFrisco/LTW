<?php
	include_once('../includes/session.php');
	include_once('../database/db_user.php');

	if ($_SESSION['csrf'] !== $_POST['csrf'])
		die(header('Location: https://bit.ly/2Lf0oIo'));

	$user_id = $_SESSION['user_id'];
	$curr_username = getUserName($user_id); //if the new username is already taken redirect using this username
	$new_username = $_POST['username'];
	$realname = $_POST['realname'];
	$email = $_POST['email'];
	$birthday = $_POST['birthday'];
	$bio = $_POST['bio'];
	
	$img_file = $_FILES['img']['tmp_name'];
	$ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);

	if(!preg_match ("/^[a-zA-Z1-9]+$/", $new_username)){
		die(header('Location: ../pages/signup.php?error=username'));
	}

	if(!preg_match ("/^[a-zA-Z ]+$/", $username)){
		die(header('Location: ../pages/signup.php?error=name'));
	}

	try {
		editUserInfo($user_id, $new_username, $realname, $email, $birthday, $bio);
		updateProfilePic($img_file, $user_id, $ext);
        header('Location: ../pages/profile.php?username='.urlencode($new_username));
    } catch (PDOException $e) {
		header('Location: ../pages/profile.php?username='.urlencode($curr_username).'&error=taken');
	}
	
	function updateProfilePic($img_file, $user_id, $ext){
		if($img_file != "")
		{
			$profile_pics =  glob("../pictures/".$user_id.".*");

			foreach($profile_pics as $pic)
				unlink($pic);

			move_uploaded_file($img_file, "../pictures/".$user_id.".".$ext);
		}
	}
?>

