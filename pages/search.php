<?php 
    include_once('../includes/session.php');
    include_once('../database/db_search.php');
    include_once('../database/db_user.php');
    include_once('../database/db_vote.php');
    include_once('../templates/tpl_comments.php');
    include_once('../templates/tpl_common.php');
    include_once('../templates/tpl_stories.php');

	$search = $_GET['search'];
	global $now;
    $stories = array_reverse(getStoriesSearch($search));
    $comments = array_reverse(getCommentsSearch($search));
    $users = getUsersSearch($search);

	for($i = 0; $i < count($stories); $i++){
		$stories[$i]['username'] = getUserName($stories[$i]['user_id']);
		$stories[$i]['score'] = getScore($stories[$i]['opinion_id']);
		$stories[$i]['comments']= getNumberComments($stories[$i]['opinion_id']);

		if(isset($_SESSION['user_id']))
			$stories[$i]['vote'] = getVote($stories[$i]['opinion_id'], $_SESSION['user_id']);
	}

    draw_header(true);
    
    if(isset($stories))
        draw_stories($stories,false);

    if(isset($comments))
        draw_comments_header($comments,false);
    
    if(isset($users))
        //draw_users($users);

	draw_footer();
?>