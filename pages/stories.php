<?php 
	include_once('../includes/session.php');
	include_once('../includes/date.php');
	include_once('../database/db_story.php');
	include_once('../database/db_user.php');
	include_once('../database/db_vote.php');
	include_once('../templates/tpl_common.php');
	include_once('../templates/tpl_stories.php');


	if(isset($_GET['sort_code'])){
		$sort = intval($_GET['sort_code']);
	}
	
	$stories = array_reverse(getAllStories());
	$now = time();

	for($i = 0; $i < count($stories); $i++){
		$stories[$i]['username'] = getUserName($stories[$i]['user_id']);
		$stories[$i]['score'] = getScore($stories[$i]['opinion_id']);
		$stories[$i]['comments']= getNumberComments($stories[$i]['opinion_id']);

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

	$page = 'stories.php';

	draw_header(true);
	draw_stories($stories,true);
	draw_footer();
?>