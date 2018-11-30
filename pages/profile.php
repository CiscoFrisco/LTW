<?php
	include_once('../includes/session.php');
	include_once('../includes/date.php');
	include_once('../database/db_user.php');
	include_once('../templates/tpl_common.php');

	if (!isset($_GET['username']))
		die(header('Location: ../index.php'));

	$username = urldecode($_GET['username']);
	getUserInfo($user_id, $username, $realname, $email, $birthday, $join_date, $bio);
	$formatted_birthday = formatDate($birthday);
	$formatted_join_date = formatDate($join_date);

	draw_header();
?>

	<h2><?=$username?> Profile</h2>
	<h3>Username: <?=$username?></h3>
	<h3>Name: <?=$realname?></h3>
	<h3>Bio: <?=$bio?></h3>
	<h3>Email: <?=$email?></h3>
	<h3>Birthday: <?=$formatted_birthday?></h3>
	<h3>Join Date: <?=$formatted_join_date?></h3>

	<?php
	if(isset($_SESSION['user_id']) && $_SESSION['user_id'] == $user_id){?>

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
			<h4><a href="../actions/action_logout.php">Logout</a></h4>
		</header>
	</section>

	<?php } 
	draw_footer();?>