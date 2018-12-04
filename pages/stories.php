<?php 
	include_once('../includes/session.php');
	include_once('../includes/date.php');
	include_once('../database/db_story.php');
	include_once('../database/db_user.php');
	include_once('../database/db_vote.php');
	include_once('../templates/tpl_common.php');
	include_once('../templates/tpl_stories.php');

	$stories = array_reverse(getAllStories());
	$now = time();

	for($i = 0; $i < count($stories); $i++){
		$stories[$i]['username'] = getUserName($stories[$i]['user_id']);
		$stories[$i]['score'] = getScore($stories[$i]['opinion_id']);

		if(isset($_SESSION['user_id']))
			$stories[$i]['vote'] = getVote($stories[$i]['opinion_id'], $_SESSION['user_id']);
	}

	draw_header(true);
	draw_stories($stories);
	draw_footer();
?>