<?php 
	include_once('../includes/session.php');
	include_once('../includes/date.php');
	include_once('../database/db_story.php');
	include_once('../database/db_user.php');
	include_once('../database/db_vote.php');
	include_once('../database/db_channel.php');
	include_once('../templates/tpl_common.php');
	include_once('../templates/tpl_stories.php');


	if(isset($_GET['sort_code'])){
		$sort = intval($_GET['sort_code']);
	}
	
	if(isset($_GET['subscribed']) && $_GET['subscribed'] == 'true'){
		if(!isset($_SESSION['user_id']))
			die(header('Location: ../index.php'));

		$stories = array_reverse(getAllSubscribedStories($_SESSION['user_id']));
	}

	else if(isset($_GET['channel'])){
		$channel = urldecode($_GET['channel']);

		if(!channel_exists($channel))
			die(header('Location: 404.php'));

		if (isset($_SESSION['user_id'])){
			$channel_id = getChannelID($channel);
			$subscribed = checkSubscription($channel_id, $_SESSION['user_id']);
		}

		$stories = array_reverse(getAllChannelStories(urldecode($channel)));
	}
	
	else $stories = array_reverse(getAllStories());
	$now = time();

	for($i = 0; $i < count($stories); $i++){
		$stories[$i]['username'] = getUserName($stories[$i]['user_id']);
		$stories[$i]['score'] = getScore($stories[$i]['opinion_id']);
		$stories[$i]['comments']= getNumberComments($stories[$i]['opinion_id']);
		$stories[$i]['channel_name']= getChannelName($stories[$i]['channel_id']);

		if(isset($_SESSION['user_id']))
			$stories[$i]['vote'] = getVote($stories[$i]['opinion_id'], $_SESSION['user_id']);
	}

	function getStoriesElem($element, $stories){
		$elements = array();
		
		foreach ($stories as $key => $row){
			$elements[$key] = $row[$element];
		}

		return $elements;
	}

	if(isset($sort)){
		switch($sort){
			case '0': break;
			case '1': 
				$comments = getStoriesElem('comments', $stories);
				array_multisort($comments, SORT_DESC, $stories);
				break;
			case '2':  
				$votes = getStoriesElem('score', $stories);
				array_multisort($votes, SORT_DESC, $stories);
				break;
			case '3':
				$votes = getStoriesElem('score', $stories);
				array_multisort($votes, SORT_ASC, $stories);
				break;
			default:break;

		}
	}

	if(isset($_GET['subscribed']) && $_GET['subscribed'] == 'true'){
		$page = 'stories.php?subscribed=true';
	}

	else if(isset($_GET['channel'])){
		$page = 'stories.php?channel='.$_GET['channel'];
	}

	else $page = 'stories.php';

	draw_header(true);
	draw_stories($stories,true);
	draw_footer();
?>