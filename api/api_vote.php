<?php 
	include_once('../includes/session.php');
	include_once('../database/db_vote.php');

	if ($_SESSION['csrf'] !== $_POST['csrf'])
		die(json_encode(array('error' => 'csrf')));

	if (!isset($_SESSION['user_id']))
		die(json_encode(array('error' => 'not_logged_in')));

	if (!isset($_POST['opinion_id']) || !isset($_POST['value']))
		die(json_encode(array('error' => 'no_vote_information')));

	$user_id = $_SESSION['user_id'];
	$opinion_id = $_POST['opinion_id'];
	$value = $_POST['value'];

	if($value != 0)
	{
		try {
			addVote($opinion_id, $user_id, $value);
		} catch (PDOException $e) {
			removeVote($opinion_id, $user_id);
			addVote($opinion_id, $user_id, $value);
		}
	}

	else removeVote($opinion_id, $user_id);

	$vote['opinion_id'] = $opinion_id;
	$vote['value'] = $value;

	echo json_encode($vote);
?>