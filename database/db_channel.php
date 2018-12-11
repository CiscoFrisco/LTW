<?php
	include_once('../includes/database.php');

	function getAllChannels() {
		$db = Database::instance()->db();
		$stmt = $db->prepare('SELECT * FROM channel');
		$stmt->execute();
		return $stmt->fetchAll();
	}

	function insertChannel($channelName) {
		$db = Database::instance()->db();
		$stmt = $db->prepare('INSERT INTO channel VALUES(NULL, ?)');
		$stmt->execute(array($channelName));
	}

	function subscribeChannel($user_id, $channel_id){
		$db = Database::instance()->db();
		$stmt = $db->prepare('INSERT INTO subscription VALUES(?, ?)');
		$stmt->execute(array($user_id, $channel_id));
	}

	function unsubscribeChannel($user_id, $channel_id){
		$db = Database::instance()->db();
		$stmt = $db->prepare('DELETE FROM subscription WHERE user_id = ? AND channel_id = ?');
		$stmt->execute(array($user_id, $channel_id));
	}

	function getAllSubscribedChannel($user_id){
		$db = Database::instance()->db();
		$stmt = $db->prepare('SELECT channel_name FROM subscription NATURAL JOIN channel WHERE user_id = ?');
		$stmt->execute(array($user_id));
		return $stmt->fetchAll();
	}
?>