<?php
	include_once('../includes/database.php');
	
	function getStoriesSearch($search) {
		$db = Database::instance()->db();
		$stmt = $db->prepare('SELECT * FROM opinion WHERE ((opinion_title like ?) OR (opinion_text like ?)) AND parent_id IS NULL');
		$stmt->execute(array("%$search%", "%$search%"));
		return $stmt->fetchAll();
    }
    
    function getCommentsSearch($search) {
		$db = Database::instance()->db();
		$stmt = $db->prepare('SELECT * FROM opinion WHERE (opinion_text like ?) AND parent_id NOT NULL');
		$stmt->execute(array("%$search%"));
		return $stmt->fetchAll();
    }
    
    function getUsersSearch($search) {
		$db = Database::instance()->db();
		$stmt = $db->prepare('SELECT user_id, username FROM user WHERE (username like ?)');
		$stmt->execute(array("%$search%"));
		return $stmt->fetchAll();
	}
?>