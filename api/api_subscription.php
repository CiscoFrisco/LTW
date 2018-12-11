<?php 
	include_once('../includes/session.php');
	include_once('../database/db_channel.php');

	if ($_SESSION['csrf'] !== $_POST['csrf'])
		die(json_encode(array('error' => 'csrf')));

	if (!isset($_SESSION['user_id']))
		die(json_encode(array('error' => 'not_logged_in'))); 

	if (!isset($_POST['channel_id']) || !isset($_POST['value']))
		die(json_encode(array('error' => 'no_channel_information')));

	$user_id = $_SESSION['user_id'];
	$channel_id = $_POST['channel_id'];
	$value = $_POST['value'];

	if($value == "true")
		subscribeChannel($user_id, $channel_id);

	else
		unsubscribeChannel($user_id, $channel_id);

	$subscription['channel_id'] = $channel_id;
	$subscription['value'] = $value;

	echo json_encode($subscription);
?>