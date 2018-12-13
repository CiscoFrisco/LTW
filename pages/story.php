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

	$story['opinion_text'] = htmlentities($story['opinion_text']);

	$regex = '/\[([^\]]+)\]\((http[s]?:[\/]{2})?(www\.)?([-a-zA-Z0-9]{2,256}\.[a-z]{2,6}\b[-a-zA-Z0-9@:%_\+.~#?{&amp;}=\/]*)\)/';
	$story['opinion_text'] = preg_replace($regex,"<a href=\"https://www.$4\">$1</a>",$story['opinion_text']);

	$regex_user = '/\/u\/([-a-zA-Z0-9]+)/';
	$story['opinion_text'] = preg_replace($regex_user, "<a href=\"profile.php?username=$1\">$0</a>",$story['opinion_text']);

	$regex_channel = '/\/c\/([-a-zA-Z0-9]+)/';
	$story['opinion_text'] = preg_replace($regex_channel, "<a href=\"stories.php?channel=$1\">$0</a>",$story['opinion_text']);

	$now = time();

	$username = getUserName($story['user_id']);
	$score = getScore($story_id);

	if(isset($_SESSION['user_id']))
		$vote = getVote($story_id, $_SESSION['user_id']);

	$page = 'story.php?story_id='.$story_id;

	draw_header(true);
?>

	<section id="story" data-id="<?=$story_id?>">
		<div class = "container">
			<div class = "votes-container">
				<div class="upvote" role="button" data-value="<?=$vote?>"><i class="fas fa-arrow-circle-up"></i></div>
				<h5><?=htmlentities($score)?></h5>
				<div class="downvote" role="button" data-value="<?=$vote?>"><i class="fas fa-arrow-circle-down"></i></div>
			</div>
			<div class = "story-content">
			<h2><?=htmlentities($story['opinion_title'])?></h2>
			<h3><?php
				$lines = explode(PHP_EOL, $story['opinion_text']);
				foreach($lines as $line) { ?>
					<p><?=$line?></p>
			<?php } ?></h3>
			<?php 
			$number_comments = getNumberComments($story_id);
			if($number_comments == 1){ ?>
				<h4><?=$number_comments?> comment</h4>
			<?php } else { ?>
				<h4><?=$number_comments?> comments</h4>
			<?php } ?>
			<h4>Posted by <a href="<?='profile.php?username='.urlencode($username)?>"><?=htmlentities($username)?></a> <?=deltaTime($now, $story['posted'])?></h4>
			</div>
		</div>
	</section>

<?php
	$comments = array_reverse(getAllComments($story_id));

	for($i = 0; $i < count($comments); $i++){
		$comments[$i]['username'] = getUserName($comments[$i]['user_id']);
		$comments[$i]['score'] = getScore($comments[$i]['opinion_id']);
		
		if(isset($_SESSION['user_id']))
			$comments[$i]['vote'] = getVote($comments[$i]['opinion_id'], $_SESSION['user_id']);
	}

	draw_comments_header($comments,true);

	draw_footer();
?>