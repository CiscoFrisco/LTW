<?php
	include_once('../includes/database.php');

	function getScore($opinion_id){
		$db = Database::instance()->db();
		$stmt = $db->prepare('SELECT count(*) AS score FROM vote WHERE opinion_id = ? AND value = 1');
		$stmt->execute(array($opinion_id));
		$upvotes = $stmt->fetch()['score'];
		$stmt = $db->prepare('SELECT count(*) AS score FROM vote WHERE opinion_id = ? AND value = -1');
		$stmt->execute(array($opinion_id));
		$downvotes = $stmt->fetch()['score'];
		return $upvotes - $downvotes;
	}

	function addVote($opinion_id, $user_id, $value){
		$db = Database::instance()->db();
        $stmt = $db->prepare('INSERT INTO vote VALUES(?, ?, ?)');
		$stmt->execute(array($opinion_id, $user_id, $value));
	}

	function removeVote($opinion_id, $user_id){
		$db = Database::instance()->db();
        $stmt = $db->prepare('DELETE FROM vote WHERE opinion_id = ? AND user_id = ?');
		$stmt->execute(array($opinion_id, $user_id));
	}

	function getVote($opinion_id, $user_id){
		$db = Database::instance()->db();
		$stmt = $db->prepare('SELECT value FROM vote WHERE opinion_id = ? AND user_id = ?');
		$stmt->execute(array($opinion_id, $user_id));
		$value = $stmt->fetch();

		if($value)
			return $value['value'];

		return 0;
	}
?>