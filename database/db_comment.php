<?php
	include_once('../includes/database.php');
	
	function addComment($user_id, $parent_id, $comment) {
		$db = Database::instance()->db();
        $stmt = $db->prepare('INSERT INTO opinion VALUES(NULL, ?, NULL, ?, datetime("now"), ?)');
		$stmt->execute(array($parent_id, $comment, $user_id));
	}

	function getAllComments($parent_id) {
		$db = Database::instance()->db();
		$stmt = $db->prepare('SELECT * FROM opinion WHERE parent_id IS ?');
		$stmt->execute(array($parent_id));
		return $stmt->fetchAll();
	}
?>