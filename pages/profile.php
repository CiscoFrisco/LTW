<?php
	include_once('../includes/session.php');
	include_once('../database/db_user.php');

	if (!isset($_SESSION['user_id']))
		die(header('Location: login.php'));

	$user_id = $_SESSION['user_id'];
	getUserInfo($user_id, $username, $realname, $bio);
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
	<section id="edit">
		<header>
			<h2>Edit</h2>
		</header>
		<form method="post" action="../actions/action_edit_profile.php" id="edit_profile">
			<input type="text" name="username" value="<?=$username?>" required>
			<input type="text" name="realname" value="<?=$realname?>" required>
			<input type="submit" value="Edit Profile">
		</form>
		<textarea name="bio" form="edit_profile"><?=$bio?></textarea>
	</section>
	<section id="logout">
		<header>
			<h3><a href="../actions/action_logout.php">Logout</a></h3>
		</header>
	</section>
</body>

</html>