<?php
	include_once('../includes/session.php');

	if (!isset($_SESSION['user_id']))
    	die(header('Location: login.php'));
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
	</header>
	<section id="new_story">
		<header>
			<h2>Add a New Story</h2>
		</header>
		<form method="post" action="../actions/action_add_story.php">
			<input type="text" name="title" placeholder="Title" required>
			<textarea name="story" placeholder="Story" required></textarea>
			<input type="submit" value="AddStory">
		</form>
	</section>
</body>

</html>