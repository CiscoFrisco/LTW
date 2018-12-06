<?php 
	include_once('../includes/session.php');
	include_once('../includes/date.php');
	include_once('../database/db_comment.php');
	include_once('../database/db_user.php');
	include_once('../database/db_vote.php');

	if (!isset($_SESSION['user_id']))
		die(json_encode(array('error' => 'not_logged_in')));

	if (!isset($_POST['parent_id']) || !isset($_POST['comment']))
		die(json_encode(array('error' => 'no_comment_information')));

	$user_id = $_SESSION['user_id'];
	$parent_id = $_POST['parent_id'];
	$comment = $_POST['comment'];

	addComment($user_id, $parent_id, $comment, $comment_id);
	addVote($comment_id, $user_id, 1);

	$opinions['comment_id'] = $comment_id;
	$opinions['username'] = getUserName($user_id);
	$opinions['comment'] = $comment;

	$opinions['vote'] = 1;
	$opinions['score'] = 1;
	
	echo json_encode($opinions);
?>