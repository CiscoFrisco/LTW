<?php
	include_once('../includes/session.php');
	include_once('../database/db_story.php');
	include_once('../database/db_user.php');

	if (!isset($_GET['story_id']))
    	die(header('Location: stories.php'));

	$story_id = $_GET['story_id'];

	try {
		$story = getStory($story_id);
    } catch (PDOException $e) {
        die(header('Location: stories.php'));
	}

	$username = getUserName($story['user_id']);
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
	<section id="story">
		<header>
			<h2><?=$story['opinion_title']?></h2>
		</header>
		<h2><?=$story['opinion_text']?></h2>
		<h5>Posted by: <?=$username?></h5>
		<!--ADD COMMENTS IN JS-->
		<footer>
			<?php if((isset($_SESSION['user_id']))) { ?>
			<p>Have something to say about this story? <a href="comment.php">Comment!</a></p>
			<?php } else { ?>
			<p>Have something to say about this story? <a href="login.php">Login!</a> or <a href="signup.php">Sign Up!</a></p>
			<?php } ?>
		</footer>
	</section>
</body>

</html>