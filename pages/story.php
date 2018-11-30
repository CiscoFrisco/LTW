<?php
	include_once('../includes/session.php');
	include_once('../includes/date.php');
	include_once('../database/db_story.php');
	include_once('../database/db_user.php');
	include_once('../templates/tpl_common.php');

	if (!isset($_GET['story_id']))
    	die(header('Location: stories.php'));

	$story_id = $_GET['story_id'];

	try {
		$story = getStory($story_id);
    } catch (PDOException $e) {
        die(header('Location: stories.php'));
	}

	$username = getUserName($story['user_id']);
	$now = time();

	draw_header();
?>

	<section id="story">
		<header>
			<h2><?=$story['opinion_title']?></h2>
		</header>
		<h2><?=$story['opinion_text']?></h2>
		<h3>Posted by <a href="<?='profile.php?username='.urlencode($username)?>"><?=$username?></a> <?=deltaTime($now, $story['posted'])?></h3>
		<!--ADD COMMENTS IN JS-->
		<footer>
			<?php if((isset($_SESSION['user_id']))) { ?>
			<p>Have something to say about this story? <a href="comment.php">Comment!</a></p>
			<?php } else { ?>
			<p>Have something to say about this story? <a href="login.php">Login!</a> or <a href="signup.php">Sign Up!</a></p>
			<?php } ?>
		</footer>
	</section>

<?php draw_footer();?>