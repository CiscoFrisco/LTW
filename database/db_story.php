<?php
	include_once('../includes/database.php');
	
	function insertStory($user_id, $title, $story) {
		$db = Database::instance()->db();
        $stmt = $db->prepare('INSERT INTO story VALUES(NULL, ?, ?, ?)');
        $stmt->execute(array($title, $story, $user_id));
	}

	function getAllStories() {
		$db = Database::instance()->db();
		$stmt = $db->prepare('SELECT * FROM story');
		$stmt->execute();
		return $stmt->fetchAll();
	}

	function getStory($story_id) {
		$db = Database::instance()->db();
		$stmt = $db->prepare('SELECT * FROM story WHERE story_id = ?');
		$stmt->execute(array($story_id));
		return $stmt->fetch();
	}
?>