<?php
	include_once('../includes/date.php');
	include_once('../database/db_user.php');
	include_once('../database/db_story.php');
	include_once('../database/db_comment.php');
	include_once('../database/db_vote.php');
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

	$now = time();

	$username = getUserName($story['user_id']);
	$score = getScore($story_id);

	if(isset($_SESSION['user_id']))
		$vote = getVote($story_id, $_SESSION['user_id']);

	draw_header(true);
?>

	<section id="story" data-id="<?=$story_id?>">
		<div class="upvote" role="button" data-value="<?=$vote?>">&#8593;</div>
		<h5>Score: <?=$score?></h5>
		<div class="downvote" role="button" data-value="<?=$vote?>">&#8595;</div>
		<h2><?=$story['opinion_text']?></h2>
		<h3>Posted by <a href="<?='profile.php?username='.urlencode($username)?>"><?=$username?></a> <?=deltaTime($now, $story['posted'])?></h3>
	</section>

<?php
	$comments = array_reverse(getAllComments($story_id));

	for($i = 0; $i < count($comments); $i++){
		$comments[$i]['username'] = getUserName($comments[$i]['user_id']);
		$comments[$i]['score'] = getScore($comments[$i]['opinion_id']);

		if(isset($_SESSION['user_id']))
			$comments[$i]['vote'] = getVote($comments[$i]['opinion_id'], $_SESSION['user_id']);
	}
	
	draw_comments($comments, true);

	draw_footer();
?>