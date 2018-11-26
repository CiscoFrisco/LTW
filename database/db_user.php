<?php
	include_once('../includes/database.php');
	
	function insertUser(&$user_id, $username, $email, $password) {
		$db = Database::instance()->db();
        $stmt = $db->prepare('INSERT INTO user VALUES(NULL, ?, ?, ?, NULL, NULL)');
		$stmt->execute(array($username, $email, password_hash($password,PASSWORD_DEFAULT)));
		$stmt = $db->prepare('SELECT user_id FROM user WHERE username = ?');
		$stmt->execute(array($username));
		$user = $stmt->fetch();
		$user_id = $user['user_id'];
	}

	function checkUserPassword(&$user_id, $username, $password) {
		$db = Database::instance()->db();
		$stmt = $db->prepare('SELECT * FROM user WHERE username = ?');
		$stmt->execute(array($username));
		$user = $stmt->fetch();
		$user_id = $user['user_id'];
		return password_verify($password, $user['password']);
	}

	function getUserInfo($user_id, &$username, &$realname, &$bio) {
		$db = Database::instance()->db();
		$stmt = $db->prepare('SELECT * FROM user WHERE user_id = ?');
		$stmt->execute(array($user_id));
		$user = $stmt->fetch();
		$username = $user['username'];
		$realname = $user['realname'];
		$bio = $user['bio'];
	}

	function editUserInfo($user_id, $username, $realname, $bio) {
		$db = Database::instance()->db();
		$stmt = $db->prepare('UPDATE user SET username = ?, realname = ?, bio = ? WHERE user_id = ?');
		$stmt->execute(array($username, $realname, $bio, $user_id));
	}
?>