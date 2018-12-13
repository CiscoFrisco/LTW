<?php
	include_once('../includes/session.php');
	include_once('../database/db_channel.php');
	include_once('../templates/tpl_common.php');
	include_once('../templates/tpl_channels.php');

	if (!isset($_SESSION['user_id']))
		die(header('Location: login.php'));

	if (isset($_GET['channel'])){
		$channel_name = urldecode($_GET['channel']);
		$page = 'add_story.php?channel='.urldecode($_GET['channel']);
	}

	else $page = 'add_story.php';

	$channels = getAllChannels();		
	draw_header(true);
?>
	<div class = "container">
		<section id="new_story" class = "input-block">
			<header>
				<h2>Add a New Story</h2>
			</header>
			<form method="post" action="../actions/action_add_story.php">
				<input type="hidden" name="csrf" value="<?=$_SESSION['csrf']?>">
				<input type="text" name="title" placeholder="Title" required>
				<textarea name="story" placeholder="Story" required></textarea>
				<?php draw_channel_options($channels); ?>
				<input type="submit" value="Add Story">
			</form>
			<?php if(isset($_GET['error'])){ 
					if($_GET['error'] == 'title'){?>
						<h3>Title is too long! (Max is 50 characters)</h3>
			<?php } else if($_GET['error'] == 'text') {?>
						<h3>Story is too long! (Max is 50000 characters)</h3>
			<?php }} ?>
		</section>
	</div>
<?php draw_footer();?>