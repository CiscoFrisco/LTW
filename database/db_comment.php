<?php
	include_once('../includes/database.php');
	
	function addComment($user_id, $parent_id, $comment, &$comment_id) {
		$db = Database::instance()->db();
        $stmt = $db->prepare('INSERT INTO opinion VALUES(NULL, ?, NULL, ?, datetime("now"), ?)');
		$stmt->execute(array($parent_id, $comment, $user_id));
		$stmt = $db->prepare('SELECT opinion_id FROM opinion WHERE parent_id IS ? AND opinion_title IS NULL AND opinion_text = ? AND user_id = ?');
		$stmt->execute(array($parent_id, $comment, $user_id));
		$comments = $stmt->fetchAll();
		$comment_id = $comments[count($comments)-1]['opinion_id'];
	}

	function getAllComments($parent_id) {
		$db = Database::instance()->db();
		$stmt = $db->prepare('SELECT * FROM opinion WHERE parent_id IS ?');
		$stmt->execute(array($parent_id));
		return $stmt->fetchAll();
	}
?>