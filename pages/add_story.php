<?php
	include_once('../includes/session.php');
	include_once('../templates/tpl_common.php');

	if (!isset($_SESSION['user_id']))
		die(header('Location: login.php'));

	$page = 'add_story.php';	
	draw_header(true);
?>

	<section id="new_story">
		<header>
			<h2>Add a New Story</h2>
		</header>
		<form method="post" action="../actions/action_add_story.php">
			<input type="text" name="title" placeholder="Title" required>
			<textarea name="story" placeholder="Story" required></textarea>
			<input type="submit" value="Add Story">
		</form>
	</section>
	
<?php draw_footer();?>