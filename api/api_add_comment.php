<?php 
	include_once('../includes/session.php');
	include_once('../database/db_comment.php');

	if (!isset($_SESSION['user_id']))
		die(json_encode(array('error' => 'not_logged_in')));

	if (!isset($_POST['parent_id']) || !isset($_POST['comment']))
		die(json_encode(array('error' => 'no_comment_information')));

	$user_id = $_SESSION['user_id'];
	$parent_id = $_POST['parent_id'];
	$comment = $_POST['comment'];

	addComment($user_id, $parent_id, $comment);
	
	echo json_encode($comment);
?>