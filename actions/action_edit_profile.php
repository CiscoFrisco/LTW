<?php
	include_once('../includes/session.php');
	include_once('../database/db_user.php');

	$user_id = $_SESSION['user_id'];
	$curr_username = getUserName($user_id); //if the new username is already taken redirect using this username
	$new_username = $_POST['username'];
	$realname = $_POST['realname'];
	$email = $_POST['email'];
	$birthday = $_POST['birthday'];
	$bio = $_POST['bio'];
	
	$img_file = $_FILES['img']['tmp_name'];
	$ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);

	try {
		editUserInfo($user_id, $new_username, $realname, $email, $birthday, $bio);
		updateProfilePic($img_file, $curr_username, $new_username, $ext);
        header('Location: ../pages/profile.php?username='.urlencode($new_username));
    } catch (PDOException $e) {
        header('Location: ../pages/profile.php?username='.urlencode($curr_username));
	}
	
	function updateProfilePic($img_file, $curr_username, $new_username, $ext){
		if($img_file != "")
		{
			$profile_pics =  glob("../pictures/".$curr_username.".*");

			foreach($profile_pics as $pic)
				unlink($pic);

			move_uploaded_file($img_file, "../pictures/".$new_username.".".$ext);
		}
	}
?>

