<?php
	include_once('../includes/database.php');
	
	function insertStory($user_id, $title, $story) {
		$db = Database::instance()->db();
        $stmt = $db->prepare('INSERT INTO opinion VALUES(NULL, NULL, ?, ?, datetime("now"), ?)');
        $stmt->execute(array($title, $story, $user_id));
	}

	function getAllStories() {
		$db = Database::instance()->db();
		$stmt = $db->prepare('SELECT * FROM opinion WHERE parent_id IS NULL');
		$stmt->execute();
		return $stmt->fetchAll();
	}

	function getStory($story_id) {
		$db = Database::instance()->db();
		$stmt = $db->prepare('SELECT * FROM opinion WHERE opinion_id = ? AND parent_id IS NULL');
		$stmt->execute(array($story_id));
		return $stmt->fetch();
	}
?>