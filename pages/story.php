<?php
	include_once('../includes/date.php');
	include_once('../database/db_story.php');
	include_once('../database/db_user.php');
	include_once('../database/db_comment.php');
	include_once('../templates/tpl_common.php');
	include_once('../templates/tpl_comments.php');

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

	draw_header(true);
?>

	<section id="story">
		<header>
			<h2><?=$story['opinion_title']?></h2>
		</header>
		<h2><?=$story['opinion_text']?></h2>
		<h3>Posted by <a href="<?='profile.php?username='.urlencode($username)?>"><?=$username?></a> <?=deltaTime($now, $story['posted'])?></h3>
	</section>

<?php
	$comments = array_reverse(getAllComments($story_id));

	for($i = 0; $i < count($comments); $i++){
		$comments[$i]['username'] = getUserName($comments[$i]['user_id']);
	}

	$now = time();

	draw_comments($comments, true);

	draw_footer();
?>