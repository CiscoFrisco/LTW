<?php
	include_once('../includes/session.php');
	include_once('../database/db_user.php');

	if (!isset($_SESSION['user_id']))
		die(header('Location: login.php'));

	$user_id = $_SESSION['user_id'];
	getUserInfo($user_id, $username, $realname, $email, $birthday, $join_date, $bio);

	$formatted_birthday = formatDate($birthday);
	$formatted_join_date = formatDate($join_date);
?>

<!DOCTYPE html>
<html lang="en-US">

<head>
	<title>Tidder</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
	<header>
		<h1><?=$username?> Profile</h1>
	</header>
	<h2>Username: <?=$username?></h2>
	<h2>Name: <?=$realname?></h2>
	<h2>Bio: <?=$bio?></h2>
	<h2>Email: <?=$email?></h2>
	<h2>Birthday: <?=$formatted_birthday?></h2>
	<h2>Join Date: <?=$formatted_join_date?></h2>
	<section id="edit">
		<header>
			<h2>Edit</h2>
		</header>
		<form method="post" action="../actions/action_edit_profile.php">
			<label for="username">Username:</label>
				<input type="text" name="username" value="<?=$username?>" id="username" required>
			<label for="realname">Name:</label>
				<input type="text" name="realname" value="<?=$realname?>" id="realname" >
			<label for="email">Email:</label>
				<input type="email" name="email" value="<?=$email?>" id="email" required>
			<label for="birthday">Birthday:</label>
				<input type="date" name="birthday" value="<?=$birthday?>" id="birthday">
			<label for="bio">Bio:</label>
				<textarea name="bio" id="bio"><?=$bio?></textarea>
			<input type="submit" value="Edit Profile">
		</form>
	</section>
	<section id="logout">
		<header>
			<h3><a href="../actions/action_logout.php">Logout</a></h3>
		</header>
	</section>
</body>

</html>