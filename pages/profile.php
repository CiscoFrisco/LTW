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
		<h1><a href="../index.php">Tidder</a></h1>
		<h2><?=$username?> Profile</h2>
	</header>
	<h3>Username: <?=$username?></h3>
	<h3>Name: <?=$realname?></h3>
	<h3>Bio: <?=$bio?></h3>
	<section id="edit">
		<header>
			<h2>Edit</h2>
		</header>
		<form method="post" action="../actions/action_edit_profile.php">
			<input type="text" name="username" value="<?=$username?>" required>
			<input type="text" name="realname" value="<?=$realname?>">
			<textarea name="bio"><?=$bio?></textarea>
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